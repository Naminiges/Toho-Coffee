<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

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
     * Handle registration process
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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
            // Buat user baru dengan nilai default untuk role dan user_status
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role ?? 'user', // Default role 'user'
                'user_status' => $request->user_status ?? 'aktif', // Default status 'aktif'
            ]);

            // Login user setelah berhasil registrasi
            Auth::login($user);

            // Redirect ke halaman utama
            return redirect('/')->with('success', 'Registrasi berhasil! Selamat datang.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['register' => 'Terjadi kesalahan saat mendaftar. Silakan coba lagi.'])
                ->withInput($request->except('password', 'password_confirmation'));
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
     * Handle login process
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
            
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil!',
                'redirect' => '/'
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
        return view('auth.forgot-password');
    }

    /**
     * Send password reset link
     */
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.exists' => 'Email tidak terdaftar dalam sistem.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Kirim reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => true,
                'message' => 'Link reset password telah dikirim ke email Anda.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengirim email reset password.'
        ], 500);
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.reset-password', [
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
}