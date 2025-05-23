import Chart from 'chart.js';

// Toggle Menu
const hamburger = document.querySelector('.hamburger');
const navLinks = document.querySelector('.nav-links');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

// Testimonial Slider
const testimonialSlides = document.querySelector('.testimonial-slides');
const dots = document.querySelectorAll('.control-dot');
let currentSlide = 0;

function showSlide(index) {
    testimonialSlides.style.transform = `translateX(-${index * 100}%)`;
    dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === index);
    });
    currentSlide = index;
}

dots.forEach((dot, index) => {
    dot.addEventListener('click', () => {
        showSlide(index);
    });
});

// Auto Slide
setInterval(() => {
    let nextSlide = (currentSlide + 1) % dots.length;
    showSlide(nextSlide);
}, 5000);

// Back to Top Button
const backToTopButton = document.querySelector('.back-to-top');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.add('visible');
    } else {
        backToTopButton.classList.remove('visible');
    }
});

backToTopButton.addEventListener('click', (e) => {
    e.preventDefault();
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Shopping Cart Counter
const addToCartButtons = document.querySelectorAll('.add-to-cart');
const cartCount = document.querySelector('.cart-count');
let count = 0;

addToCartButtons.forEach(button => {
    button.addEventListener('click', () => {
        count++;
        cartCount.textContent = count;
        
        // Animation effect
        button.textContent = 'Ditambahkan!';
        button.style.backgroundColor = '#165d42';
        
        setTimeout(() => {
            button.textContent = 'Tambah ke Keranjang';
            button.style.backgroundColor = '';
        }, 1000);
    });
});

// Sticky Header
const header = document.querySelector('header');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 100) {
        header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
        header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    } else {
        header.style.backgroundColor = 'var(--white)';
        header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
    }
});

// Smooth Scrolling for Anchor Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        
        const targetId = this.getAttribute('href');
        if (targetId === '#') return;
        
        const targetElement = document.querySelector(targetId);
        if (targetElement) {
            const headerHeight = document.querySelector('header').offsetHeight;
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
            
            // Close mobile menu if open
            if (navLinks.classList.contains('active')) {
                navLinks.classList.remove('active');
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    // Menu List Page Functions
    initMenuFilters();
    
    // Product Detail Page Functions
    initProductDetail();
    
    // Auth Forms Validation
    initAuthForms();
});

// ====== MENU LIST PAGE FUNCTIONS ======
function initMenuFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    if (filterButtons.length) {
        filterButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                // Remove active class from all buttons
                filterButtons.forEach(b => b.classList.remove('active'));
                
                // Add active class to clicked button
                this.classList.add('active');
                
                // Get category from data attribute
                const category = this.getAttribute('data-category');
                
                // Filter products based on category
                filterProducts(category);
            });
        });
    }
    
    // Search functionality
    const searchInput = document.querySelector('.search-bar input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            searchProducts(searchTerm);
        });
    }
}

function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productCategory = product.getAttribute('data-category');
        
        if (category === 'all' || productCategory === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

function searchProducts(searchTerm) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const productName = product.querySelector('h4').textContent.toLowerCase();
        const productDesc = product.querySelector('.description').textContent.toLowerCase();
        
        if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// ====== PRODUCT DETAIL PAGE FUNCTIONS ======
function initProductDetail() {
    // Gallery thumbnails
    const thumbnails = document.querySelectorAll('.thumbnail');
    const mainImage = document.querySelector('.main-image img');
    
    if (thumbnails.length && mainImage) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                // Update main image src
                const imgSrc = this.querySelector('img').getAttribute('src');
                mainImage.setAttribute('src', imgSrc);
                
                // Update active thumbnail
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
    
    // Product Tabs
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    if (tabButtons.length && tabContents.length) {
        tabButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.getAttribute('data-tab');
                
                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });
                
                // Show selected tab content
                document.getElementById(target).classList.add('active');
                
                // Update active tab button
                tabButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });
    }
}

