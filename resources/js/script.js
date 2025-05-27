// Laravel CSRF Token Configuration
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

// Axios default configuration for Laravel
if (typeof axios !== 'undefined') {
    axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
}

// Utility Functions
const Utils = {
    // Show loading state
    showLoading(element) {
        if (element) {
            element.disabled = true;
            element.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
        }
    },

    // Hide loading state
    hideLoading(element, originalText) {
        if (element) {
            element.disabled = false;
            element.innerHTML = originalText;
        }
    },

    // Show notification
    showNotification(message, type = 'success') {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);
    },

    // Async delay function
    delay(ms) {
        return new Promise(resolve => setTimeout(resolve, ms));
    }
};

// Toggle Menu (Async)
const initMobileMenu = async () => {
    try {
        const hamburger = document.querySelector('.hamburger');
        const navLinks = document.querySelector('.nav-links');

        if (hamburger && navLinks) {
            hamburger.addEventListener('click', async () => {
                navLinks.classList.toggle('active');
                await Utils.delay(100); // Smooth animation
            });
        }
    } catch (error) {
        console.error('Error initializing mobile menu:', error);
    }
};

// Testimonial Slider (Async)
const initTestimonialSlider = async () => {
    try {
        const testimonialSlides = document.querySelector('.testimonial-slides');
        const dots = document.querySelectorAll('.control-dot');
        let currentSlide = 0;

        if (!testimonialSlides || !dots.length) return;

        const showSlide = async (index) => {
            testimonialSlides.style.transform = `translateX(-${index * 100}%)`;
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
            currentSlide = index;
            await Utils.delay(50); // Smooth transition
        };

        dots.forEach((dot, index) => {
            dot.addEventListener('click', async () => {
                await showSlide(index);
            });
        });

        // Auto Slide with async
        const autoSlide = async () => {
            while (true) {
                await Utils.delay(5000);
                let nextSlide = (currentSlide + 1) % dots.length;
                await showSlide(nextSlide);
            }
        };

        autoSlide(); // Start auto sliding
    } catch (error) {
        console.error('Error initializing testimonial slider:', error);
    }
};

// Back to Top Button (Async)
const initBackToTop = async () => {
    try {
        const backToTopButton = document.querySelector('.back-to-top');
        if (!backToTopButton) return;

        window.addEventListener('scroll', async () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });

        backToTopButton.addEventListener('click', async (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
            await Utils.delay(500); // Wait for scroll animation
        });
    } catch (error) {
        console.error('Error initializing back to top:', error);
    }
};

// Shopping Cart (Async with Laravel API)
const initShoppingCart = async () => {
    try {
        const addToCartButtons = document.querySelectorAll('.add-to-cart');
        const cartCount = document.querySelector('.cart-count');

        addToCartButtons.forEach(button => {
            button.addEventListener('click', async (e) => {
                const originalText = button.textContent;
                const productId = button.dataset.productId;
                
                try {
                    Utils.showLoading(button);

                    // Send request to Laravel backend
                    const response = await fetch('/api/cart/add', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: 1
                        })
                    });

                    const data = await response.json();

                    if (response.ok) {
                        // Update cart count
                        if (cartCount) {
                            cartCount.textContent = data.cart_count;
                        }

                        // Show success animation
                        button.textContent = 'Ditambahkan!';
                        button.style.backgroundColor = '#165d42';

                        Utils.showNotification('Produk berhasil ditambahkan ke keranjang!');

                        await Utils.delay(1000);
                    } else {
                        throw new Error(data.message || 'Gagal menambahkan ke keranjang');
                    }

                } catch (error) {
                    console.error('Cart error:', error);
                    Utils.showNotification(error.message, 'error');
                } finally {
                    Utils.hideLoading(button, originalText);
                    button.style.backgroundColor = '';
                }
            });
        });
    } catch (error) {
        console.error('Error initializing shopping cart:', error);
    }
};

// Sticky Header (Async)
const initStickyHeader = async () => {
    try {
        const header = document.querySelector('header');
        if (!header) return;

        let ticking = false;

        const updateHeader = async () => {
            if (window.pageYOffset > 100) {
                header.style.backgroundColor = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            } else {
                header.style.backgroundColor = 'var(--white)';
                header.style.boxShadow = '0 2px 10px rgba(0,0,0,0.1)';
            }
            ticking = false;
        };

        window.addEventListener('scroll', () => {
            if (!ticking) {
                requestAnimationFrame(updateHeader);
                ticking = true;
            }
        });
    } catch (error) {
        console.error('Error initializing sticky header:', error);
    }
};

