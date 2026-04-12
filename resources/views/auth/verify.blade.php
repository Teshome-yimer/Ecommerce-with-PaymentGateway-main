@extends('layouts.auth')
@section('title', 'ኢሜይል ያረጋግጡ')

@push('styles')
<style>
.auth-page { background:#f8f7ff; min-height:100vh; display:flex; align-items:center; padding:40px 0; }
</style>
@endpush

@section('content')
<div class="auth-page">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-6">
    <div style="background:#fff;border-radius:24px;box-shadow:0 20px 60px rgba(99,102,241,0.12);padding:48px 40px;text-align:center;">
        <div style="width:72px;height:72px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="fas fa-envelope" style="color:#6366f1;font-size:1.8rem;"></i>
        </div>
        <h2 style="font-weight:800;color:#1e1b4b;margin-bottom:8px;">ኢሜይልዎን ያረጋግጡ</h2>
        <p style="color:#9ca3af;margin-bottom:24px;">ከመቀጠልዎ በፊት ኢሜይልዎን ያረጋግጡ። የማረጋገጫ ሊንክ ወደ ኢሜይልዎ ተልኳል።</p>

        @if(session('resent'))
            <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px;color:#16a34a;font-size:0.88rem;margin-bottom:20px;">
                <i class="fas fa-check-circle me-2"></i>አዲስ የማረጋገጫ ሊንክ ወደ ኢሜይልዎ ተልኳል።
            </div>
        @endif

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" style="padding:13px 32px;border:none;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;cursor:pointer;box-shadow:0 4px 15px rgba(99,102,241,0.3);">
                <i class="fas fa-paper-plane me-2"></i>እንደገና ላክ
            </button>
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection
