@extends('layouts.app')
@section('title', 'የይለፍ ቃል ዳግም ማስጀመር')

@section('content')
<div style="background:#f8f7ff;min-height:100vh;display:flex;align-items:center;padding:40px 0;">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-5">
    <div style="background:#fff;border-radius:24px;box-shadow:0 20px 60px rgba(99,102,241,0.12);padding:48px 40px;">
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:64px;height:64px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fas fa-lock" style="color:#6366f1;font-size:1.5rem;"></i>
            </div>
            <h2 style="font-weight:800;color:#1e1b4b;margin-bottom:6px;">የይለፍ ቃል ረሱ?</h2>
            <p style="color:#9ca3af;font-size:0.88rem;">ኢሜይልዎን ያስገቡ — የዳግም ማስጀመሪያ ሊንክ እንልክልዎታለን።</p>
        </div>

        @if(session('status'))
            <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px 16px;color:#16a34a;font-size:0.88rem;margin-bottom:20px;">
                <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div style="margin-bottom:20px;">
                <div style="font-size:0.75rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:1px;margin-bottom:7px;">ኢሜይል አድራሻ</div>
                <div style="position:relative;">
                    <i class="fas fa-envelope" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;"></i>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           style="width:100%;padding:12px 16px 12px 42px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:0.92rem;color:#1e1b4b;background:#f9fafb;outline:none;"
                           placeholder="ኢሜይልዎን ያስገቡ">
                </div>
                @error('email')<div style="color:#dc2626;font-size:0.8rem;margin-top:6px;">{{ $message }}</div>@enderror
            </div>
            <button type="submit" style="width:100%;padding:13px;border:none;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 4px 15px rgba(99,102,241,0.3);">
                <i class="fas fa-paper-plane me-2"></i>ሊንክ ላክ
            </button>
        </form>
        <div style="text-align:center;margin-top:20px;font-size:0.85rem;color:#9ca3af;">
            <a href="{{ route('login') }}" style="color:#6366f1;font-weight:600;text-decoration:none;">← ወደ ግባ ተመለስ</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection
