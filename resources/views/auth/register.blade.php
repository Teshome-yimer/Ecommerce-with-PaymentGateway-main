<!DOCTYPE html>
<html lang="am">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ይመዝገቡ - የኛ ገበያ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family:'Inter',sans-serif;box-sizing:border-box;margin:0;padding:0; }
        html { overflow-y:auto; }
        body {
            min-height:100vh;
            background:linear-gradient(135deg,#0f0c29 0%,#302b63 50%,#24243e 100%);
            display:flex;align-items:flex-start;justify-content:center;padding:20px;
            position:relative;overflow-x:hidden;overflow-y:auto;
            background-attachment:fixed;
        }
        body::before { content:'';position:fixed;width:600px;height:600px;background:radial-gradient(circle,rgba(99,102,241,0.2) 0%,transparent 70%);top:-150px;right:-150px;border-radius:50%;animation:glow 5s ease-in-out infinite; }
        body::after { content:'';position:fixed;width:400px;height:400px;background:radial-gradient(circle,rgba(236,72,153,0.15) 0%,transparent 70%);bottom:-100px;left:-100px;border-radius:50%;animation:glow 6s ease-in-out infinite reverse; }
        @keyframes glow { 0%,100%{transform:scale(1);opacity:0.6} 50%{transform:scale(1.2);opacity:1} }
        .card { background:rgba(255,255,255,0.06);backdrop-filter:blur(24px);border:1px solid rgba(255,255,255,0.1);border-radius:28px;padding:44px 40px;width:100%;max-width:440px;position:relative;z-index:2;box-shadow:0 30px 70px rgba(0,0,0,0.5);animation:up 0.6s ease; }
        @keyframes up { from{opacity:0;transform:translateY(28px)} to{opacity:1;transform:translateY(0)} }
        .brand { display:flex;align-items:center;gap:12px;justify-content:center;margin-bottom:28px; }
        .brand-icon { width:50px;height:50px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;color:#fff; }
        .brand-name { font-size:1.6rem;font-weight:800;color:#fff; }
        h2 { font-size:1.5rem;font-weight:800;color:#fff;text-align:center;margin-bottom:6px; }
        .sub { color:rgba(255,255,255,0.5);font-size:0.85rem;text-align:center;margin-bottom:24px; }
        label { font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.55);text-transform:uppercase;letter-spacing:1px;display:block;margin-bottom:6px; }
        .input-wrap { position:relative;margin-bottom:16px; }
        .input-wrap i { position:absolute;left:14px;top:50%;transform:translateY(-50%);color:rgba(255,255,255,0.35);font-size:0.88rem; }
        input[type=email],input[type=password],input[type=text] { width:100%;padding:12px 16px 12px 42px;background:rgba(255,255,255,0.07);border:1.5px solid rgba(255,255,255,0.12);border-radius:12px;color:#fff;font-size:0.9rem;outline:none;transition:all 0.2s; }
        input::placeholder { color:rgba(255,255,255,0.3); }
        input:focus { border-color:#6366f1;background:rgba(99,102,241,0.12);box-shadow:0 0 0 3px rgba(99,102,241,0.2); }
        .btn-main { width:100%;padding:13px;border:none;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 6px 20px rgba(99,102,241,0.4);transition:all 0.3s;margin-top:4px; }
        .btn-main:hover { transform:translateY(-2px);box-shadow:0 10px 28px rgba(99,102,241,0.6); }
        .divider { display:flex;align-items:center;gap:12px;margin:18px 0; }
        .divider::before,.divider::after { content:'';flex:1;height:1px;background:rgba(255,255,255,0.1); }
        .divider span { color:rgba(255,255,255,0.35);font-size:0.75rem; }
        .socials { display:flex;gap:10px; }
        .soc-btn { flex:1;padding:9px 6px;border-radius:10px;border:1.5px solid rgba(255,255,255,0.1);background:rgba(255,255,255,0.05);display:flex;align-items:center;justify-content:center;gap:6px;font-size:0.78rem;font-weight:600;color:#fff;text-decoration:none;transition:all 0.2s; }
        .soc-btn:hover { background:rgba(255,255,255,0.12);color:#fff;transform:translateY(-2px); }
        .footer-link { text-align:center;margin-top:20px;font-size:0.85rem;color:rgba(255,255,255,0.45); }
        .footer-link a { color:#818cf8;font-weight:700;text-decoration:none; }
        .err { background:rgba(239,68,68,0.12);border:1px solid rgba(239,68,68,0.25);border-radius:10px;padding:10px 14px;color:#fca5a5;font-size:0.82rem;margin-bottom:16px; }
    </style>
</head>
<body>
    <div class="card">
        <div class="brand">
            <div class="brand-icon"><i class="fas fa-store"></i></div>
            <div class="brand-name">የኛ ገበያ</div>
        </div>

        <h2>መለያ ይፍጠሩ 🎉</h2>
        <p class="sub">ወደ የኛ ገበያ እንኳን ደህና መጡ!</p>

        @if($errors->any())
            <div class="err">@foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach</div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <label>ሙሉ ስም</label>
            <div class="input-wrap">
                <i class="fas fa-user"></i>
                <input type="text" name="name" placeholder="ሙሉ ስምዎን ያስገቡ" value="{{ old('name') }}" required autofocus>
            </div>

            <label>ኢሜይል አድራሻ</label>
            <div class="input-wrap">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="example@gmail.com" value="{{ old('email') }}" required>
            </div>

            <label>የይለፍ ቃል</label>
            <div class="input-wrap">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <label>የይለፍ ቃል ያረጋግጡ</label>
            <div class="input-wrap">
                <i class="fas fa-check-circle"></i>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-main"><i class="fas fa-user-plus me-2"></i>ይመዝገቡ</button>
        </form>

        <div class="divider"><span>ወይም በ</span></div>

        <div class="socials">
            <a href="{{ url('auth/google') }}" class="soc-btn">
                <svg width="15" height="15" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                Google
            </a>
            <a href="{{ url('auth/github') }}" class="soc-btn" style="background:#24292e;border-color:#24292e;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.335-1.755-1.335-1.755-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                GitHub
            </a>
            <a href="{{ url('auth/facebook') }}" class="soc-btn" style="background:#1877F2;border-color:#1877F2;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                Facebook
            </a>
        </div>

        <div class="footer-link">
            መለያ አለዎት? <a href="{{ route('login') }}">ይግቡ →</a>
        </div>
    </div>
</body>
</html>