// Smooth Scrolling (Async)
const initSmoothScrolling = async () => {
    try {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', async function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const headerHeight = document.querySelector('header')?.offsetHeight || 0;
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - headerHeight;
                    
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Close mobile menu if open
                    const navLinks = document.querySelector('.nav-links');
                    if (navLinks?.classList.contains('active')) {
                        navLinks.classList.remove('active');
                    }
                    
                    await Utils.delay(300); // Wait for scroll
                }
            });
        });
    } catch (error) {
        console.error('Error initializing smooth scrolling:', error);
    }
};

// Menu Filters (Async with Laravel API)
const initMenuFilters = async () => {
    try {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const searchInput = document.querySelector('.search-bar input');

        // Filter functionality
        if (filterButtons.length) {
            filterButtons.forEach(btn => {
                btn.addEventListener('click', async function() {
                    const originalText = this.textContent;
                    
                    try {
                        // Remove active class from all buttons
                        filterButtons.forEach(b => b.classList.remove('active'));
                        this.classList.add('active');
                        
                        const category = this.getAttribute('data-category');
                        
                        Utils.showLoading(this);
                        await filterProducts(category);
                        
                    } catch (error) {
                        console.error('Filter error:', error);
                        Utils.showNotification('Gagal memfilter produk', 'error');
                    } finally {
                        Utils.hideLoading(this, originalText);
                    }
                });
            });
        }

        // Search functionality with debounce
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.toLowerCase().trim();
                
                searchTimeout = setTimeout(async () => {
                    await searchProducts(searchTerm);
                }, 300); // Debounce 300ms
            });
        }
    } catch (error) {
        console.error('Error initializing menu filters:', error);
    }
};

