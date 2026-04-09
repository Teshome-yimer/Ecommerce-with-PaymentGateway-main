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
                    showAlert('success', response.message || 'ምርቱ ወደ ጋሪ ተጨምሯል!');

                    // Reset button
                    button.disabled = false;
                    button.innerHTML = originalText;
                }
            })
            .fail(function(xhr) {
                const response = xhr.responseJSON;
                showAlert('danger', response.error || 'ምርቱን ወደ ጋሪ ማስገባት አልተሳካም');

                // Reset button
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }

        function showAlert(type, message) {
            // Remove existing toasts
            $('.toast-notify').remove();

            const colors = {
                'success': { bg: 'linear-gradient(135deg,#16a34a,#22c55e)', icon: 'fa-check-circle' },
                'danger':  { bg: 'linear-gradient(135deg,#dc2626,#ef4444)', icon: 'fa-exclamation-circle' }
            };
            const c = colors[type] || colors['success'];

            const toast = $(`
                <div class="toast-notify" style="
                    position:fixed;top:50%;left:50%;transform:translateX(-50%) translateY(-50%);
                    z-index:99999;min-width:300px;max-width:420px;
                    background:${c.bg};
                    color:#fff;border-radius:16px;padding:16px 22px;
                    display:flex;align-items:center;gap:12px;
                    box-shadow:0 12px 40px rgba(0,0,0,0.25);
                    animation:slideDown 0.4s ease;
                ">
                    <i class="fas ${c.icon}" style="font-size:1.3rem;flex-shrink:0;"></i>
                    <span style="font-weight:600;font-size:0.92rem;">${message}</span>
                </div>
            `);

            $('body').append(toast);
            setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3500);
        }

        // Toast animation
        const toastStyle = document.createElement('style');
        toastStyle.textContent = '@keyframes slideDown{from{opacity:0;transform:translateX(-50%) translateY(calc(-50% - 20px))}to{opacity:1;transform:translateX(-50%) translateY(-50%)}}';
        document.head.appendChild(toastStyle);
    </script>

    @stack('scripts')

