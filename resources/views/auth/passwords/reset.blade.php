@extends('layouts.auth')
@section('title', 'የይለፍ ቃል ቀይር')

@section('content')
<div style="background:#f8f7ff;min-height:100vh;display:flex;align-items:center;padding:40px 0;">
<div class="container">
<div class="row justify-content-center">
<div class="col-md-5">
    <div style="background:#fff;border-radius:24px;box-shadow:0 20px 60px rgba(99,102,241,0.12);padding:48px 40px;">
        <div style="text-align:center;margin-bottom:28px;">
            <div style="width:64px;height:64px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
                <i class="fas fa-key" style="color:#6366f1;font-size:1.5rem;"></i>
            </div>
            <h2 style="font-weight:800;color:#1e1b4b;margin-bottom:6px;">አዲስ የይለፍ ቃል</h2>
            <p style="color:#9ca3af;font-size:0.88rem;">አዲስ የይለፍ ቃልዎን ያስገቡ።</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            @foreach([['email','ኢሜይል አድራሻ','fa-envelope','email',$email??old('email')],['password','አዲስ የይለፍ ቃል','fa-lock','new-password',null],['password_confirmation','የይለፍ ቃል ያረጋግጡ','fa-check-circle','new-password',null]] as [$name,$label,$icon,$auto,$val])
            <div style="margin-bottom:18px;">
                <div style="font-size:0.75rem;font-weight:700;color:#6b7280;text-transform:uppercase;letter-spacing:1px;margin-bottom:7px;">{{ $label }}</div>
                <div style="position:relative;">
                    <i class="fas {{ $icon }}" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#9ca3af;"></i>
                    <input type="{{ $name==='email'?'email':'password' }}" name="{{ $name }}" value="{{ $val }}"
                           autocomplete="{{ $auto }}" required
                           style="width:100%;padding:12px 16px 12px 42px;border:1.5px solid #e5e7eb;border-radius:12px;font-size:0.92rem;color:#1e1b4b;background:#f9fafb;outline:none;"
                           class="@error($name) is-invalid @enderror">
                </div>
                @error($name)<div style="color:#dc2626;font-size:0.8rem;margin-top:6px;">{{ $message }}</div>@enderror
            </div>
            @endforeach

            <button type="submit" style="width:100%;padding:13px;border:none;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;font-size:0.95rem;cursor:pointer;box-shadow:0 4px 15px rgba(99,102,241,0.3);">
                <i class="fas fa-save me-2"></i>የይለፍ ቃል ቀይር
            </button>
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection
