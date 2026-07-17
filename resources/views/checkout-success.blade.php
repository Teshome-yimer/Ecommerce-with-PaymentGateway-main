@extends('layouts.app')
@section('title', 'ትዕዛዝ ተቀበለ')

@push('styles')
<style>
.success-page { background:#f8f7ff; min-height:100vh; padding:40px 0; }
.success-card { background:#fff; border-radius:20px; box-shadow:0 4px 20px rgba(99,102,241,0.08); overflow:hidden; margin-bottom:20px; }
.success-header { padding:18px 22px; border-bottom:1px solid #f3f4f6; font-weight:700; color:#1e1b4b; font-size:1rem; }
.success-body { padding:22px; }
.info-row { display:flex; justify-content:space-between; padding:10px 0; border-bottom:1px solid #f9fafb; font-size:0.9rem; }
.info-row:last-child { border-bottom:none; }
.info-label { color:#6b7280; }
.info-value { font-weight:600; color:#1e1b4b; }
.item-row { display:flex; align-items:center; gap:14px; padding:14px 0; border-bottom:1px solid #f3f4f6; }
.item-row:last-child { border-bottom:none; }
.item-img { width:56px; height:56px; border-radius:10px; object-fit:cover; }
.item-placeholder { width:56px; height:56px; border-radius:10px; background:#eef2ff; display:flex; align-items:center; justify-content:center; }
.btn-action { padding:11px 20px; border-radius:12px; font-weight:700; font-size:0.88rem; text-decoration:none; transition:all 0.2s; display:inline-flex; align-items:center; gap:6px; }
.btn-primary-g { background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; border:none; box-shadow:0 4px 12px rgba(99,102,241,0.3); }
.btn-primary-g:hover { transform:translateY(-2px); color:#fff; }
.btn-outline-g { background:#fff; color:#6366f1; border:1.5px solid #6366f1; }
.btn-outline-g:hover { background:#6366f1; color:#fff; }
.btn-success-g { background:#16a34a; color:#fff; border:none; }
.btn-success-g:hover { background:#15803d; color:#fff; }
</style>
@endpush

@section('content')
<div class="success-page">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-8">

    <div style="text-align:center;margin-bottom:32px;">
        <div style="width:80px;height:80px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;">
            <i class="fas fa-check" style="color:#16a34a;font-size:2rem;"></i>
        </div>
        <h1 style="font-size:1.8rem;font-weight:800;color:#1e1b4b;margin-bottom:8px;">ትዕዛዝ ተቀበለ!</h1>
        <p style="color:#9ca3af;">ለግዢዎ እናመሰግናለን። ትዕዛዝዎ ተቀብሎ በሂደት ላይ ነው።</p>
    </div>

    <!-- Order Details -->
    <div class="success-card">
        <div class="success-header"><i class="fas fa-receipt me-2" style="color:#6366f1;"></i>የትዕዛዝ ዝርዝር</div>
        <div class="success-body">
            <div class="info-row"><span class="info-label">የትዕዛዝ ቁጥር:</span><span class="info-value">#{{ $order->id }}</span></div>
            <div class="info-row"><span class="info-label">የትዕዛዝ ቀን:</span><span class="info-value">{{ $order->created_at->format('d M Y H:i') }}</span></div>
            <div class="info-row">
                <span class="info-label">የክፍያ ሁኔታ:</span>
                <span class="info-value">
                    <span style="background:{{ $order->payment_status==='paid'?'#dcfce7':'#fff7ed' }};color:{{ $order->payment_status==='paid'?'#15803d':'#f59e0b' }};padding:3px 10px;border-radius:20px;font-size:0.78rem;">
                        {{ $order->payment_status==='paid'?'ተከፍሏል':'በመጠባበቅ' }}
                    </span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">የትዕዛዝ ሁኔታ:</span>
                <span class="info-value">
                    <span style="background:#eef2ff;color:#6366f1;padding:3px 10px;border-radius:20px;font-size:0.78rem;">አዲስ</span>
                </span>
            </div>
            <div class="info-row"><span class="info-label">ጠቅላላ ዋጋ:</span><span class="info-value" style="color:#6366f1;font-size:1.1rem;">Birr {{ number_format($order->grand_total, 0) }}</span></div>
        </div>
    </div>

    <!-- Items -->
    <div class="success-card">
        <div class="success-header"><i class="fas fa-box me-2" style="color:#6366f1;"></i>የታዘዙ ምርቶች</div>
        <div class="success-body">
            @foreach($order->items as $item)
            <div class="item-row">
                @if($item->product->images && count($item->product->images) > 0)
                    <img src="{{ $item->product->first_image }}" class="item-img" alt="{{ $item->product->name }}">
                @else
                    <div class="item-placeholder"><i class="fas fa-image" style="color:#a5b4fc;"></i></div>
                @endif
                <div style="flex:1;">
                    <div style="font-weight:700;color:#1e1b4b;font-size:0.9rem;">{{ $item->product->name }}</div>
                    <div style="font-size:0.75rem;color:#9ca3af;">{{ $item->product->category->name }} • {{ $item->product->brand->name }}</div>
                </div>
                <div style="text-align:center;color:#6b7280;font-size:0.85rem;">ብዛት: {{ $item->quantity }}</div>
                <div style="font-weight:700;color:#6366f1;">Birr {{ number_format($item->total_amount, 0) }}</div>
            </div>
            @endforeach

            <div style="margin-top:16px;padding-top:16px;border-top:1px solid #f3f4f6;">
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.88rem;color:#6b7280;">
                    <span>ድምር:</span><span>Birr {{ number_format($order->grand_total - $order->shipping_amount, 0) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;font-size:0.88rem;color:#6b7280;">
                    <span>የመላኪያ ዋጋ:</span><span>Birr {{ number_format($order->shipping_amount, 0) }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-weight:800;color:#1e1b4b;font-size:1rem;padding-top:8px;border-top:1px solid #f3f4f6;">
                    <span>ጠቅላላ:</span><span style="color:#6366f1;">Birr {{ number_format($order->grand_total, 0) }}</span>
                </div>
            </div>
        </div>
    </div>

    @if($order->address)
    <div class="success-card">
        <div class="success-header"><i class="fas fa-map-marker-alt me-2" style="color:#6366f1;"></i>የመላኪያ አድራሻ</div>
        <div class="success-body">
            <strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong><br>
            {{ $order->address->street_address }}<br>
            {{ $order->address->city }}, {{ $order->address->state }}<br>
            {{ $order->address->country }}<br>
            <i class="fas fa-phone me-1" style="color:#6366f1;"></i>{{ $order->address->phone }}
        </div>
    </div>
    @endif

    <!-- Next steps -->
    <div style="background:#eef2ff;border-radius:16px;padding:20px 22px;margin-bottom:24px;">
        <div style="font-weight:700;color:#1e1b4b;margin-bottom:12px;"><i class="fas fa-info-circle me-2" style="color:#6366f1;"></i>ቀጣይ እርምጃዎች</div>
        <ul style="color:#6b7280;font-size:0.88rem;margin:0;padding-left:20px;line-height:2;">
            <li>የኢሜይል ማረጋገጫ ይደርስዎታል</li>
            <li>ትዕዛዝዎ ሲላክ እናሳውቅዎታለን</li>
            <li>የትዕዛዝ ሁኔታ በመለያዎ ይከታተሉ</li>
            <li>ጥያቄ ካለዎት ያግኙን</li>
        </ul>
    </div>

    <div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
        <a href="{{ route('invoice.download', $order) }}" class="btn-action btn-success-g"><i class="fas fa-download"></i>ደረሰኝ አውርዱ</a>
        <a href="{{ route('invoice.preview', $order) }}" class="btn-action btn-outline-g"><i class="fas fa-eye"></i>ደረሰኝ ይመልከቱ</a>
        <a href="{{ route('home') }}" class="btn-action btn-primary-g"><i class="fas fa-home"></i>ወደ ቤት</a>
        <a href="{{ route('orders.history') }}" class="btn-action btn-outline-g"><i class="fas fa-list"></i>ትዕዛዞቼ</a>
    </div>

</div>
</div>
</div>
</div>
@endsection