// Filter Products (Async API call)
const filterProducts = async (category) => {
    try {
        const response = await fetch(`/api/products/filter?category=${category}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();

        if (response.ok) {
            await updateProductDisplay(data.products);
        } else {
            throw new Error(data.message || 'Gagal memfilter produk');
        }
    } catch (error) {
        console.error('Filter products error:', error);
        // Fallback to client-side filtering
        const products = document.querySelectorAll('.product-card');
        products.forEach(product => {
            const productCategory = product.getAttribute('data-category');
            product.style.display = (category === 'all' || productCategory === category) ? 'block' : 'none';
        });
    }
};

// Search Products (Async API call)
const searchProducts = async (searchTerm) => {
    try {
        if (searchTerm === '') {
            // Show all products if search is empty
            const products = document.querySelectorAll('.product-card');
            products.forEach(product => {
                product.style.display = 'block';
            });
            return;
        }

        const response = await fetch(`/api/products/search?q=${encodeURIComponent(searchTerm)}`, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();

        if (response.ok) {
            await updateProductDisplay(data.products);
        } else {
            throw new Error(data.message || 'Gagal mencari produk');
        }
    } catch (error) {
        console.error('Search products error:', error);
        // Fallback to client-side search
        const products = document.querySelectorAll('.product-card');
        products.forEach(product => {
            const productName = product.querySelector('h4')?.textContent.toLowerCase() || '';
            const productDesc = product.querySelector('.description')?.textContent.toLowerCase() || '';
            
            product.style.display = (productName.includes(searchTerm) || productDesc.includes(searchTerm)) ? 'block' : 'none';
        });
    }
};

// Update Product Display
const updateProductDisplay = async (products) => {
    try {
        const productContainer = document.querySelector('.products-grid');
        if (!productContainer) return;

        // Clear current products
        productContainer.innerHTML = '';

        // Add new products
        products.forEach(product => {
            const productCard = document.createElement('div');
            productCard.className = 'product-card';
            productCard.setAttribute('data-category', product.category);
            
            productCard.innerHTML = `
                <img src="${product.image}" alt="${product.name}">
                <h4>${product.name}</h4>
                <p class="description">${product.description}</p>
                <p class="price">Rp ${product.price.toLocaleString('id-ID')}</p>
                <button class="add-to-cart btn" data-product-id="${product.id}">Tambah ke Keranjang</button>
            `;
            
            productContainer.appendChild(productCard);
        });

        // Re-initialize cart buttons for new products
        await initShoppingCart();
        
    } catch (error) {
        console.error('Error updating product display:', error);
    }
};

// Product Detail Functions (Async)
const initProductDetail = async () => {
    try {
        // Gallery thumbnails
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.querySelector('.main-image img');
        
        if (thumbnails.length && mainImage) {
            thumbnails.forEach(thumb => {
                thumb.addEventListener('click', async function() {
                    const imgSrc = this.querySelector('img').getAttribute('src');
                    
                    // Fade effect
                    mainImage.style.opacity = '0.5';
                    await Utils.delay(150);
                    
                    mainImage.setAttribute('src', imgSrc);
                    mainImage.style.opacity = '1';
                    
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
                btn.addEventListener('click', async function() {
                    const target = this.getAttribute('data-tab');
                    
                    // Hide all tab contents with fade
                    tabContents.forEach(content => {
                        content.style.opacity = '0';
                        setTimeout(() => content.classList.remove('active'), 150);
                    });
                    
                    await Utils.delay(150);
                    
                    // Show selected tab content
                    const targetContent = document.getElementById(target);
                    if (targetContent) {
                        targetContent.classList.add('active');
                        targetContent.style.opacity = '1';
                    }
                    
                    // Update active tab button
                    tabButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        }
    } catch (error) {
        console.error('Error initializing product detail:', error);
    }
};

// Auth Forms (Async with Laravel validation)
const initAuthForms = async () => {
    try {
        // Password visibility toggle
        const passwordToggles = document.querySelectorAll('.password-toggle i');
        
        passwordToggles.forEach(toggle => {
            toggle.addEventListener('click', async function() {
                const passwordInput = this.previousElementSibling;
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.classList.replace('fa-eye', 'fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    this.classList.replace('fa-eye-slash', 'fa-eye');
                }
                
                await Utils.delay(100);
            });
        });
        
        // Login Form
        const loginForm = document.getElementById('login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                await handleFormSubmission(this, '/login');
            });
        }
        
        // Register Form
        const registerForm = document.getElementById('register-form');
        if (registerForm) {
            registerForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                await handleFormSubmission(this, '/register');
            });
        }
        
        // Forgot Password Form
        const forgotPasswordForm = document.getElementById('forgot-password-form');
        if (forgotPasswordForm) {
            forgotPasswordForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                await handleFormSubmission(this, '/forgot-password');
            });
        }
    } catch (error) {
        console.error('Error initializing auth forms:', error);
    }
};

// Handle Form Submission (Async Laravel API)
const handleFormSubmission = async (form, endpoint) => {
    const submitButton = form.querySelector('button[type="submit"]');
    const originalText = submitButton?.textContent;
    
    try {
        Utils.showLoading(submitButton);
        resetValidationMessages(form);
        
        const formData = new FormData(form);
        const jsonData = {};
        
        // Convert FormData to JSON
        for (let [key, value] of formData.entries()) {
            jsonData[key] = value;
        }
        
        const response = await fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify(jsonData)
        });
        
        const data = await response.json();
        
        if (response.ok) {
            Utils.showNotification(data.message || 'Berhasil!');
            
            if (data.redirect) {
                await Utils.delay(1000);
                window.location.href = data.redirect;
            }
        } else {
            // Handle validation errors
            if (data.errors) {
                Object.keys(data.errors).forEach(field => {
                    const input = form.querySelector(`[name="${field}"]`);
                    if (input) {
                        showValidationMessage(input, data.errors[field][0]);
                    }
                });
            } else {
                throw new Error(data.message || 'Terjadi kesalahan');
            }
        }
        
    } catch (error) {
        console.error('Form submission error:', error);
        Utils.showNotification(error.message, 'error');
    } finally {
        Utils.hideLoading(submitButton, originalText);
    }
};

// Cart Management (Async)
const initCartManagement = async () => {
    try {
        const decreaseBtns = document.querySelectorAll('.cart-item .quantity-btn.decrease');
        const increaseBtns = document.querySelectorAll('.cart-item .quantity-btn.increase');
        const quantityInputs = document.querySelectorAll('.cart-item .quantity-input');
        const removeButtons = document.querySelectorAll('.remove-item');
        const clearCartButton = document.querySelector('.clear-cart');
        const updateCartButton = document.querySelector('.update-cart');

        // Update cart item quantity
        const updateCartItem = async (itemId, quantity) => {
            try {
                const response = await fetch('/api/cart/update', {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        item_id: itemId,
                        quantity: quantity
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    await updateCartTotal();
                    return data;
                } else {
                    throw new Error(data.message || 'Gagal memperbarui keranjang');
                }
            } catch (error) {
                console.error('Update cart error:', error);
                Utils.showNotification(error.message, 'error');
            }
        };

        // Quantity buttons
        decreaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', async function() {
                const quantityInput = quantityInputs[index];
                const currentValue = parseInt(quantityInput.value);
                const itemId = this.dataset.itemId;
                
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                    await updateCartItem(itemId, currentValue - 1);
                }
            });
        });

        increaseBtns.forEach((btn, index) => {
            btn.addEventListener('click', async function() {
                const quantityInput = quantityInputs[index];
                const currentValue = parseInt(quantityInput.value);
                const itemId = this.dataset.itemId;
                
                quantityInput.value = currentValue + 1;
                await updateCartItem(itemId, currentValue + 1);
            });
        });

        // Remove item buttons
        removeButtons.forEach(btn => {
            btn.addEventListener('click', async function() {
                const item = this.closest('.cart-item');
                const itemId = this.dataset.itemId;
                
                if (confirm('Hapus item ini dari keranjang?')) {
                    try {
                        const response = await fetch(`/api/cart/remove/${itemId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            item.style.opacity = '0';
                            await Utils.delay(300);
                            item.remove();
                            
                            await updateCartTotal();
                            Utils.showNotification('Item berhasil dihapus');
                        } else {
                            throw new Error(data.message || 'Gagal menghapus item');
                        }
                    } catch (error) {
                        console.error('Remove item error:', error);
                        Utils.showNotification(error.message, 'error');
                    }
                }
            });
        });

        // Clear cart button
        if (clearCartButton) {
            clearCartButton.addEventListener('click', async function() {
                if (confirm('Kosongkan seluruh keranjang?')) {
                    const originalText = this.textContent;
                    
                    try {
                        Utils.showLoading(this);
                        
                        const response = await fetch('/api/cart/clear', {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok) {
                            location.reload(); // Reload to show empty cart
                        } else {
                            throw new Error(data.message || 'Gagal mengosongkan keranjang');
                        }
                    } catch (error) {
                        console.error('Clear cart error:', error);
                        Utils.showNotification(error.message, 'error');
                    } finally {
                        Utils.hideLoading(this, originalText);
                    }
                }
            });
        }

    } catch (error) {
        console.error('Error initializing cart management:', error);
    }
};

