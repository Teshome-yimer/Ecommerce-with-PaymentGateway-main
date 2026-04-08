@extends('layouts.app')
@section('title', 'ይመዝገቡ')

@push('styles')
<style>
.auth-page { min-height: 100vh; background: #f0f4ff; display: flex; align-items: center; padding: 40px 0; }
.auth-card { background: #fff; border-radius: 28px; box-shadow: 0 20px 60px rgba(99,102,241,0.13); overflow: hidden; display: flex; min-height: 600px; }
.auth-form-side { padding: 48px 44px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
.auth-image-side {
    flex: 1; position: relative; overflow: hidden;
    background: linear-gradient(135deg, #1e1b4b, #4c1d95);
    display: flex; flex-direction: column; align-items: center; justify-content: flex-end;
    min-height: 400px;
}
.auth-image-side img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; object-position: top; opacity: 0.85; }
.auth-image-overlay {
    position: relative; z-index: 2; width: 100%; padding: 28px;
    background: linear-gradient(to top, rgba(15,12,41,0.92) 0%, transparent 100%);
    text-align: center;
}
.auth-brand { font-size: 2rem; font-weight: 900; color: #fff; letter-spacing: 2px; text-shadow: 0 2px 12px rgba(0,0,0,0.5); }
.auth-brand-sub { color: rgba(255,255,255,0.75); font-size: 0.9rem; margin-top: 4px; }
.auth-title { font-size: 1.7rem; font-weight: 800; color: #1e1b4b; margin-bottom: 4px; }
.auth-subtitle { color: #6b7280; font-size: 0.9rem; margin-bottom: 28px; }
.auth-input {
    width: 100%; padding: 13px 16px 13px 44px; border: 1.5px solid #e5e7eb;
    border-radius: 12px; font-size: 0.95rem; color: #1e1b4b; background: #f9fafb;
    transition: all 0.2s; outline: none;
}
.auth-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.12); }
.auth-input-wrap { position: relative; margin-bottom: 16px; }
.auth-input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.95rem; }
.auth-btn {
    width: 100%; padding: 14px; border: none; border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-size: 1rem; font-weight: 700; cursor: pointer;
    box-shadow: 0 6px 20px rgba(99,102,241,0.35); transition: all 0.3s; margin-top: 4px;
}
.auth-btn:hover { transform: translateY(-2px); box-shadow: 0 10px 28px rgba(99,102,241,0.5); }
.auth-divider { display: flex; align-items: center; gap: 12px; margin: 20px 0; color: #9ca3af; font-size: 0.82rem; }
.auth-divider::before, .auth-divider::after { content: ''; flex: 1; height: 1px; background: #e5e7eb; }
.social-btn {
    flex: 1; padding: 10px 8px; border-radius: 10px; border: 1.5px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center; gap: 7px;
    font-size: 0.82rem; font-weight: 600; cursor: pointer; transition: all 0.2s; text-decoration: none;
}
.social-btn:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
@media(max-width:768px){ .auth-image-side{ display:none; } .auth-form-side{ padding: 32px 24px; } }
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="auth-card">

                    <!-- Form Side -->
                    <div class="auth-form-side">
                        <div class="auth-title">መለያ ይፍጠሩ</div>
                        <div class="auth-subtitle">ወደ የኛ ገበያ እንኳን ደህና መጡ!</div>

                        @if($errors->any())
                            <div style="background:#fef2f2;border:1px solid #fca5a5;border-radius:10px;padding:12px 16px;margin-bottom:16px;color:#dc2626;font-size:0.85rem;">
                                @foreach($errors->all() as $e) <div>• {{ $e }}</div> @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="auth-input-wrap">
                                <i class="fas fa-user auth-input-icon"></i>
                                <input type="text" name="name" class="auth-input" placeholder="ሙሉ ስም" value="{{ old('name') }}" required autofocus>
                            </div>
                            <div class="auth-input-wrap">
                                <i class="fas fa-envelope auth-input-icon"></i>
                                <input type="email" name="email" class="auth-input" placeholder="ኢሜይል አድራሻ" value="{{ old('email') }}" required>
                            </div>
                            <div class="auth-input-wrap">
                                <i class="fas fa-lock auth-input-icon"></i>
                                <input type="password" name="password" class="auth-input" placeholder="የይለፍ ቃል" required>
                            </div>
                            <div class="auth-input-wrap">
                                <i class="fas fa-check-circle auth-input-icon"></i>
                                <input type="password" name="password_confirmation" class="auth-input" placeholder="የይለፍ ቃል ያረጋግጡ" required>
                            </div>
                            <button type="submit" class="auth-btn">
                                <i class="fas fa-user-plus me-2"></i>ይመዝገቡ
                            </button>
                        </form>

                        <div class="auth-divider">ወይም በ</div>
                        <div class="d-flex gap-2 mb-4">
                            <a href="{{ url('auth/google') }}" class="social-btn" style="color:#3c4043;background:#fff;">
                                <svg width="16" height="16" viewBox="0 0 48 48"><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/></svg>
                                Google
                            </a>
                            <a href="{{ url('auth/github') }}" class="social-btn" style="color:#fff;background:#24292e;border-color:#24292e;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M12 0C5.37 0 0 5.37 0 12c0 5.3 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61-.546-1.385-1.335-1.755-1.335-1.755-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 21.795 24 17.295 24 12c0-6.63-5.37-12-12-12"/></svg>
                                GitHub
                            </a>
                            <a href="{{ url('auth/facebook') }}" class="social-btn" style="color:#fff;background:#1877F2;border-color:#1877F2;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="white"><path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.268h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/></svg>
                                Facebook
                            </a>
                        </div>

                        <div style="text-align:center;font-size:0.88rem;color:#6b7280;">
                            መለያ አለዎት? <a href="{{ route('login') }}" style="color:#6366f1;font-weight:700;text-decoration:none;">ይግቡ</a>
                        </div>
                    </div>

                    <!-- Image Side -->
                    <div class="auth-image-side">
                        <img src="{{ asset('images/auth-side.jpg') }}" alt="የኛ ገበያ"
                             onerror="this.src='{{ asset('images/hero.jpg') }}'">
                        <div class="auth-image-overlay">
                            <div class="auth-brand">የኛ ገበያ</div>
                            <div class="auth-brand-sub">ፈጣን • ቀላል • የታመነ</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