// ====== AUTH FORMS FUNCTIONS ======
function initAuthForms() {
    // Password visibility toggle
    const passwordToggles = document.querySelectorAll('.password-toggle i');
    
    if (passwordToggles.length) {
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', function() {
                const passwordInput = this.previousElementSibling;
                
                // Toggle password visibility
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
            });
        });
    }
    
    // Form validation
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');
    const forgotPasswordForm = document.getElementById('forgot-password-form');
    
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelector('input[type="password"]').value;
            let isValid = true;
            
            // Reset validation messages
            resetValidationMessages(this);
            
            // Validate email
            if (!validateEmail(email)) {
                showValidationMessage(this.querySelector('input[type="email"]'), 'Email tidak valid');
                isValid = false;
            }
            
            // Validate password
            if (password.length < 6) {
                showValidationMessage(this.querySelector('input[type="password"]'), 'Password minimal 6 karakter');
                isValid = false;
            }
            
            // If form is valid, submit (would normally send to server)
            if (isValid) {
                // Simulate login success
                simulateFormSubmission();
            }
        });
    }
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const name = this.querySelector('input[name="name"]').value;
            const email = this.querySelector('input[type="email"]').value;
            const password = this.querySelector('input[name="password"]').value;
            const confirmPassword = this.querySelector('input[name="confirm_password"]').value;
            let isValid = true;
            
            // Reset validation messages
            resetValidationMessages(this);
            
            // Validate name
            if (name.trim() === '') {
                showValidationMessage(this.querySelector('input[name="name"]'), 'Nama tidak boleh kosong');
                isValid = false;
            }
            
            // Validate email
            if (!validateEmail(email)) {
                showValidationMessage(this.querySelector('input[type="email"]'), 'Email tidak valid');
                isValid = false;
            }
            
            // Validate password
            if (password.length < 6) {
                showValidationMessage(this.querySelector('input[name="password"]'), 'Password minimal 6 karakter');
                isValid = false;
            }
            
            // Validate password confirmation
            if (password !== confirmPassword) {
                showValidationMessage(this.querySelector('input[name="confirm_password"]'), 'Password tidak sama');
                isValid = false;
            }
            
            // If form is valid, submit
            if (isValid) {
                simulateFormSubmission();
            }
        });
    }
    
    if (forgotPasswordForm) {
        forgotPasswordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = this.querySelector('input[type="email"]').value;
            let isValid = true;
            
            // Reset validation messages
            resetValidationMessages(this);
            
            // Validate email
            if (!validateEmail(email)) {
                showValidationMessage(this.querySelector('input[type="email"]'), 'Email tidak valid');
                isValid = false;
            }
            
            // If form is valid, submit
            if (isValid) {
                // Show success message for forgot password
                const successMessage = document.createElement('div');
                successMessage.className = 'success-message';
                successMessage.textContent = 'Link reset password telah dikirim ke email Anda.';
                
                // Insert before the form
                this.parentNode.insertBefore(successMessage, this);
                
                // Reset form
                this.reset();
            }
        });
    }
}

// Helper functions for validation
function validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function showValidationMessage(inputElement, message) {
    const validationMsg = document.createElement('div');
    validationMsg.className = 'validation-message';
    validationMsg.textContent = message;
    validationMsg.style.display = 'block';
    
    // Insert after the input
    inputElement.parentNode.appendChild(validationMsg);
    
    // Highlight input
    inputElement.style.borderColor = '#e53935';
}

function resetValidationMessages(form) {
    // Remove all validation messages
    const messages = form.querySelectorAll('.validation-message');
    messages.forEach(msg => msg.remove());
    
    // Reset input styles
    const inputs = form.querySelectorAll('input');
    inputs.forEach(input => {
        input.style.borderColor = '';
    });
}