// Update Cart Total (Async)
const updateCartTotal = async () => {
    try {
        const response = await fetch('/api/cart/total', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();

        if (response.ok) {
            // Update cart count
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.items_count;
            }

            // Update totals
            const subtotalElement = document.querySelector('.summary-item:first-child span:last-child');
            const totalElement = document.querySelector('.summary-total span:last-child');
            
            if (subtotalElement) {
                subtotalElement.textContent = `Rp ${data.subtotal.toLocaleString('id-ID')}`;
            }
            
            if (totalElement) {
                totalElement.textContent = `Rp ${data.total.toLocaleString('id-ID')}`;
            }
        }
    } catch (error) {
        console.error('Update cart total error:', error);
    }
};

// Admin Functions (Async)
const initAdminFunctions = async () => {
    try {
        // Product management
        const addProductBtn = document.getElementById('addProductBtn');
        const productFormSection = document.getElementById('productFormSection');
        const cancelFormBtn = document.getElementById('cancelFormBtn');
        const productForm = document.getElementById('addMenuForm');

        if (addProductBtn && productFormSection) {
            addProductBtn.addEventListener('click', async () => {
                productFormSection.classList.add('active');
                await Utils.delay(100);
            });
        }

        if (cancelFormBtn && productFormSection) {
            cancelFormBtn.addEventListener('click', async () => {
                productFormSection.classList.remove('active');
                await Utils.delay(100);
            });
        }

        // Product form submission
        if (productForm) {
            productForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton?.textContent;
                
                try {
                    Utils.showLoading(submitButton);
                    
                    const formData = new FormData(this);
                    
                    const response = await fetch('/admin/products', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (response.ok) {
                        Utils.showNotification('Produk berhasil ditambahkan!');
                        await Utils.delay(1000);
                        
                        if (data.redirect) {
                            window.location.href = data.redirect;
                        } else {
                            location.reload();
                        }
                    } else {
                        throw new Error(data.message || 'Gagal menambahkan produk');
                    }
                    
                } catch (error) {
                    console.error('Product form error:', error);
                    Utils.showNotification(error.message, 'error');
                } finally {
                    Utils.hideLoading(submitButton, originalText);
                }
            });
        }

        // Initialize charts
        await initCharts();
        
    } catch (error) {
        console.error('Error initializing admin functions:', error);
    }
};

