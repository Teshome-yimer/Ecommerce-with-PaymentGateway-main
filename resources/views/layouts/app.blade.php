<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>E-Commerce - @yield('title', 'Shop')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #374151;
        }

        .navbar-clean {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            color: #1f2937 !important;
        }

        .nav-link {
            font-weight: 500;
            color: #374151 !important;
            transition: color 0.2s ease;
        }

        .nav-link:hover {
            color: #3b82f6 !important;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 0.7rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .btn-primary-custom {
            background: #3b82f6;
            border: 1px solid #3b82f6;
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .btn-primary-custom:hover {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
        }

        .card-clean {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.2s ease;
        }

        .card-clean:hover {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .hero-simple {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: white;
            padding: 80px 0;
        }

        .section-title {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 2rem;
            text-align: center;
        }

        .price-simple {
            color: #3b82f6;
            font-weight: 700;
            font-size: 1.1rem;
        }

        .badge-simple {
            background: #3b82f6;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .footer-clean {
            background: #1f2937;
            color: white;
            padding: 40px 0 20px;
        }

        .alert-clean {
            border-radius: 6px;
            padding: 15px;
            margin: 15px 0;
            border-left: 4px solid;
        }

        .alert-success {
            background: #f0fdf4;
            border-left-color: #22c55e;
            color: #166534;
        }

        .alert-danger {
            background: #fef2f2;
            border-left-color: #ef4444;
            color: #991b1b;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-simple {
                padding: 60px 0;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg" style="background:#fff;border-bottom:1px solid #e5e7eb;box-shadow:0 2px 12px rgba(99,102,241,0.08);padding:0 0;">
        <div class="container" style="padding-top:10px;padding-bottom:10px;">
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}" style="font-weight:800;font-size:1.3rem;color:#1e1b4b;text-decoration:none;">
                <div style="width:38px;height:38px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-store" style="color:#fff;font-size:1rem;"></i>
                </div>
                <span>የኛ ገበያ</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-4 gap-1">
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill fw-500" href="{{ route('home') }}" style="color:#374151;font-weight:500;transition:all 0.2s;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link px-3 py-2 rounded-pill fw-500" href="{{ route('products') }}" style="color:#374151;font-weight:500;">Products</a>
                    </li>
                </ul>

                <ul class="navbar-nav align-items-center gap-2">
                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative d-flex align-items-center justify-content-center"
                           href="{{ route('cart') }}"
                           style="width:42px;height:42px;background:#f3f4f6;border-radius:50%;color:#374151;">
                            <i class="fas fa-shopping-cart" style="font-size:1rem;"></i>
                            <span class="cart-badge" id="cart-count">{{ $cartCount ?? 0 }}</span>
                        </a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a href="{{ route('login') }}"
                               style="display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:50px;border:2px solid #6366f1;color:#6366f1;font-weight:600;font-size:0.9rem;text-decoration:none;transition:all 0.2s;"
                               onmouseover="this.style.background='#6366f1';this.style.color='#fff'"
                               onmouseout="this.style.background='transparent';this.style.color='#6366f1'">
                                <i class="fas fa-sign-in-alt"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('register') }}"
                               style="display:inline-flex;align-items:center;gap:6px;padding:9px 20px;border-radius:50px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:600;font-size:0.9rem;text-decoration:none;box-shadow:0 4px 15px rgba(99,102,241,0.35);transition:all 0.2s;"
                               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(99,102,241,0.5)'"
                               onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 15px rgba(99,102,241,0.35)'">
                                <i class="fas fa-user-plus"></i> Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown" style="color:#374151;font-weight:600;">
                                <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;border:2px solid #6366f1;flex-shrink:0;">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width:100%;height:100%;object-fit:cover;" alt="">
                                    @else
                                        <div style="width:100%;height:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius:16px;padding:8px;">
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2 text-primary"></i>ዳሽቦርድ</a></li>
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('orders.history') }}"><i class="fas fa-shopping-bag me-2 text-success"></i>የእኔ ትዕዛዞች</a></li>
                                <li><a class="dropdown-item rounded-3 py-2" href="{{ route('profile.edit') }}"><i class="fas fa-user-cog me-2 text-warning"></i>የእኔ መለያ</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item rounded-3 py-2 text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>ውጣ
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="py-3">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-clean alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-clean alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer-clean mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5>የኛ ገበያ</h5>
                    <p class="text-light">የታመነ የ online ግዢ መድረክ።</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h6>አድራሻ</h6>
                    <p class="text-light">
                        ኢሜይል: tesheyimer86@gmail.com<br>
                        ስልክ: 0962868748
                    </p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="text-light mb-0">&copy; {{ date('Y') }} የኛ ገበያ. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Update cart count on page load
        $(document).ready(function() {
            updateCartCount();
        });

        function updateCartCount() {
            // This would be implemented to get cart count via AJAX
            // For now, we'll leave it as is
        }

        // Add to cart function
        function addToCart(productId, quantity = 1) {
            const button = event.target.closest('button');
            const originalText = button.innerHTML;

            // Show loading state
            button.disabled = true;
            button.innerHTML = 'Adding...';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post('{{ route("cart.add") }}', {
                product_id: productId,
                quantity: quantity
            })
            .done(function(response) {
                if (response.success) {
                    // Update cart count
                    $('#cart-count').text(response.cart_count);

                    // Show success message
                    showAlert('success', response.message);

                    // Reset button
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .fail(function(xhr) {
                const response = xhr.responseJSON;
                showAlert('danger', response.error || 'Failed to add product to cart');

                // Reset button
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        function showAlert(type, message) {
            const iconMap = {
                'success': 'fas fa-check-circle',
                'danger': 'fas fa-exclamation-circle'
            };

            const alertHtml = `
                <div class="container">
                    <div class="alert alert-clean alert-${type} alert-dismissible fade show" role="alert">
                        <i class="${iconMap[type]} me-2"></i>${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            `;

            $('main').prepend(alertHtml);

            // Auto dismiss after 3 seconds
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 3000);
        }
    </script>

    @stack('scripts')
</body>
</html>