<!-- ===== CHATBOT ===== -->
<style>
#chatbot-btn {
    position:fixed; bottom:28px; right:28px; z-index:9998;
    width:58px; height:58px; border-radius:50%; border:none; cursor:pointer;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    box-shadow:0 8px 25px rgba(99,102,241,0.5);
    display:flex; align-items:center; justify-content:center;
    transition:all 0.3s; animation:pulse-btn 2.5s infinite;
}
#chatbot-btn:hover { transform:scale(1.1); box-shadow:0 12px 35px rgba(99,102,241,0.7); }
@keyframes pulse-btn {
    0%,100%{ box-shadow:0 8px 25px rgba(99,102,241,0.5); }
    50%{ box-shadow:0 8px 35px rgba(99,102,241,0.8),0 0 0 8px rgba(99,102,241,0.15); }
}
#chatbot-window {
    position:fixed; bottom:100px; right:28px; z-index:9997;
    width:360px; height:520px; border-radius:24px;
    background:#fff; box-shadow:0 20px 60px rgba(0,0,0,0.2);
    display:none; flex-direction:column; overflow:hidden;
    animation:slideUp 0.3s ease;
}
@keyframes slideUp { from{opacity:0;transform:translateY(20px)} to{opacity:1;transform:translateY(0)} }
.chat-header {
    background:linear-gradient(135deg,#1e1b4b,#4c1d95);
    padding:18px 20px; display:flex; align-items:center; gap:12px;
}
.chat-avatar {
    width:40px; height:40px; border-radius:50%;
    background:rgba(255,255,255,0.2);
    display:flex; align-items:center; justify-content:center;
    font-size:1.2rem;
}
.chat-header-info { flex:1; }
.chat-header-name { color:#fff; font-weight:700; font-size:0.95rem; }
.chat-header-status { color:rgba(255,255,255,0.7); font-size:0.72rem; display:flex; align-items:center; gap:4px; }
.chat-header-status::before { content:''; width:7px; height:7px; background:#22c55e; border-radius:50%; display:inline-block; }
.chat-close { background:none; border:none; color:rgba(255,255,255,0.7); cursor:pointer; font-size:1.1rem; padding:4px; }
.chat-close:hover { color:#fff; }
.chat-messages {
    flex:1; overflow-y:auto; padding:16px; display:flex;
    flex-direction:column; gap:12px; background:#f8f7ff;
}
.chat-messages::-webkit-scrollbar { width:4px; }
.chat-messages::-webkit-scrollbar-thumb { background:#c4b5fd; border-radius:4px; }
.msg { max-width:82%; display:flex; flex-direction:column; gap:3px; }
.msg.bot { align-self:flex-start; }
.msg.user { align-self:flex-end; }
.msg-bubble {
    padding:10px 14px; border-radius:16px; font-size:0.85rem; line-height:1.5;
}
.msg.bot .msg-bubble { background:#fff; color:#1e1b4b; border-bottom-left-radius:4px; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.msg.user .msg-bubble { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border-bottom-right-radius:4px; }
.msg-time { font-size:0.65rem; color:#9ca3af; padding:0 4px; }
.msg.user .msg-time { text-align:right; }
.typing-indicator { display:flex; gap:4px; padding:10px 14px; background:#fff; border-radius:16px; border-bottom-left-radius:4px; width:fit-content; box-shadow:0 2px 8px rgba(0,0,0,0.07); }
.typing-dot { width:7px; height:7px; background:#a5b4fc; border-radius:50%; animation:typing 1.2s infinite; }
.typing-dot:nth-child(2) { animation-delay:0.2s; }
.typing-dot:nth-child(3) { animation-delay:0.4s; }
@keyframes typing { 0%,60%,100%{transform:translateY(0);opacity:0.4} 30%{transform:translateY(-6px);opacity:1} }
.chat-input-area {
    padding:14px 16px; background:#fff; border-top:1px solid #f3f4f6;
    display:flex; gap:10px; align-items:center;
}
#chat-input {
    flex:1; padding:10px 14px; border:1.5px solid #e5e7eb; border-radius:50px;
    font-size:0.88rem; outline:none; transition:all 0.2s; color:#1e1b4b;
}
#chat-input:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,0.1); }
#chat-send {
    width:40px; height:40px; border-radius:50%; border:none;
    background:linear-gradient(135deg,#6366f1,#8b5cf6);
    color:#fff; cursor:pointer; display:flex; align-items:center; justify-content:center;
    transition:all 0.2s; flex-shrink:0;
}
#chat-send:hover { transform:scale(1.1); }
</style>

<!-- Chatbot Toggle Button -->
<button id="chatbot-btn" onclick="toggleChat()" title="ድጋፍ ያግኙ" style="padding:0;overflow:hidden;">
    <span id="chat-icon-wrap" style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
        <img src="{{ asset('images/auth-side.jpg') }}" id="chat-photo" style="width:58px;height:58px;object-fit:cover;object-position:top;border-radius:50%;" alt="Teshome">
        <i class="fas fa-times" id="chat-icon" style="color:#fff;font-size:1.3rem;display:none;"></i>
    </span>
</button>

<!-- Chatbot Window -->
<div id="chatbot-window">
    <div class="chat-header">
        <div style="width:42px;height:42px;border-radius:50%;overflow:hidden;border:2px solid rgba(255,255,255,0.4);flex-shrink:0;">
            <img src="{{ asset('images/auth-side.jpg') }}" style="width:100%;height:100%;object-fit:cover;object-position:top;" alt="Teshome">
        </div>
        <div class="chat-header-info">
            <div class="chat-header-name">Teshome Admin Chat</div>
            <div class="chat-header-status">ዝግጁ ነኝ</div>
        </div>
        <button class="chat-close" onclick="toggleChat()"><i class="fas fa-times"></i></button>
    </div>
    <div class="chat-messages" id="chat-messages">
        <div class="msg bot">
            <div class="msg-bubble">👋 ሰላም! እኔ Teshome ነኝ — <strong>የኛ ገበያ</strong> ድጋፍ።<br>ምን ልረዳዎ እችላለሁ?</div>
            <div class="msg-time">አሁን</div>
        </div>
    </div>
    <div class="chat-input-area">
        <input type="text" id="chat-input" placeholder="ጥያቄዎን ይጻፉ..." onkeypress="if(event.key==='Enter') sendMessage()">
        <button id="chat-send" onclick="sendMessage()">
            <i class="fas fa-paper-plane" style="font-size:0.85rem;"></i>
        </button>
    </div>
</div>

<script>
function toggleChat() {
    const win = document.getElementById('chatbot-window');
    const photo = document.getElementById('chat-photo');
    const icon = document.getElementById('chat-icon');
    const isOpen = win.style.display === 'flex';
    win.style.display = isOpen ? 'none' : 'flex';
    photo.style.display = isOpen ? 'block' : 'none';
    icon.style.display = isOpen ? 'none' : 'block';
    if (!isOpen) setTimeout(() => document.getElementById('chat-input').focus(), 300);
}

function getTime() {
    return new Date().toLocaleTimeString('am-ET', {hour:'2-digit', minute:'2-digit'});
}

function appendMsg(text, type) {
    const msgs = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.className = `msg ${type}`;
    div.innerHTML = `<div class="msg-bubble">${text}</div><div class="msg-time">${getTime()}</div>`;
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function showTyping() {
    const msgs = document.getElementById('chat-messages');
    const div = document.createElement('div');
    div.id = 'typing';
    div.className = 'msg bot';
    div.innerHTML = '<div class="typing-indicator"><div class="typing-dot"></div><div class="typing-dot"></div><div class="typing-dot"></div></div>';
    msgs.appendChild(div);
    msgs.scrollTop = msgs.scrollHeight;
}

function removeTyping() {
    const t = document.getElementById('typing');
    if (t) t.remove();
}

function sendMessage() {
    const input = document.getElementById('chat-input');
    const msg = input.value.trim();
    if (!msg) return;

    appendMsg(msg, 'user');
    input.value = '';
    showTyping();

    $.ajax({
        url: '{{ route("chatbot") }}',
        method: 'POST',
        data: { message: msg, _token: '{{ csrf_token() }}' },
        success: function(res) {
            removeTyping();
            appendMsg(res.reply.replace(/\n/g, '<br>'), 'bot');
        },
        error: function() {
            removeTyping();
            appendMsg('ይቅርታ፣ ችግር አጋጥሟል። ቆይተው ይሞክሩ።', 'bot');
        }
    });
}
</script>
</body>
</html>