// Initialize Charts (Async)
const initCharts = async () => {
    try {
        // Check if Chart.js is available
        if (typeof Chart === 'undefined') {
            console.warn('Chart.js not loaded');
            return;
        }

        // Fetch chart data from Laravel API
        const response = await fetch('/admin/api/chart-data', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const chartData = await response.json();

        // Sales Trend Chart
        const salesTrendCtx = document.getElementById('salesTrendChart');
        if (salesTrendCtx) {
            new Chart(salesTrendCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartData.sales_trend.labels,
                    datasets: [{
                        label: 'Penjualan',
                        data: chartData.sales_trend.data,
                        borderColor: '#4CAF50',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Product Performance Chart
        const productPerformanceCtx = document.getElementById('productPerformanceChart');
        if (productPerformanceCtx) {
            new Chart(productPerformanceCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.product_performance.labels,
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: chartData.product_performance.data,
                        backgroundColor: '#4CAF50'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

    } catch (error) {
        console.error('Error initializing charts:', error);
        // Fallback with static data if API fails
        initStaticCharts();
    }
};

// Fallback static charts
const initStaticCharts = () => {
    try {
        if (typeof Chart === 'undefined') return;

        // Static Sales Trend Chart
        const salesTrendCtx = document.getElementById('salesTrendChart');
        if (salesTrendCtx) {
            new Chart(salesTrendCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Penjualan',
                        data: [65, 59, 80, 81, 56, 55],
                        borderColor: '#4CAF50',
                        tension: 0.1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Static Product Performance Chart
        const productPerformanceCtx = document.getElementById('productPerformanceChart');
        if (productPerformanceCtx) {
            new Chart(productPerformanceCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Espresso', 'Latte', 'Cappuccino', 'Mocha', 'Americano'],
                    datasets: [{
                        label: 'Jumlah Terjual',
                        data: [120, 95, 85, 70, 60],
                        backgroundColor: '#4CAF50'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

    } catch (error) {
        console.error('Error initializing static charts:', error);
    }
};

// Reports Functions (Async)
const initReports = async () => {
    try {
        const printReportBtn = document.querySelector('.print-report');
        const filterReportBtn = document.querySelector('.filter-report');
        
        if (printReportBtn) {
            printReportBtn.addEventListener('click', async () => {
                await printReport();
            });
        }
        
        if (filterReportBtn) {
            filterReportBtn.addEventListener('click', async () => {
                await filterReport();
            });
        }
    } catch (error) {
        console.error('Error initializing reports:', error);
    }
};

// Print Report Function (Async)
const printReport = async () => {
    try {
        // Hide non-printable elements
        const nonPrintElements = document.querySelectorAll('.no-print');
        nonPrintElements.forEach(el => el.style.display = 'none');
        
        await Utils.delay(100);
        window.print();
        
        // Restore elements after printing
        setTimeout(() => {
            nonPrintElements.forEach(el => el.style.display = '');
        }, 1000);
        
    } catch (error) {
        console.error('Print report error:', error);
        Utils.showNotification('Gagal mencetak laporan', 'error');
    }
};

// Filter Report Function (Async)
const filterReport = async () => {
    const startDateInput = document.getElementById('startDate');
    const endDateInput = document.getElementById('endDate');
    const filterButton = document.querySelector('.filter-report');
    
    if (!startDateInput || !endDateInput) return;
    
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;
    const originalText = filterButton?.textContent;
    
    try {
        if (!startDate || !endDate) {
            Utils.showNotification('Pilih tanggal mulai dan akhir', 'error');
            return;
        }
        
        if (filterButton) {
            Utils.showLoading(filterButton);
        }
        
        const response = await fetch('/admin/api/reports/filter', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                start_date: startDate,
                end_date: endDate
            })
        });

        const data = await response.json();

        if (response.ok) {
            await updateReportDisplay(data);
            Utils.showNotification('Laporan berhasil difilter');
        } else {
            throw new Error(data.message || 'Gagal memfilter laporan');
        }
        
    } catch (error) {
        console.error('Filter report error:', error);
        Utils.showNotification(error.message, 'error');
    } finally {
        if (filterButton) {
            Utils.hideLoading(filterButton, originalText);
        }
    }
};

// Update Report Display (Async)
const updateReportDisplay = async (data) => {
    try {
        // Update summary cards
        const totalSalesElement = document.querySelector('.summary-cards .card:nth-child(1) .card-value');
        const totalOrdersElement = document.querySelector('.summary-cards .card:nth-child(2) .card-value');
        const totalCustomersElement = document.querySelector('.summary-cards .card:nth-child(3) .card-value');
        const avgOrderElement = document.querySelector('.summary-cards .card:nth-child(4) .card-value');
        
        if (totalSalesElement) totalSalesElement.textContent = `Rp ${data.total_sales.toLocaleString('id-ID')}`;
        if (totalOrdersElement) totalOrdersElement.textContent = data.total_orders;
        if (totalCustomersElement) totalCustomersElement.textContent = data.total_customers;
        if (avgOrderElement) avgOrderElement.textContent = `Rp ${data.avg_order.toLocaleString('id-ID')}`;
        
        // Update product performance table
        const productTableBody = document.querySelector('.product-table tbody');
        if (productTableBody && data.top_products) {
            productTableBody.innerHTML = '';
            
            data.top_products.forEach((product, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${product.name}</td>
                    <td>${product.quantity_sold}</td>
                    <td>Rp ${product.total_revenue.toLocaleString('id-ID')}</td>
                `;
                productTableBody.appendChild(row);
            });
        }
        
        // Update charts with new data
        if (data.chart_data) {
            await updateCharts(data.chart_data);
        }
        
    } catch (error) {
        console.error('Error updating report display:', error);
    }
};

// Update Charts with new data (Async)
const updateCharts = async (chartData) => {
    try {
        // Update sales trend chart
        const salesChart = Chart.getChart('salesTrendChart');
        if (salesChart && chartData.sales_trend) {
            salesChart.data.labels = chartData.sales_trend.labels;
            salesChart.data.datasets[0].data = chartData.sales_trend.data;
            salesChart.update();
        }
        
        // Update product performance chart
        const productChart = Chart.getChart('productPerformanceChart');
        if (productChart && chartData.product_performance) {
            productChart.data.labels = chartData.product_performance.labels;
            productChart.data.datasets[0].data = chartData.product_performance.data;
            productChart.update();
        }
        
    } catch (error) {
        console.error('Error updating charts:', error);
    }
};

// Order Management Functions (Async)
const initOrderManagement = async () => {
    try {
        const statusButtons = document.querySelectorAll('.status-btn');
        
        statusButtons.forEach(button => {
            button.addEventListener('click', async function() {
                const orderId = this.dataset.orderId;
                const newStatus = this.dataset.status;
                const originalText = this.textContent;
                
                try {
                    Utils.showLoading(this);
                    await updateOrderStatus(orderId, newStatus);
                    Utils.showNotification('Status pesanan berhasil diperbarui');
                    
                } catch (error) {
                    console.error('Update order status error:', error);
                    Utils.showNotification(error.message, 'error');
                } finally {
                    Utils.hideLoading(this, originalText);
                }
            });
        });
        
    } catch (error) {
        console.error('Error initializing order management:', error);
    }
};

// Update Order Status (Async)
const updateOrderStatus = async (orderId, status) => {
    try {
        const response = await fetch(`/admin/api/orders/${orderId}/status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                status: status
            })
        });

        const data = await response.json();

        if (response.ok) {
            // Update UI
            const orderRow = document.querySelector(`[data-order-id="${orderId}"]`);
            if (orderRow) {
                const statusCell = orderRow.querySelector('.order-status');
                if (statusCell) {
                    statusCell.textContent = data.status_text;
                    statusCell.className = `order-status status-${status}`;
                }
            }
            
            return data;
        } else {
            throw new Error(data.message || 'Gagal memperbarui status pesanan');
        }
        
    } catch (error) {
        console.error('Update order status error:', error);
        throw error;
    }
};

// Image Upload Preview (Async)
const initImagePreview = async () => {
    try {
        const imageInput = document.getElementById('productImage');
        const imagePreview = document.getElementById('imagePreview');
        
        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', async function(e) {
                const file = e.target.files[0];
                
                if (file) {
                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        Utils.showNotification('File harus berupa gambar', 'error');
                        this.value = '';
                        return;
                    }
                    
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        Utils.showNotification('Ukuran file maksimal 2MB', 'error');
                        this.value = '';
                        return;
                    }
                    
                    try {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            imagePreview.style.display = 'block';
                            const img = imagePreview.querySelector('img');
                            if (img) {
                                img.src = e.target.result;
                            }
                        };
                        
                        reader.readAsDataURL(file);
                        
                    } catch (error) {
                        console.error('Image preview error:', error);
                        Utils.showNotification('Gagal menampilkan preview gambar', 'error');
                    }
                } else {
                    imagePreview.style.display = 'none';
                }
            });
        }
    } catch (error) {
        console.error('Error initializing image preview:', error);
    }
};

// Validation Helper Functions
const validateEmail = (email) => {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
};

const showValidationMessage = (inputElement, message) => {
    // Remove existing validation message
    const existingMsg = inputElement.parentNode.querySelector('.validation-message');
    if (existingMsg) {
        existingMsg.remove();
    }
    
    const validationMsg = document.createElement('div');
    validationMsg.className = 'validation-message';
    validationMsg.textContent = message;
    validationMsg.style.cssText = 'color: #e53935; font-size: 0.875rem; margin-top: 0.25rem; display: block;';
    
    inputElement.parentNode.appendChild(validationMsg);
    inputElement.style.borderColor = '#e53935';
};

const resetValidationMessages = (form) => {
    const messages = form.querySelectorAll('.validation-message');
    messages.forEach(msg => msg.remove());
    
    const inputs = form.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.style.borderColor = '';
    });
};

// Notification System (Async)
const initNotificationSystem = async () => {
    try {
        // Create notification container if it doesn't exist
        let notificationContainer = document.querySelector('.notification-container');
        if (!notificationContainer) {
            notificationContainer = document.createElement('div');
            notificationContainer.className = 'notification-container';
            notificationContainer.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 10000;
                max-width: 400px;
            `;
            document.body.appendChild(notificationContainer);
        }
        
        // Override Utils.showNotification to use the container
        Utils.showNotification = (message, type = 'success') => {
            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.style.cssText = `
                background: ${type === 'success' ? '#4CAF50' : '#f44336'};
                color: white;
                padding: 16px 20px;
                border-radius: 8px;
                margin-bottom: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                display: flex;
                align-items: center;
                gap: 10px;
                transform: translateX(100%);
                transition: transform 0.3s ease;
            `;
            
            notification.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${message}</span>
            `;
            
            notificationContainer.appendChild(notification);
            
            // Animate in
            setTimeout(() => {
                notification.style.transform = 'translateX(0)';
            }, 100);
            
            // Auto remove
            setTimeout(() => {
                notification.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    if (notification.parentNode) {
                        notification.remove();
                    }
                }, 300);
            }, 5000);
        };
        
    } catch (error) {
        console.error('Error initializing notification system:', error);
    }
};

