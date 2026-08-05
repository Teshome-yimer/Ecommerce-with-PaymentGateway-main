<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ተሸሾፕ - የኢትዮጵያ የተመራጭ የኦንላይን ግዢ መድረክ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', sans-serif; box-sizing: border-box; margin: 0; padding: 0; }
        html { scroll-behavior: smooth; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            background-attachment: fixed;
            overflow-x: hidden;
            position: relative;
        }
        body::before {
            content: ''; position: fixed; width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, transparent 70%);
            top: -150px; right: -150px; border-radius: 50%;
            animation: glow 5s ease-in-out infinite;
        }
        body::after {
            content: ''; position: fixed; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(236,72,153,0.15) 0%, transparent 70%);
            bottom: -100px; left: -100px; border-radius: 50%;
            animation: glow 6s ease-in-out infinite reverse;
        }
        @keyframes glow { 0%,100%{transform:scale(1);opacity:0.6} 50%{transform:scale(1.2);opacity:1} }

        .navbar {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }
        .brand-logo {
            width:42px;height:42px;
            background:linear-gradient(135deg,#6366f1,#8b5cf6);
            border-radius:12px;
            display:flex;align-items:center;justify-content:center;
            font-size:1.1rem;color:#fff;
        }
        .brand-text { font-size:1.3rem;font-weight:800;color:#fff; }
        .nav-btn-login {
            padding:8px 20px;border-radius:50px;
            border:1.5px solid rgba(255,255,255,0.2);
            color:#fff;font-weight:600;font-size:0.88rem;
            text-decoration:none;transition:all 0.2s;
        }
        .nav-btn-login:hover { background:rgba(255,255,255,0.1);color:#fff; }
        .nav-btn-register {
            padding:8px 22px;border-radius:50px;
            background:linear-gradient(135deg,#6366f1,#8b5cf6);
            color:#fff;font-weight:700;font-size:0.88rem;
            text-decoration:none;transition:all 0.3s;
            box-shadow:0 4px 15px rgba(99,102,241,0.4);
        }
        .nav-btn-register:hover { transform:translateY(-2px);color:#fff;box-shadow:0 8px 25px rgba(99,102,241,0.6); }

        .hero {
            min-height: 88vh;
            display: flex;
            align-items: center;
            position: relative;
            z-index: 2;
            padding: 40px 0;
        }
        .hero-badge {
            display:inline-block;
            background:rgba(99,102,241,0.2);
            border:1px solid rgba(99,102,241,0.5);
            color:#a5b4fc;
            padding:6px 18px;
            border-radius:50px;
            font-size:0.82rem;
            letter-spacing:0.5px;
            margin-bottom:1.5rem;
            animation:fadeInDown 0.8s ease;
        }
        .hero-title {
            font-size:clamp(2.2rem,5vw,3.8rem);
            font-weight:800;
            color:#fff;
            line-height:1.1;
            margin-bottom:1rem;
            animation:fadeInUp 0.9s ease;
        }
        .hero-title span {
            background:linear-gradient(90deg,#818cf8,#ec4899,#f59e0b);
            -webkit-background-clip:text;
            -webkit-text-fill-color:transparent;
            background-clip:text;
        }
        .hero-sub {
            color:rgba(255,255,255,0.65);
            font-size:1.05rem;
            line-height:1.7;
            margin-bottom:2rem;
            animation:fadeInUp 1s ease;
            max-width:520px;
        }
        .hero-actions {
            display:flex;flex-wrap:wrap;gap:12px;
            animation:fadeInUp 1.1s ease;
        }
        .btn-primary-grad {
            padding:14px 32px;border-radius:50px;
            background:linear-gradient(135deg,#6366f1,#8b5cf6);
            color:#fff;font-weight:700;font-size:0.95rem;
            text-decoration:none;transition:all 0.3s;
            box-shadow:0 8px 25px rgba(99,102,241,0.4);
            display:inline-flex;align-items:center;gap:8px;
        }
        .btn-primary-grad:hover {
            transform:translateY(-3px);
            box-shadow:0 12px 35px rgba(99,102,241,0.6);
            color:#fff;
        }
        .btn-outline-white {
            padding:14px 32px;border-radius:50px;
            border:2px solid rgba(255,255,255,0.25);
            color:#fff;font-weight:600;font-size:0.95rem;
            text-decoration:none;transition:all 0.3s;
            display:inline-flex;align-items:center;gap:8px;
        }
        .btn-outline-white:hover {
            background:rgba(255,255,255,0.08);
            border-color:rgba(255,255,255,0.5);
            color:#fff;
            transform:translateY(-3px);
        }

        .hero-image-wrap {
            position:relative;
            animation:floatUp 1.2s ease;
        }
        .hero-image-wrap img {
            border-radius:28px;
            box-shadow:0 30px 80px rgba(0,0,0,0.5);
            width:100%;
        }
        .float-card {
            position:absolute;
            background:rgba(255,255,255,0.1);
            backdrop-filter:blur(14px);
            border:1px solid rgba(255,255,255,0.2);
            border-radius:16px;
            padding:14px 20px;
            color:#fff;
            animation:float 3s ease-in-out infinite;
        }
        .float-card.card-1 { top:20px;left:-20px;animation-delay:0s; }
        .float-card.card-2 { bottom:30px;right:-10px;animation-delay:1.5s; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }
        @keyframes fadeInUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
        @keyframes fadeInDown { from{opacity:0;transform:translateY(-20px)} to{opacity:1;transform:translateY(0)} }
        @keyframes floatUp { from{opacity:0;transform:translateY(40px)} to{opacity:1;transform:translateY(0)} }

        .features-section {
            background:rgba(255,255,255,0.03);
            backdrop-filter:blur(8px);
            border-top:1px solid rgba(255,255,255,0.06);
            border-bottom:1px solid rgba(255,255,255,0.06);
            padding:50px 0;
            position:relative;
            z-index:2;
        }
        .feature-col { text-align:center;color:#fff;padding:10px; }
        .feature-icon {
            width:56px;height:56px;
            background:linear-gradient(135deg,rgba(99,102,241,0.25),rgba(139,92,246,0.25));
            border:1px solid rgba(99,102,241,0.4);
            border-radius:16px;
            display:flex;align-items:center;justify-content:center;
            margin:0 auto 12px;
            font-size:1.3rem;
            color:#a5b4fc;
        }
        .feature-title { font-weight:700;font-size:0.95rem;margin-bottom:4px; }
        .feature-desc { color:rgba(255,255,255,0.55);font-size:0.78rem; }

        .footer {
            padding:24px 0;
            text-align:center;
            color:rgba(255,255,255,0.4);
            font-size:0.82rem;
            position:relative;
            z-index:2;
            border-top:1px solid rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container py-2">
            <a class="d-flex align-items-center gap-2 text-decoration-none" href="#">
                <div class="brand-logo"><i class="fas fa-store"></i></div>
                <span class="brand-text">ተሸሾፕ</span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('login') }}" class="nav-btn-login"><i class="fas fa-sign-in-alt me-1"></i>ይግቡ</a>
                <a href="{{ route('register') }}" class="nav-btn-register"><i class="fas fa-user-plus me-1"></i>ይመዝገቡ</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="hero">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="hero-badge">🇪🇹 የኢትዮጵያ #1 የኦንላይን ግዢ መድረክ</div>
                    <h1 class="hero-title">ፈጣን፣ ቀላል እና<br><span>የታመነ ግዢ</span></h1>
                    <p class="hero-sub">
                        በተሸሾፕ ላይ ስልክዎን ብቻ በመጠቀም ማንኛውንም ምርት ከቤትዎ ውስጥ ይግዙ። 
                        ፈጣን መላኪያ፣ ደህንነቱ የተጠበቀ ክፍያ እና ምርጥ ደንበኛ ድጋፍ።
                    </p>
                    <div class="hero-actions">
                        <a href="{{ route('login') }}" class="btn-primary-grad">
                            <i class="fas fa-shopping-bag"></i>አሁን ይግዙ
                        </a>
                        <a href="{{ route('register') }}" class="btn-outline-white">
                            <i class="fas fa-user-plus"></i>አካውንት ፍጠሩ
                        </a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="hero-image-wrap">
                        <img src="{{ asset('images/hero.jpg') }}" alt="ተሸሾፕ" onerror="this.style.display='none'">
                        <div style="position:absolute;bottom:0;left:0;right:0;border-radius:0 0 28px 28px;background:linear-gradient(to top, rgba(0,0,0,0.75) 0%, transparent 100%);padding:20px 24px 18px;display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                            <span style="color:rgba(255,255,255,0.75);font-size:0.75rem;font-weight:600;white-space:nowrap;">በኩል ይክፈሉ</span>
                            <span style="background:#00897b;color:#fff;font-size:0.7rem;padding:5px 12px;border-radius:20px;font-weight:700;">Telebirr</span>
                            <span style="background:#1565c0;color:#fff;font-size:0.7rem;padding:5px 12px;border-radius:20px;font-weight:700;">CBEBirr</span>
                            <span style="background:#7c3aed;color:#fff;font-size:0.7rem;padding:5px 12px;border-radius:20px;font-weight:700;">Chapa</span>
                            <span style="background:#16a34a;color:#fff;font-size:0.7rem;padding:5px 12px;border-radius:20px;font-weight:700;">Visa/MC</span>
                        </div>
                        <div class="float-card card-1">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.3rem;">🚚</span>
                                <div><div style="font-weight:700;font-size:0.85rem;">ፈጣን መላኪያ</div><div style="opacity:0.7;font-size:0.72rem;">በ24 ሰዓት ውስጥ</div></div>
                            </div>
                        </div>
                        <div class="float-card card-2">
                            <div class="d-flex align-items-center gap-2">
                                <span style="font-size:1.3rem;">⭐</span>
                                <div><div style="font-weight:700;font-size:0.85rem;">4.9 / 5</div><div style="opacity:0.7;font-size:0.72rem;">ደንበኞች እናመሰግናለን</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="features-section">
        <div class="container">
            <div class="row g-3">
                <div class="col-6 col-lg-3">
                    <div class="feature-col">
                        <div class="feature-icon"><i class="fas fa-shipping-fast"></i></div>
                        <div class="feature-title">ፈጣን መላኪያ</div>
                        <div class="feature-desc">በኢትዮጵያ ውስጥ በፍጥነት</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="feature-col">
                        <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
                        <div class="feature-title">ደህን ክፍያ</div>
                        <div class="feature-desc">ምስጠራ የተደረገ ግብይት</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="feature-col">
                        <div class="feature-icon"><i class="fas fa-undo"></i></div>
                        <div class="feature-title">ቀላል መመለስ</div>
                        <div class="feature-desc">በ7 ቀን ውስጥ ነፃ መመለስ</div>
                    </div>
                </div>
                <div class="col-6 col-lg-3">
                    <div class="feature-col">
                        <div class="feature-icon"><i class="fas fa-headset"></i></div>
                        <div class="feature-title">24/7 ድጋፍ</div>
                        <div class="feature-desc">ሁልጊዜ ለእርስዎ ይዘጋጃል</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} <strong style="color:rgba(255,255,255,0.6);">ተሸሾፕ</strong>. ሁሉም መብቶች የተጠበቁ ናቸው።
        </div>
    </footer>

    <script>
        setTimeout(function() {
            @if(Auth::check())
                window.location.href = "{{ route('home') }}";
            @endif
        }, 100);
    </script>
</body>
</html>
