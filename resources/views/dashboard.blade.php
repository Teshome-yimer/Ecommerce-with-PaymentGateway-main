@extends('layouts.app')
@section('title', 'ዳሽቦርድ')

@push('styles')
<style>
.dash-page { background: #f8f7ff; min-height: 100vh; padding: 36px 0; }

/* Hero welcome */
.dash-hero {
    background: linear-gradient(135deg, #1e1b4b, #4c1d95);
    border-radius: 24px;
    padding: 32px 36px;
    display: flex;
    align-items: center;
    gap: 24px;
    margin-bottom: 28px;
    position: relative;
    overflow: hidden;
}
.dash-hero::before {
    content: '';
    position: absolute;
    width: 280px; height: 280px;
    background: rgba(99,102,241,0.2);
    border-radius: 50%;
    top: -80px; right: -60px;
}
.dash-avatar {
    width: 80px; height: 80px; border-radius: 50%;
    border: 3px solid rgba(255,255,255,0.3);
    object-fit: cover; flex-shrink: 0;
}
.dash-avatar-placeholder {
    width: 80px; height: 80px; border-radius: 50%;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    display: flex; align-items: center; justify-content: center;
    font-size: 2rem; font-weight: 800; color: #fff;
    border: 3px solid rgba(255,255,255,0.3); flex-shrink: 0;
}
.dash-welcome { position: relative; z-index: 1; }
.dash-welcome-title { font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 4px; }
.dash-welcome-sub { color: rgba(255,255,255,0.7); font-size: 0.9rem; }

/* Stat cards */
.stat-card {
    background: #fff;
    border-radius: 18px;
    padding: 22px 20px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.08);
    display: flex; align-items: center; gap: 16px;
    transition: all 0.3s;
    border: 2px solid transparent;
}
.stat-card:hover { transform: translateY(-4px); border-color: #6366f1; box-shadow: 0 12px 30px rgba(99,102,241,0.15); }
.stat-icon {
    width: 52px; height: 52px; border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.3rem; flex-shrink: 0;
}
.stat-num { font-size: 1.5rem; font-weight: 800; color: #1e1b4b; line-height: 1; }
.stat-label { font-size: 0.78rem; color: #9ca3af; font-weight: 600; margin-top: 3px; }

/* Section card */
.dash-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.07);
    overflow: hidden;
    margin-bottom: 24px;
}
.dash-card-header {
    padding: 16px 22px;
    border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; justify-content: space-between;
}
.dash-card-title { font-weight: 700; color: #1e1b4b; font-size: 0.95rem; display: flex; align-items: center; gap: 8px; }
.dash-card-body { padding: 20px 22px; }

/* Action buttons */
.action-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 13px 16px; border-radius: 12px;
    border: 1.5px solid #e5e7eb; background: #fff;
    color: #1e1b4b; font-weight: 600; font-size: 0.88rem;
    text-decoration: none; transition: all 0.2s; margin-bottom: 10px;
}
.action-btn:hover { border-color: #6366f1; color: #6366f1; background: #f5f3ff; transform: translateX(4px); }
.action-btn-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; flex-shrink: 0; }

/* Order row */
.order-row {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 0; border-bottom: 1px solid #f3f4f6;
}
.order-row:last-child { border-bottom: none; }
.order-status-badge {
    font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 20px;
}
.quick-action-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.quick-card {
    background: #fff; border-radius: 16px; padding: 22px 16px; text-align: center;
    box-shadow: 0 4px 16px rgba(99,102,241,0.07); border: 2px solid transparent;
    transition: all 0.3s; text-decoration: none;
}
.quick-card:hover { border-color: #6366f1; transform: translateY(-4px); box-shadow: 0 12px 28px rgba(99,102,241,0.15); }
.quick-card-icon { width: 56px; height: 56px; border-radius: 16px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; font-size: 1.4rem; }
.quick-card-title { font-weight: 700; color: #1e1b4b; font-size: 0.9rem; margin-bottom: 4px; }
.quick-card-sub { font-size: 0.75rem; color: #9ca3af; }
</style>
@endpush

@section('content')
<div class="dash-page">
<div class="container">

    @if(session('status'))
        <div style="background:#f0fdf4;border:1px solid #86efac;border-radius:12px;padding:12px 18px;color:#16a34a;margin-bottom:20px;font-size:0.88rem;">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
        </div>
    @endif

    <!-- Welcome Hero -->
    <div class="dash-hero">
        @if(Auth::user()->avatar)
            <img src="{{ Storage::url(Auth::user()->avatar) }}" class="dash-avatar" alt="">
        @else
            <div class="dash-avatar-placeholder">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
        @endif
        <div class="dash-welcome">
            <div class="dash-welcome-title">እንኳን ደህና መጡ, {{ Auth::user()->name }}! 👋</div>
            <div class="dash-welcome-sub">ወደ ተሸሾፕ ዳሽቦርድ — ትዕዛዞችዎን ያስተዳድሩ</div>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#eef2ff;"><i class="fas fa-shopping-bag" style="color:#6366f1;"></i></div>
                <div>
                    <div class="stat-num">{{ $totalOrders ?? 0 }}</div>
                    <div class="stat-label">ጠቅላላ ትዕዛዞች</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#f0fdf4;"><i class="fas fa-check-circle" style="color:#16a34a;"></i></div>
                <div>
                    <div class="stat-num">{{ isset($recentOrders) ? $recentOrders->where('status','delivered')->count() : 0 }}</div>
                    <div class="stat-label">የተደረሱ</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fff7ed;"><i class="fas fa-coins" style="color:#f59e0b;"></i></div>
                <div>
                    <div class="stat-num" style="font-size:1.1rem;">{{ number_format($totalSpent ?? 0, 0, '.', ',') }}</div>
                    <div class="stat-label">ጠቅላላ ወጪ (Birr)</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="stat-card">
                <div class="stat-icon" style="background:#fdf4ff;"><i class="fas fa-calendar-alt" style="color:#9333ea;"></i></div>
                <div>
                    <div class="stat-num" style="font-size:1rem;">{{ Auth::user()->created_at->format('M Y') }}</div>
                    <div class="stat-label">አባልነት ጀምሮ</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left: Quick actions + Recent orders -->
        <div class="col-lg-8">

            <!-- Quick action cards -->
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-title"><i class="fas fa-bolt" style="color:#f59e0b;"></i> ፈጣን አማራጮች</div>
                </div>
                <div class="dash-card-body">
                    <div class="quick-action-grid">
                        <a href="{{ route('products') }}" class="quick-card">
                            <div class="quick-card-icon" style="background:#eef2ff;"><i class="fas fa-store" style="color:#6366f1;font-size:1.3rem;"></i></div>
                            <div class="quick-card-title">ምርቶች ይመልከቱ</div>
                            <div class="quick-card-sub">ሁሉንም ምርቶች ያስሱ</div>
                        </a>
                        <a href="{{ route('cart') }}" class="quick-card">
                            <div class="quick-card-icon" style="background:#f0fdf4;"><i class="fas fa-shopping-cart" style="color:#16a34a;font-size:1.3rem;"></i></div>
                            <div class="quick-card-title">ጋሪ ይመልከቱ</div>
                            <div class="quick-card-sub">የግዢ ዝርዝርዎን ይፈትሹ</div>
                        </a>
                        <a href="{{ route('orders.history') }}" class="quick-card">
                            <div class="quick-card-icon" style="background:#fff7ed;"><i class="fas fa-list-alt" style="color:#f59e0b;font-size:1.3rem;"></i></div>
                            <div class="quick-card-title">ትዕዛዞቼ</div>
                            <div class="quick-card-sub">የትዕዛዝ ታሪክዎን ይመልከቱ</div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="quick-card">
                            <div class="quick-card-icon" style="background:#fdf4ff;"><i class="fas fa-user-cog" style="color:#9333ea;font-size:1.3rem;"></i></div>
                            <div class="quick-card-title">የእኔ መለያ</div>
                            <div class="quick-card-sub">መረጃዎን ያዘምኑ</div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Orders -->
            @if(isset($recentOrders) && $recentOrders->count() > 0)
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-title"><i class="fas fa-clock" style="color:#6366f1;"></i> የቅርብ ጊዜ ትዕዛዞች</div>
                    <a href="{{ route('orders.history') }}" style="font-size:0.82rem;color:#6366f1;font-weight:600;text-decoration:none;">ሁሉንም ይመልከቱ →</a>
                </div>
                <div class="dash-card-body" style="padding-top:8px;padding-bottom:8px;">
                    @foreach($recentOrders->take(5) as $order)
                    @php
                        $statusMap = ['new'=>[' አዲስ','#eef2ff','#6366f1'],'processing'=>['በሂደት','#fff7ed','#f59e0b'],'shipped'=>['ተላከ','#f0fdf4','#16a34a'],'delivered'=>['ደረሰ','#dcfce7','#15803d'],'canceled'=>['ተሰረዘ','#fef2f2','#dc2626']];
                        $s = $statusMap[$order->status] ?? ['ያልታወቀ','#f3f4f6','#6b7280'];
                    @endphp
                    <div class="order-row">
                        <div style="flex-shrink:0;">
                            <span class="order-status-badge" style="background:{{ $s[1] }};color:{{ $s[2] }};">{{ $s[0] }}</span>
                        </div>
                        <div style="flex:1;">
                            <div style="font-weight:700;color:#1e1b4b;font-size:0.88rem;">#{{ $order->id }}</div>
                            <div style="font-size:0.75rem;color:#9ca3af;">{{ $order->created_at->format('d M Y') }}</div>
                        </div>
                        <div style="text-align:right;">
                            <div style="font-weight:700;color:#6366f1;font-size:0.9rem;">Birr {{ number_format($order->grand_total, 0, '.', ',') }}</div>
                            <a href="{{ route('orders.detail', $order) }}" style="font-size:0.75rem;color:#6366f1;text-decoration:none;font-weight:600;">ዝርዝር →</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right: Account info -->
        <div class="col-lg-4">
            <div class="dash-card">
                <div class="dash-card-header">
                    <div class="dash-card-title"><i class="fas fa-id-card" style="color:#6366f1;"></i> የመለያ መረጃ</div>
                </div>
                <div class="dash-card-body">
                    <div style="text-align:center;margin-bottom:20px;">
                        @if(Auth::user()->avatar)
                            <img src="{{ Storage::url(Auth::user()->avatar) }}" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #6366f1;" alt="">
                        @else
                            <div style="width:72px;height:72px;border-radius:50%;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:800;color:#fff;margin:0 auto;border:3px solid #e0e7ff;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="font-weight:700;color:#1e1b4b;margin-top:10px;">{{ Auth::user()->name }}</div>
                        <div style="font-size:0.82rem;color:#9ca3af;">{{ Auth::user()->email }}</div>
                    </div>

                    <div style="background:#f8f7ff;border-radius:12px;padding:14px;">
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                            <span style="font-size:0.8rem;color:#6b7280;">ጠቅላላ ትዕዛዞች</span>
                            <span style="font-weight:700;color:#6366f1;">{{ $totalOrders ?? 0 }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                            <span style="font-size:0.8rem;color:#6b7280;">ጠቅላላ ወጪ</span>
                            <span style="font-weight:700;color:#16a34a;">Birr {{ number_format($totalSpent ?? 0, 0, '.', ',') }}</span>
                        </div>
                        <div style="display:flex;justify-content:space-between;">
                            <span style="font-size:0.8rem;color:#6b7280;">አባልነት ጀምሮ</span>
                            <span style="font-weight:700;color:#1e1b4b;">{{ Auth::user()->created_at->format('M Y') }}</span>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" style="display:block;text-align:center;margin-top:16px;padding:11px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;font-size:0.88rem;text-decoration:none;">
                        <i class="fas fa-user-cog me-2"></i>መለያ አስተዳድር
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
@endsection