// Real-time Updates (WebSocket/Polling)
const initRealTimeUpdates = async () => {
    try {
        // Check if we're on admin pages that need real-time updates
        const isAdminPage = window.location.pathname.includes('/admin');
        
        if (isAdminPage) {
            // Poll for new orders every 30 seconds
            setInterval(async () => {
                await checkForNewOrders();
            }, 30000);
            
            // Poll for cart updates every 10 seconds if on cart page
            if (window.location.pathname.includes('/cart')) {
                setInterval(async () => {
                    await updateCartTotal();
                }, 10000);
            }
        }
        
    } catch (error) {
        console.error('Error initializing real-time updates:', error);
    }
};

// Check for new orders (Admin)
const checkForNewOrders = async () => {
    try {
        const response = await fetch('/admin/api/orders/check-new', {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        const data = await response.json();

        if (response.ok && data.has_new_orders) {
            // Show notification for new orders
            Utils.showNotification(`${data.new_orders_count} pesanan baru masuk!`);
            
            // Update order counter if exists
            const orderCounter = document.querySelector('.order-counter');
            if (orderCounter) {
                orderCounter.textContent = data.total_pending_orders;
            }
        }
        
    } catch (error) {
        console.error('Check new orders error:', error);
    }
};

// Performance Optimization (Async)
const initPerformanceOptimizations = async () => {
    try {
        // Lazy load images
        const images = document.querySelectorAll('img[data-src]');
        if (images.length && 'IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        observer.unobserve(img);
                    }
                });
            });

            images.forEach(img => imageObserver.observe(img));
        }
        
        // Debounce scroll events
        let scrollTimeout;
        const originalScrollHandlers = [];
        
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                originalScrollHandlers.forEach(handler => handler());
            }, 10);
        });
        
    } catch (error) {
        console.error('Error initializing performance optimizations:', error);
    }
};

