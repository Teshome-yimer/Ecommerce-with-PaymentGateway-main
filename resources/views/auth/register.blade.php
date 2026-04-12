@extends('layouts.auth')
@section('title', 'ይመዝገቡ')

@push('styles')
<style>
.auth-page {
    min-height: 100vh;
    background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
    display: flex; align-items: center; justify-content: center;
    padding: 20px; position: relative; overflow: hidden;
}
.auth-page::before {
    content: ''; position: absolute;
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(99,102,241,0.25) 0%, transparent 70%);
    top: -100px; right: -100px; border-radius: 50%;
    animation: pulse 4s ease-in-out infinite;
}
.auth-page::after {
    content: ''; position: absolute;
    width: 350px; height: 350px;
    background: radial-gradient(circle, rgba(236,72,153,0.15) 0%, transparent 70%);
    bottom: -80px; left: -80px; border-radius: 50%;
    animation: pulse 5s ease-in-out infinite reverse;
}
@keyframes pulse { 0%,100%{transform:scale(1);opacity:0.7} 50%{transform:scale(1.15);opacity:1} }
.auth-box {
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 28px; padding: 44px 40px;
    width: 100%; max-width: 460px;
    position: relative; z-index: 2;
    box-shadow: 0 25px 60px rgba(0,0,0,0.4);
    animation: slideUp 0.6s ease;
}
@keyframes slideUp { from{opacity:0;transform:translateY(30px)} to{opacity:1;transform:translateY(0)} }
.auth-logo { display:flex;align-items:center;gap:12px;justify-content:center;margin-bottom:28px; }
.auth-logo-icon { width:48px;height:48px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:1.4rem; }
.auth-logo-text { font-size:1.5rem;font-weight:800;color:#fff; }
.auth-title { font-size:1.5rem;font-weight:800;color:#fff;text-align:center;margin-bottom:6px; }
.auth-subtitle { color:rgba(255,255,255,0.55);font-size:0.85rem;text-align:center;margin-bottom:24px; }
.auth-label { font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.6);text-transform:uppercase;letter-spacing:1px;margin-bottom:6px; }
.auth-input { width:100%;padding:12px 16px 12px 42px;background:rgba(255,255,255,0.08);border:1.5px solid rgba(255,255,255,0.12);border-radius:12px;color:#fff;font-size:0.9rem;outline:none;transition:all 0.2s;margin-bottom:16px; }
.auth-input::placeholder { color:rgba(255,255,255,0.35); }
.auth-input:focus { border-color:#6366f1;background:rgba(99,102,241,0.1);box-shadow:0 0 0 3px rgba(99,102,241,0.2); }
.auth-input-wrap { position:relative; }
.auth-input-icon { position:absolute;left:13px;top:13px;color:rgba(255,255,255,0.4);font-size:0.88rem; }
.auth-btn { width:100%;padding:13px;border:none;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 6px 20px rgba(99,102,241,0.4);transition:all 0.3s;margin-top:4px; }
.auth-btn:hover { transform:translateY(-2px);box-shadow:0 10px 28px rgba(99,102,241,0.6); }
.auth-divider { display:flex;align-items:center;gap:12px;margin:18px 0; }
.auth-divider::before,.auth-divider::after { content:'';flex:1;height:1px;background:rgba(255,255,255,0.12); }
.auth-divider span { color:rgba(255,255,255,0.4);font-size:0.75rem; }
.social-btn { flex:1;padding:9px 6px;border-radius:10px;border:1.5px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.06);display:flex;align-items:center;justify-content:center;gap:6px;font-size:0.78rem;font-weight:600;cursor:pointer;transition:all 0.2s;text-decoration:none;color:#fff; }
.social-btn:hover { background:rgba(255,255,255,0.12);color:#fff;transform:translateY(-2px); }
.auth-footer { text-align:center;margin-top:20px;font-size:0.85rem;color:rgba(255,255,255,0.5); }
.auth-footer a { color:#818cf8;font-weight:700;text-decoration:none; }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-box">
        <div class="auth-logo">
            <div class="auth-logo-icon"><i class="fas fa-store" style="color:#fff;"></i></div>
            <div class="auth-logo-text">የኛ ገበያ</div>
        </div>

        <div class="auth-title">መለያ ይፍጠሩ 🎉</div>
        <div class="auth-subtitle">ወደ የኛ ገበያ እንኳን ደህና መጡ!</div>

        @if($errors->any())
            <div style="background:rgba(239,68,68,0.15);border:1px solid rgba(239,68,68,0.3);border-radius:10px;padding:10px 14px;color:#fca5a5;font-size:0.82rem;margin-bottom:16px;">
                @foreach($errors->all() as $e)<div>• {{ $e }}</div>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="auth-label">ሙሉ ስም</div>
            <div class="auth-input-wrap">
                <i class="fas fa-user auth-input-icon"></i>
                <input type="text" name="name" class="auth-input" placeholder="ሙሉ ስምዎን ያስገቡ" value="{{ old('name') }}" required autofocus>
            </div>

            <div class="auth-label">ኢሜይል አድራሻ</div>
            <div class="auth-input-wrap">
                <i class="fas fa-envelope auth-input-icon"></i>
                <input type="email" name="email" class="auth-input" placeholder="example@gmail.com" value="{{ old('email') }}" required>
            </div>

            <div class="auth-label">የይለፍ ቃል</div>
            <div class="auth-input-wrap">
                <i class="fas fa-lock auth-input-icon"></i>
                <input type="password" name="password" class="auth-input" placeholder="••••••••" required>
            </div>

            <div class="auth-label">የይለፍ ቃል ያረጋግጡ</div>
            <div class="auth-input-wrap">
                <i class="fas fa-check-circle auth-input-icon"></i>
                <input type="password" name="password_confirmation" class="auth-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="auth-btn"><i class="fas fa-user-plus me-2"></i>ይመዝገቡ</button>
        </form>

        <div class="auth-divider"><span>ወይም በ</span></div>

        <div class="d-flex gap-2">
            <a href="{{ url('auth/google') }}" class="social-btn">
                <svg width="15" height="15" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                Google
            </a>
            <a href="{{ url('auth/github') }}" class="social-btn" style="background:#24292e;border-color:#24292e;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.335-1.755-1.335-1.755-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                GitHub
            </a>
            <a href="{{ url('auth/facebook') }}" class="social-btn" style="background:#1877F2;border-color:#1877F2;">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="white"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                Facebook
            </a>
        </div>

        <div class="auth-footer">
            መለያ አለዎት? <a href="{{ route('login') }}">ይግቡ →</a>
        </div>
    </div>
</div>
@endsection
