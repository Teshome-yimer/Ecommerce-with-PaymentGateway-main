@extends('layouts.app')
@section('title', 'የእኔ መለያ')

@push('styles')
<style>
.profile-page { background: #f8f7ff; min-height: 100vh; padding: 40px 0; }

.profile-hero {
    background: linear-gradient(135deg, #1e1b4b, #4c1d95);
    border-radius: 24px;
    padding: 40px 36px;
    display: flex;
    align-items: center;
    gap: 32px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.profile-hero::before {
    content: '';
    position: absolute;
    width: 300px; height: 300px;
    background: rgba(99,102,241,0.2);
    border-radius: 50%;
    top: -100px; right: -80px;
}
.avatar-wrap {
    position: relative;
    flex-shrink: 0;
}
.avatar-img {
    width: 110px; height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.avatar-placeholder {
    width: 110px; height: 110px;
    border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 2.5rem; font-weight: 800; color: #fff;
    border: 4px solid rgba(255,255,255,0.3);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.avatar-edit-btn {
    position: absolute;
    bottom: 4px; right: 4px;
    width: 32px; height: 32px;
    background: #6366f1;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    border: 2px solid #fff;
    transition: all 0.2s;
}
.avatar-edit-btn:hover { background: #4f46e5; transform: scale(1.1); }
.profile-hero-info { flex: 1; position: relative; z-index: 1; }
.profile-name { font-size: 1.8rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
.profile-email { color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-bottom: 8px; }
.profile-since { display: inline-flex; align-items: center; gap: 6px; background: rgba(255,255,255,0.1); color: rgba(255,255,255,0.8); font-size: 0.78rem; padding: 4px 12px; border-radius: 20px; }

.section-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.08);
    overflow: hidden;
    margin-bottom: 24px;
}
.section-header {
    padding: 18px 24px;
    display: flex; align-items: center; gap: 10px;
    border-bottom: 1px solid #f3f4f6;
}
.section-header-icon {
    width: 38px; height: 38px;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
}
.section-header-title { font-weight: 700; color: #1e1b4b; font-size: 1rem; }
.section-body { padding: 24px; }

.prof-label { font-size: 0.78rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 7px; }
.prof-input {
    width: 100%; padding: 12px 16px; border: 1.5px solid #e5e7eb;
    border-radius: 12px; font-size: 0.92rem; color: #1e1b4b;
    background: #f9fafb; outline: none; transition: all 0.2s; margin-bottom: 18px;
}
.prof-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.prof-input.is-invalid { border-color: #ef4444; }

.btn-save {
    padding: 12px 28px; border: none; border-radius: 12px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-weight: 700; font-size: 0.92rem;
    cursor: pointer; transition: all 0.3s;
    box-shadow: 0 4px 15px rgba(99,102,241,0.3);
}
.btn-save:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(99,102,241,0.4); }
.btn-danger-outline {
    padding: 11px 24px; border: 1.5px solid #ef4444; border-radius: 12px;
    background: #fff; color: #ef4444; font-weight: 700; font-size: 0.88rem;
    cursor: pointer; transition: all 0.2s;
}
.btn-danger-outline:hover { background: #ef4444; color: #fff; }

.success-alert {
    background: #f0fdf4; border: 1px solid #86efac; border-radius: 12px;
    padding: 12px 16px; color: #16a34a; font-size: 0.88rem;
    display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
}
</style>
@endpush

@section('content')
<div class="profile-page">
<div class="container">
<div class="row justify-content-center">
<div class="col-xl-9 col-lg-10">

    @if(session('success'))
        <div class="success-alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Profile Hero -->
    <div class="profile-hero">
        <div class="avatar-wrap">
            @if($user->avatar)
                <img src="{{ Storage::url($user->avatar) }}" class="avatar-img" alt="{{ $user->name }}">
            @else
                <div class="avatar-placeholder">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
            @endif
            <label for="avatar-upload" class="avatar-edit-btn" title="ፎቶ ቀይር">
                <i class="fas fa-camera" style="color:#fff;font-size:0.75rem;"></i>
            </label>
        </div>
        <div class="profile-hero-info">
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-email">{{ $user->email }}</div>
            <div class="profile-since">
                <i class="fas fa-calendar-alt"></i>
                ከ {{ $user->created_at->format('M Y') }} ጀምሮ አባል
            </div>
        </div>
    </div>

    <!-- Hidden avatar upload form -->
    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" id="avatar-form">
        @csrf @method('PATCH')
        <input type="hidden" name="name" value="{{ $user->name }}">
        <input type="hidden" name="email" value="{{ $user->email }}">
        <input type="file" id="avatar-upload" name="avatar" accept="image/*" style="display:none;"
               onchange="document.getElementById('avatar-form').submit()">
    </form>

    <div class="row g-4">
        <!-- Profile Info -->
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-icon" style="background:#eef2ff;">
                        <i class="fas fa-user" style="color:#6366f1;"></i>
                    </div>
                    <div class="section-header-title">የግል መረጃ</div>
                </div>
                <div class="section-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf @method('PATCH')
                        <div class="prof-label">ሙሉ ስም</div>
                        <input type="text" name="name" class="prof-input @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name')<div style="color:#ef4444;font-size:0.8rem;margin-top:-14px;margin-bottom:14px;">{{ $message }}</div>@enderror

                        <div class="prof-label">ኢሜይል አድራሻ</div>
                        <input type="email" name="email" class="prof-input @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email) }}" required>
                        @error('email')<div style="color:#ef4444;font-size:0.8rem;margin-top:-14px;margin-bottom:14px;">{{ $message }}</div>@enderror

                        <div class="prof-label">የፕሮፋይል ፎቶ (አማራጭ)</div>
                        <input type="file" name="avatar" class="prof-input" accept="image/*" style="padding:8px 16px;">

                        <button type="submit" class="btn-save">
                            <i class="fas fa-save me-2"></i>ያስቀምጡ
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="section-card">
                <div class="section-header">
                    <div class="section-header-icon" style="background:#fff7ed;">
                        <i class="fas fa-lock" style="color:#f59e0b;"></i>
                    </div>
                    <div class="section-header-title">የይለፍ ቃል ቀይር</div>
                </div>
                <div class="section-body">
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf @method('PATCH')
                        <div class="prof-label">አሁን ያለው የይለፍ ቃል</div>
                        <input type="password" name="current_password" class="prof-input @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div style="color:#ef4444;font-size:0.8rem;margin-top:-14px;margin-bottom:14px;">{{ $message }}</div>@enderror

                        <div class="prof-label">አዲስ የይለፍ ቃል</div>
                        <input type="password" name="password" class="prof-input @error('password') is-invalid @enderror" required>
                        @error('password')<div style="color:#ef4444;font-size:0.8rem;margin-top:-14px;margin-bottom:14px;">{{ $message }}</div>@enderror

                        <div class="prof-label">አዲስ የይለፍ ቃል ያረጋግጡ</div>
                        <input type="password" name="password_confirmation" class="prof-input" required>

                        <button type="submit" class="btn-save" style="background:linear-gradient(135deg,#f59e0b,#f97316);box-shadow:0 4px 15px rgba(245,158,11,0.3);">
                            <i class="fas fa-key me-2"></i>ቀይር
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="section-card">
        <div class="section-header">
            <div class="section-header-icon" style="background:#fef2f2;">
                <i class="fas fa-exclamation-triangle" style="color:#ef4444;"></i>
            </div>
            <div class="section-header-title" style="color:#ef4444;">አደገኛ ዞን</div>
        </div>
        <div class="section-body">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <div style="font-weight:700;color:#1e1b4b;margin-bottom:4px;">መለያ ሰርዝ</div>
                    <div style="color:#9ca3af;font-size:0.85rem;">መለያዎን ከሰረዙ ሁሉም ውሂብዎ 영구적으로 ይጠፋል።</div>
                </div>
                <button type="button" class="btn-danger-outline" data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="fas fa-trash me-2"></i>መለያ ሰርዝ
                </button>
            </div>
        </div>
    </div>

</div>
</div>
</div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:20px;border:none;">
            <div class="modal-header" style="background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:20px 20px 0 0;">
                <h5 class="modal-title text-white"><i class="fas fa-trash me-2"></i>መለያ ሰርዝ</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf @method('DELETE')
                <div class="modal-body p-4">
                    <div style="background:#fef2f2;border-radius:12px;padding:14px;margin-bottom:18px;color:#dc2626;font-size:0.88rem;">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        ይህ ድርጊት ሊቀለበስ አይችልም። ሁሉም ውሂብዎ ይጠፋል።
                    </div>
                    <div class="prof-label">ለማረጋገጥ የይለፍ ቃልዎን ያስገቡ</div>
                    <input type="password" name="password" class="prof-input @error('password') is-invalid @enderror" required>
                    @error('password')<div style="color:#ef4444;font-size:0.8rem;">{{ $message }}</div>@enderror
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn-clear" data-bs-dismiss="modal" style="display:inline-block;width:auto;padding:10px 20px;">ሰርዝ</button>
                    <button type="submit" class="btn-danger-outline">
                        <i class="fas fa-trash me-2"></i>አዎ፣ ሰርዝ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