// Error Handling and Retry Logic
const withRetry = async (fn, maxRetries = 3, delay = 1000) => {
    for (let i = 0; i < maxRetries; i++) {
        try {
            return await fn();
        } catch (error) {
            if (i === maxRetries - 1) throw error;
            await Utils.delay(delay * Math.pow(2, i)); // Exponential backoff
        }
    }
};

// Main Initialization Function
const initializeApp = async () => {
    try {
        console.log('Initializing application...');
        
        // Initialize core systems first
        await initNotificationSystem();
        await initPerformanceOptimizations();
        
        // Initialize basic UI components
        await Promise.all([
            initMobileMenu(),
            initStickyHeader(),
            initBackToTop(),
            initSmoothScrolling()
        ]);
        
        // Initialize page-specific components
        await Promise.all([
            initTestimonialSlider(),
            initShoppingCart(),
            initMenuFilters(),
            initProductDetail(),
            initAuthForms(),
            initCartManagement(),
            initImagePreview()
        ]);
        
        // Initialize admin components if on admin pages
        if (window.location.pathname.includes('/admin')) {
            await Promise.all([
                initAdminFunctions(),
                initOrderManagement(),
                initReports()
            ]);
        }
        
        // Initialize real-time updates
        await initRealTimeUpdates();
        
        console.log('Application initialized successfully');
        
    } catch (error) {
        console.error('Error initializing application:', error);
        Utils.showNotification('Terjadi kesalahan saat memuat aplikasi', 'error');
    }
};