function simulateFormSubmission() {
    // This would normally send data to the server
    // For demonstration, just redirect to home after a delay
    setTimeout(() => {
        window.location.href = 'index.html';
    }, 1000);
}
document.addEventListener('DOMContentLoaded', function() {
    // Cart Item Quantity Buttons
    const decreaseBtns = document.querySelectorAll('.cart-item .quantity-btn.decrease');
    const increaseBtns = document.querySelectorAll('.cart-item .quantity-btn.increase');
    const quantityInputs = document.querySelectorAll('.cart-item .quantity-input');
    const removeButtons = document.querySelectorAll('.remove-item');
    const clearCartButton = document.querySelector('.clear-cart');
    const updateCartButton = document.querySelector('.update-cart');

    // Calculate individual item subtotals
    function calculateItemSubtotal(quantityInput) {
        const item = quantityInput.closest('.cart-item');
        const price = parseInt(item.querySelector('.item-price').textContent.replace(/\D/g, ''));
        const quantity = parseInt(quantityInput.value);
        const subtotal = price * quantity;
        
        item.querySelector('.subtotal-price').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        
        updateCartTotal();
    }

    // Update entire cart total
    function updateCartTotal() {
        let subtotal = 0;
        document.querySelectorAll('.cart-item').forEach(item => {
            subtotal += parseInt(item.querySelector('.subtotal-price').textContent.replace(/\D/g, ''));
        });
        
        const shipping = 15000; // Biaya pengiriman tetap
        const total = subtotal + shipping;
        
        document.querySelector('.summary-item:first-child span:last-child').textContent = `Rp ${subtotal.toLocaleString('id-ID')}`;
        document.querySelector('.summary-total span:last-child').textContent = `Rp ${total.toLocaleString('id-ID')}`;
    }

    // Initialize quantity buttons
    decreaseBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInputs[index].value);
            if (currentValue > 1) {
                quantityInputs[index].value = currentValue - 1;
                calculateItemSubtotal(quantityInputs[index]);
            }
        });
    });

    increaseBtns.forEach((btn, index) => {
        btn.addEventListener('click', function() {
            const currentValue = parseInt(quantityInputs[index].value);
            quantityInputs[index].value = currentValue + 1;
            calculateItemSubtotal(quantityInputs[index]);
        });
    });

    // Update subtotal when quantity changes manually
    quantityInputs.forEach(input => {
        input.addEventListener('change', function() {
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) {
                this.value = 1;
                value = 1;
            }
            calculateItemSubtotal(this);
        });
    });

    // Remove item functionality
    removeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const item = this.closest('.cart-item');
            item.style.opacity = '0';
            setTimeout(() => {
                item.remove();
                
                // Update cart count 
                const cartCountElement = document.querySelector('.cart-count');
                let count = parseInt(cartCountElement.textContent) - 1;
                cartCountElement.textContent = count;
                
                // Update cart item count in heading
                const itemsCountElement = document.querySelector('.cart-items h3');
                itemsCountElement.textContent = `Produk dalam Keranjang (${count})`;
                
                updateCartTotal();
                
                // If no items left, show empty cart message
                if (count === 0) {
                    const cartItems = document.querySelector('.cart-items');
                    const emptyMessage = document.createElement('div');
                    emptyMessage.className = 'empty-cart-message';
                    emptyMessage.innerHTML = `
                        <i class="fas fa-shopping-cart"></i>
                        <p>Keranjang belanja Anda kosong.</p>
                        <a href="menu.html" class="btn">Belanja Sekarang</a>
                    `;
                    cartItems.appendChild(emptyMessage);
                }
            }, 300);
            item.style.transition = 'opacity 0.3s ease';
        });
    });

    // Clear cart functionality
    if (clearCartButton) {
        clearCartButton.addEventListener('click', function() {
            if (confirm('Apakah Anda yakin ingin mengosongkan keranjang?')) {
                const cartItems = document.querySelectorAll('.cart-item');
                cartItems.forEach(item => {
                    item.remove();
                });
                
                // Update cart count
                document.querySelector('.cart-count').textContent = '0';
                document.querySelector('.cart-items h3').textContent = 'Produk dalam Keranjang (0)';
                
                // Show empty cart message
                const cartItemsContainer = document.querySelector('.cart-items');
                const emptyMessage = document.createElement('div');
                emptyMessage.className = 'empty-cart-message';
                emptyMessage.innerHTML = `
                    <i class="fas fa-shopping-cart"></i>
                    <p>Keranjang belanja Anda kosong.</p>
                    <a href="menu.html" class="btn">Belanja Sekarang</a>
                `;
                cartItemsContainer.appendChild(emptyMessage);
                
                updateCartTotal();
            }
        });
    }

    // Update cart button functionality
    if (updateCartButton) {
        updateCartButton.addEventListener('click', function() {
            // Simulate cart update
            this.textContent = 'Diperbarui!';
            this.style.backgroundColor = '#165d42';
            
            setTimeout(() => {
                this.textContent = 'Perbarui Keranjang';
                this.style.backgroundColor = '';
            }, 1000);
            
            updateCartTotal();
        });
    }

    // Calculate initial totals
    updateCartTotal();
});

