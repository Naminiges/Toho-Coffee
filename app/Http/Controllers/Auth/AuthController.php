<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    // ==================== REGISTER METHODS ====================
    
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration process - DIPERBAIKI
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', 'unique:users,email'],
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Buat user baru dengan email_verified_at = null (belum terverifikasi)
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user',
                'user_status' => $request->user_status ?? 'aktif',
                'email_verified_at' => null, // PENTING: Set null untuk email belum terverifikasi
            ]);

            // Login user setelah register (untuk bisa mengakses halaman verifikasi)
            Auth::login($user);

            // Trigger event untuk mengirim email verifikasi
            event(new Registered($user));

            // PERBAIKAN: Redirect ke halaman verify email, bukan login
            return redirect()->route('verification.notice')
                ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk verifikasi akun.');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['register' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    // ==================== EMAIL VERIFICATION METHODS ====================
    
    /**
     * Show email verification notice - DIPERBAIKI
     */
    public function showVerificationNotice()
    {
        // Jika user belum login, redirect ke login
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Check if email is already verified
        if (Auth::user()->hasVerifiedEmail()) {
            return redirect()->route('welcome')
                ->with('success', 'Email Anda sudah terverifikasi.');
        }

        return view('auth.verify-email');
    }

    /**
     * Handle email verification - DIPERBAIKI
     */
    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();
        
        // PERBAIKAN: Redirect ke halaman utama setelah verifikasi berhasil
        return redirect()->route('welcome')
            ->with('success', 'Email berhasil diverifikasi! Selamat datang di TOHO Coffee.');
    }

    /**
     * Resend verification email
     */
    public function resendVerificationEmail(Request $request)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda harus login terlebih dahulu.',
                'redirect' => route('login')
            ], 401);
        }

        // Check if email is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Email sudah terverifikasi.'
            ]);
        }

        try {
            $request->user()->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Link verifikasi email telah dikirim ulang. Silakan cek email Anda.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Resend verification email error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengirim email. Silakan coba lagi.'
            ], 500);
        }
    }

    // ==================== LOGIN METHODS ====================
    
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Get redirect URL based on user role
     */
    private function getRedirectUrlByRole(string $role): string
    {
        switch ($role) {
            case 'admin':
                return route('admin-dashboard');
            case 'staff':
                return route('staff-dashboard');
            case 'user':
                return route('user-katalog');
            default:
                return route('welcome');
        }
    }

    /**
     * Handle login process - DIPERBAIKI
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'],
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Attempt login
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // PERBAIKAN: Cek apakah email sudah diverifikasi
            if (!Auth::user()->hasVerifiedEmail()) {
                // JANGAN logout user, biarkan tetap login tapi redirect ke verification
                return response()->json([
                    'success' => true, // Tetap true untuk memungkinkan redirect
                    'message' => 'Email Anda belum diverifikasi. Silakan cek email dan klik link verifikasi.',
                    'redirect' => '/email/verify',
                    'message_type' => 'error' // Tentukan tipe pesan sebagai error
                ], 403);
            }
            
            // Redirect berdasarkan role
            $redirectUrl = $this->getRedirectUrlByRole(Auth::user()->role);
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => $redirectUrl
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Email atau password salah.'
        ], 401);
    }

    /**
     * Handle logout process
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')->with('success', 'Berhasil logout.');
    }

    // ==================== FORGOT PASSWORD METHODS ====================
    
    /**
     * Show the forgot password form
     */
    public function showLinkRequestForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect('/');
        }
        
        return view('auth.forgot-password-request');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required', 
                'email', 
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/', 
                'exists:users,email'
            ],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.regex' => 'Email harus menggunakan domain Gmail (@gmail.com).',
            'email.exists' => 'Email tidak terdaftar dalam sistem kami.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // Kirim reset link
            $status = Password::sendResetLink(
                $request->only('email')
            );

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'success' => true,
                    'message' => 'Link reset password telah dikirim ke email Anda. Silakan cek kotak masuk atau folder spam Anda.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim email reset password. Silakan coba lagi nanti.'
            ], 500);
            
        } catch (\Exception $e) {
            \Log::error('Password reset error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'
            ], 500);
        }
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return redirect('/');
        }
        
        return view('auth.forgot-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    /**
     * Handle password reset
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login dengan password baru.');
        }

        return redirect()->back()
            ->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluarsa.'])
            ->withInput($request->only('email'));
    }

    // ==================== UTILITY METHODS ====================
    
    /**
     * Check if user is authenticated (for API)
     */
    public function checkAuth()
    {
        if (Auth::check()) {
            return response()->json([
                'authenticated' => true,
                'user' => [
                    'id' => Auth::user()->id_user, // Menggunakan id_user
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ]
            ]);
        }

        return response()->json([
            'authenticated' => false
        ]);
    }

    /**
     * Get current user profile
     */
    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        return view('profil', [
            'user' => $user
        ]);
    }

    /**
     * Update user profile
     */
    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Validasi untuk update informasi pribadi
        if ($request->has('update_profile')) {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id_user . ',id_user',
                'phone' => 'required|string|max:20',
            ], [
                'first_name.required' => 'Nama depan wajib diisi.',
                'last_name.required' => 'Nama belakang wajib diisi.',
                'email.required' => 'Email wajib diisi.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan oleh user lain.',
                'phone.required' => 'Nomor telepon wajib diisi.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Gagal mengupdate profil. Silakan periksa kembali data yang diisi.');
            }

            try {
                // Gabungkan nama depan dan belakang
                $fullName = $request->first_name . ' ' . $request->last_name;
                
                $user->name = $fullName;
                $user->email = $request->email;
                $user->user_phone = $request->phone;
                $user->save();

                return redirect()->back()->with('success', 'Informasi profil berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['update' => 'Terjadi kesalahan saat memperbarui profil.'])
                    ->withInput()
                    ->with('error', 'Terjadi kesalahan saat menyimpan data.');
            }
        }

        // Validasi untuk update password
        if ($request->has('update_password')) {
            $validator = Validator::make($request->all(), [
                'new_password' => [
                    'required',
                    'string',
                    'min:6',
                    'confirmed'
                ],
                'new_password_confirmation' => 'required|same:new_password',
            ], [
                'new_password.required' => 'Password baru wajib diisi.',
                'new_password.min' => 'Password baru minimal 6 karakter.',
                'new_password.confirmed' => 'Konfirmasi password baru tidak cocok.',
                'new_password_confirmation.required' => 'Konfirmasi password wajib diisi.',
                'new_password_confirmation.same' => 'Konfirmasi password tidak cocok.',
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->with('error', 'Gagal mengupdate password. Silakan periksa kembali data yang diisi.');
            }

            try {
                $user->password = Hash::make($request->new_password);
                $user->save();

                return redirect()->back()->with('success', 'Password berhasil diperbarui.');
            } catch (\Exception $e) {
                return redirect()->back()
                    ->withErrors(['update_password' => 'Terjadi kesalahan saat memperbarui password.'])
                    ->with('error', 'Terjadi kesalahan saat menyimpan password baru.');
            }
        }

        return redirect()->back()->with('error', 'Tidak ada data yang diupdate.');
    }

    // ==================== GOOGLE OAUTH METHODS ====================

    /**
     * Find or create user from Google data
     */
    public function findOrCreateGoogleUser($googleUser)
    {
        // Cari user berdasarkan Google ID
        $user = User::where('google_id', $googleUser->getId())->first();
        
        if ($user) {
            return $user;
        }
        
        // Cari user berdasarkan email
        $user = User::where('email', $googleUser->getEmail())->first();
        
        if ($user) {
            // Update Google ID untuk user yang sudah ada
            $user->update(['google_id' => $googleUser->getId()]);
            return $user;
        }
        
        // Buat user baru
        return User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'password' => Hash::make(Str::random(24)), // Random password
            'role' => 'user',
            'user_status' => 'aktif',
            'email_verified_at' => now(), // Google account sudah terverifikasi
        ]);
    }

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Validasi domain email jika diperlukan
            if (!str_ends_with($googleUser->getEmail(), '@gmail.com')) {
                return redirect()->route('login')
                    ->with('error', 'Hanya email Gmail yang diperbolehkan.');
            }
            
            // Cari atau buat user
            $user = $this->findOrCreateGoogleUser($googleUser);
            
            // Login user
            Auth::login($user, true);
            
            // Regenerate session
            request()->session()->regenerate();
            
            // Redirect berdasarkan role
            $redirectUrl = $this->getRedirectUrlByRole($user->role);
            
            return redirect($redirectUrl)
                ->with('success', 'Berhasil login dengan Google!');
                
        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
        return redirect()->route('login')
            ->with('error', 'Sesi login Google tidak valid. Silakan coba lagi.');
            
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return redirect()->route('login')
                ->with('error', 'Gagal terhubung ke Google. Silakan coba lagi.');
                
        } catch (\Exception $e) {
            \Log::error('Google OAuth Error: ' . $e->getMessage());
            return redirect()->route('login')
                ->with('error', 'Terjadi kesalahan saat login dengan Google. Silakan coba lagi.');
        }
    }
}