// DOM Content Loaded Event
document.addEventListener('DOMContentLoaded', async () => {
    await initializeApp();
});

// Window Load Event (for additional resources)
window.addEventListener('load', async () => {
    try {
        // Initialize components that require full page load
        await initCharts();
        
        // Remove loading screen if exists
        const loadingScreen = document.querySelector('.loading-screen');
        if (loadingScreen) {
            loadingScreen.style.opacity = '0';
            setTimeout(() => {
                loadingScreen.remove();
            }, 500);
        }
        
    } catch (error) {
        console.error('Error in window load handler:', error);
    }
});

// Error Event Handlers
window.addEventListener('error', (event) => {
    console.error('Global error:', event.error);
    // Don't show notification for script errors to avoid spam
});

window.addEventListener('unhandledrejection', (event) => {
    console.error('Unhandled promise rejection:', event.reason);
    event.preventDefault(); // Prevent default browser behavior
});

// Service Worker Registration (Optional)
const registerServiceWorker = async () => {
    if ('serviceWorker' in navigator && 'production' === 'production') {
        try {
            const registration = await navigator.serviceWorker.register('/sw.js');
            console.log('Service Worker registered:', registration);
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    }
};

// Export functions for external use
window.CoffeeShopApp = {
    Utils,
    initializeApp,
    updateCartTotal,
    filterProducts,
    searchProducts,
    showNotification: Utils.showNotification,
    withRetry
};

async function setDateTimeLimits() {
const input = document.getElementById("pickupTime");
const button = document.getElementById("orderBtn");

// Simulasi async waktu (misalnya bisa diubah jadi fetch server time)
const now = await new Promise(resolve => {
    setTimeout(() => resolve(new Date()), 0);
});

const currentHour = now.getHours();

// Fungsi format datetime
function formatDateTime(date) {
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    return `${year}-${month}-${day}T${hours}:${minutes}`;
}

// Atur min dan max input jika dalam jam operasional
if (currentHour >= 8 && currentHour < 17) {
    input.min = formatDateTime(now);
    const maxDate = new Date();
    maxDate.setHours(17, 0, 0, 0);
    input.max = formatDateTime(maxDate);
    input.disabled = false;
    button.disabled = false;
} else {
    // Di luar jam operasional: disable input dan tombol
    input.disabled = true;
    button.disabled = true;
}
}

setDateTimeLimits();