const addProductBtn = document.getElementById('addProductBtn');
const productFormSection = document.getElementById('productFormSection');
const cancelFormBtn = document.getElementById('cancelFormBtn');
const formTitle = document.getElementById('formTitle');
const productForm = document.getElementById('productForm');

addProductBtn.addEventListener('click', () => {
    productFormSection.classList.add('active');
    formTitle.textContent = 'Tambah Menu Baru';
    productForm.reset(); // Reset form for new product
});

cancelFormBtn.addEventListener('click', () => {
    productFormSection.classList.remove('active');
});

// Logika untuk tombol edit bisa ditambahkan di sini (misal: mengisi form dengan data produk yang dipilih)
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', () => {
        productFormSection.classList.add('active');
        formTitle.textContent = 'Edit Menu';
        // Di sini tambahkan logika untuk mengisi form dengan data produk yang relevan
        // Contoh: productForm.elements['productName'].value = 'Nama Produk dari baris tabel';
    });
});

// Image Preview
document.getElementById('productImage').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    const file = e.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.style.display = 'block';
            preview.querySelector('img').src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
});

// Form Submission
document.getElementById('addMenuForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Here you would typically handle the form submission
    // For now, we'll just show a success message
    alert('Menu berhasil ditambahkan!');
    window.location.href = 'menu.html';
});

// Order Management Functions
function updateOrderStatus(orderId) {
    // Implement order status update logic
    console.log('Updating status for order:', orderId);
}

// Initialize Charts (using Chart.js)
document.addEventListener('DOMContentLoaded', function() {
    // Sales Trend Chart
    const salesTrendCtx = document.getElementById('salesTrendChart').getContext('2d');
    new Chart(salesTrendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], // Replace with dynamic data
            datasets: [{
                label: 'Penjualan',
                data: [65, 59, 80, 81, 56, 55], // Replace with dynamic data
                borderColor: '#4CAF50', // Use a color from your theme if available
                tension: 0.1,
                fill: false // Line chart without filling area below
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
             scales: { // Example scales options
                y: {
                    beginAtZero: true
                }
            },
            plugins: { // Example plugins options
                legend: {
                    display: true
                }
            }
        }
    });

    // Product Performance Chart
    const productPerformanceCtx = document.getElementById('productPerformanceChart').getContext('2d');
    new Chart(productPerformanceCtx, {
        type: 'bar',
        data: {
            labels: ['Espresso', 'Latte', 'Cappuccino', 'Mocha', 'Americano'], // Replace with dynamic data
            datasets: [{
                label: 'Jumlah Terjual',
                data: [120, 95, 85, 70, 60], // Replace with dynamic data
                backgroundColor: '#4CAF50' // Use a color from your theme if available
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: { // Example scales options
                y: {
                    beginAtZero: true
                }
            },
             plugins: { // Example plugins options
                legend: {
                    display: true
                }
            }
        }
    });
});

// Print Report Function
function printReport() {
    window.print();
}

// Filter Report Function
function filterReport() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    // Implement filter logic here:
    // 1. Fetch data from backend based on startDate and endDate
    // 2. Update the summary cards, charts, and product table with the new data
    console.log('Filtering report from', startDate, 'to', endDate);
    // Example: You might use fetch() API to call a backend endpoint
    // fetch('/admin/reports/sales?start_date=' + startDate + '&end_date=' + endDate)
    // .then(response => response.json())
    // .then(data => {
    //     // Update HTML elements with data
    //     document.querySelector('.summary-cards .card:nth-child(1) .card-value').innerText = data.totalSales;
    //     // Update charts and table data
    // });
}