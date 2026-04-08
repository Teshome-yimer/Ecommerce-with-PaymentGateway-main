@extends('layouts.app')
@section('title', 'ትዕዛዞቼ')

@push('styles')
<style>
.orders-page { background: #f8f7ff; min-height: 100vh; padding: 36px 0; }

.page-header {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 28px; flex-wrap: wrap; gap: 12px;
}
.page-title { font-size: 1.8rem; font-weight: 800; color: #1e1b4b; margin: 0; }

.filter-card {
    background: #fff; border-radius: 20px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.07);
    padding: 22px 24px; margin-bottom: 28px;
}
.filter-input {
    width: 100%; padding: 10px 14px; border: 1.5px solid #e5e7eb;
    border-radius: 10px; font-size: 0.88rem; color: #1e1b4b;
    background: #f9fafb; outline: none; transition: all 0.2s;
}
.filter-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.1); }
.filter-label { font-size: 0.75rem; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 6px; }
.btn-filter {
    width: 100%; padding: 11px; border: none; border-radius: 10px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-weight: 700; cursor: pointer; transition: all 0.3s;
}
.btn-filter:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(99,102,241,0.35); }

/* Order card */
.order-card {
    background: #fff; border-radius: 20px;
    box-shadow: 0 4px 20px rgba(99,102,241,0.07);
    border: 2px solid transparent;
    transition: all 0.3s; margin-bottom: 20px; overflow: hidden;
}
.order-card:hover { border-color: #6366f1; box-shadow: 0 12px 35px rgba(99,102,241,0.14); }
.order-card-header {
    padding: 18px 22px; border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
}
.order-id { font-weight: 800; color: #1e1b4b; font-size: 1rem; }
.order-date { font-size: 0.78rem; color: #9ca3af; margin-top: 2px; }
.order-card-body { padding: 18px 22px; }
.order-card-footer {
    padding: 14px 22px; background: #f9fafb;
    border-top: 1px solid #f3f4f6;
    display: flex; gap: 10px; flex-wrap: wrap; align-items: center;
}

/* Status badges */
.status-badge {
    font-size: 0.72rem; font-weight: 700; padding: 5px 12px; border-radius: 20px;
}

/* Product thumb */
.product-thumb {
    display: flex; align-items: center; gap: 10px;
    background: #f8f7ff; border-radius: 12px; padding: 10px 12px;
}
.product-thumb img { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; }
.product-thumb-placeholder {
    width: 44px; height: 44px; border-radius: 8px;
    background: #e0e7ff; display: flex; align-items: center; justify-content: center;
}

/* Action buttons */
.btn-action {
    padding: 8px 16px; border-radius: 10px; font-size: 0.8rem; font-weight: 600;
    text-decoration: none; cursor: pointer; transition: all 0.2s; border: none;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-view { background: #eef2ff; color: #6366f1; }
.btn-view:hover { background: #6366f1; color: #fff; }
.btn-invoice { background: #f0fdf4; color: #16a34a; }
.btn-invoice:hover { background: #16a34a; color: #fff; }
.btn-cancel { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.btn-cancel:hover { background: #dc2626; color: #fff; }
.btn-reorder { background: #fff7ed; color: #f59e0b; }
.btn-reorder:hover { background: #f59e0b; color: #fff; }
.btn-shop {
    padding: 12px 28px; border: none; border-radius: 50px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: #fff; font-weight: 700; text-decoration: none;
    box-shadow: 0 4px 15px rgba(99,102,241,0.3); transition: all 0.3s;
}
.btn-shop:hover { transform: translateY(-2px); color: #fff; box-shadow: 0 8px 20px rgba(99,102,241,0.4); }

.empty-state { text-align: center; padding: 80px 20px; }
.empty-icon { width: 90px; height: 90px; background: #eef2ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; }
</style>
@endpush

@section('content')
<div class="orders-page">
<div class="container">

    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-history me-2" style="color:#6366f1;font-size:1.5rem;"></i>ትዕዛዞቼ</h1>
        <a href="{{ route('products') }}" class="btn-shop">
            <i class="fas fa-shopping-bag me-2"></i>ግዢ ቀጥሉ
        </a>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <form method="GET" action="{{ route('orders.history') }}">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <div class="filter-label">ፈልግ</div>
                    <input type="text" name="search" class="filter-input" placeholder="የትዕዛዝ ቁጥር ወይም ምርት..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <div class="filter-label">ሁኔታ</div>
                    <select name="status" class="filter-input">
                        <option value="">ሁሉም</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="filter-label">ክፍያ</div>
                    <select name="payment_status" class="filter-input">
                        <option value="">ሁሉም</option>
                        @foreach($paymentStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('payment_status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <div class="filter-label">ከ</div>
                    <input type="date" name="date_from" class="filter-input" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <div class="filter-label">እስከ</div>
                    <input type="date" name="date_to" class="filter-input" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn-filter"><i class="fas fa-search"></i></button>
                </div>
            </div>
            @if(request()->hasAny(['search','status','payment_status','date_from','date_to']))
                <div class="mt-3">
                    <a href="{{ route('orders.history') }}" style="font-size:0.82rem;color:#6366f1;font-weight:600;text-decoration:none;">
                        <i class="fas fa-times me-1"></i>ማጣሪያ አጽዳ
                    </a>
                </div>
            @endif
        </form>
    </div>

    @if($orders->count() > 0)
        @php
        $statusMap = [
            'new'        => ['አዲስ',    '#eef2ff','#6366f1'],
            'processing' => ['በሂደት',   '#fff7ed','#f59e0b'],
            'shipped'    => ['ተላከ',    '#f0f9ff','#0284c7'],
            'delivered'  => ['ደረሰ',    '#dcfce7','#15803d'],
            'canceled'   => ['ተሰረዘ',   '#fef2f2','#dc2626'],
        ];
        $payMap = [
            'paid'    => ['ተከፍሏል', '#dcfce7','#15803d'],
            'pending' => ['በመጠባበቅ','#fff7ed','#f59e0b'],
            'failed'  => ['አልተሳካም','#fef2f2','#dc2626'],
        ];
        @endphp

        @foreach($orders as $order)
        @php
            $s = $statusMap[$order->status] ?? ['ያልታወቀ','#f3f4f6','#6b7280'];
            $p = $payMap[$order->payment_status] ?? ['ያልታወቀ','#f3f4f6','#6b7280'];
        @endphp
        <div class="order-card">
            <div class="order-card-header">
                <div>
                    <div class="order-id"><i class="fas fa-receipt me-2" style="color:#6366f1;"></i>ትዕዛዝ #{{ $order->id }}</div>
                    <div class="order-date"><i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="status-badge" style="background:{{ $s[1] }};color:{{ $s[2] }};">{{ $s[0] }}</span>
                    <span class="status-badge" style="background:{{ $p[1] }};color:{{ $p[2] }};">{{ $p[0] }}</span>
                </div>
            </div>

            <div class="order-card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($order->items->take(3) as $item)
                            <div class="product-thumb">
                                @if($item->product && $item->product->images)
                                    <img src="{{ Storage::url($item->product->images[0]) }}" alt="{{ $item->product->name }}">
                                @else
                                    <div class="product-thumb-placeholder"><i class="fas fa-image" style="color:#a5b4fc;"></i></div>
                                @endif
                                <div>
                                    <div style="font-weight:700;font-size:0.82rem;color:#1e1b4b;">{{ Str::limit($item->product->name ?? 'ምርት ተሰርዟል', 20) }}</div>
                                    <div style="font-size:0.72rem;color:#9ca3af;">ብዛት: {{ $item->quantity }}</div>
                                </div>
                            </div>
                            @endforeach
                            @if($order->items->count() > 3)
                                <div style="display:flex;align-items:center;font-size:0.78rem;color:#9ca3af;font-weight:600;">
                                    +{{ $order->items->count() - 3 }} ተጨማሪ
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <div style="font-size:1.3rem;font-weight:800;color:#6366f1;">
                            Birr {{ number_format($order->grand_total, 0, '.', ',') }}
                        </div>
                        <div style="font-size:0.78rem;color:#9ca3af;">{{ $order->items->sum('quantity') }} ምርቶች</div>
                    </div>
                </div>
            </div>

            <div class="order-card-footer">
                <a href="{{ route('orders.detail', $order) }}" class="btn-action btn-view">
                    <i class="fas fa-eye"></i> ዝርዝር
                </a>
                @if($order->payment_status === 'paid')
                    <a href="{{ route('invoice.download', $order) }}" class="btn-action btn-invoice">
                        <i class="fas fa-download"></i> ደረሰኝ
                    </a>
                @endif
                @if(in_array($order->status, ['new','processing']))
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-action btn-cancel"
                                onclick="return confirm('ትዕዛዙን መሰረዝ ይፈልጋሉ?')">
                            <i class="fas fa-times"></i> ሰርዝ
                        </button>
                    </form>
                @endif
                @if($order->status === 'delivered')
                    <form action="{{ route('orders.reorder', $order) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn-action btn-reorder">
                            <i class="fas fa-redo"></i> እንደገና ዕዘዝ
                        </button>
                    </form>
                @endif
            </div>
        </div>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>

    @else
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-shopping-bag fa-2x" style="color:#6366f1;"></i>
            </div>
            <h4 style="font-weight:800;color:#1e1b4b;margin-bottom:8px;">ምንም ትዕዛዝ አልተገኘም</h4>
            <p style="color:#9ca3af;margin-bottom:24px;">
                @if(request()->hasAny(['search','status','payment_status','date_from','date_to']))
                    ማጣሪያዎን ቀይረው እንደገና ይሞክሩ።
                @else
                    እስካሁን ምንም ትዕዛዝ አላስቀመጡም። ግዢ ይጀምሩ!
                @endif
            </p>
            <a href="{{ route('products') }}" class="btn-shop">
                <i class="fas fa-shopping-bag me-2"></i>ግዢ ይጀምሩ
            </a>
        </div>
    @endif

</div>
</div>
@endsection
