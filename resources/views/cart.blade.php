@extends('layouts.app')
@section('title', 'የግዢ ጋሪ')

@push('styles')
<style>
.cart-page { background:#f8f7ff; min-height:100vh; padding:36px 0; }
.cart-card { background:#fff; border-radius:20px; box-shadow:0 4px 20px rgba(99,102,241,0.08); overflow:hidden; margin-bottom:20px; }
.cart-item { display:flex; align-items:center; gap:16px; padding:18px 22px; border-bottom:1px solid #f3f4f6; }
.cart-item:last-child { border-bottom:none; }
.cart-item-img { width:72px; height:72px; border-radius:12px; object-fit:cover; flex-shrink:0; }
.cart-item-placeholder { width:72px; height:72px; border-radius:12px; background:#eef2ff; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.qty-btn { width:32px; height:32px; border:1.5px solid #e5e7eb; border-radius:8px; background:#fff; cursor:pointer; font-weight:700; color:#6366f1; transition:all 0.2s; }
.qty-btn:hover { background:#6366f1; color:#fff; border-color:#6366f1; }
.qty-input { width:48px; text-align:center; border:1.5px solid #e5e7eb; border-radius:8px; padding:4px; font-weight:700; color:#1e1b4b; }
.btn-remove { background:#fef2f2; border:none; color:#dc2626; width:34px; height:34px; border-radius:8px; cursor:pointer; transition:all 0.2s; }
.btn-remove:hover { background:#dc2626; color:#fff; }
.summary-card { background:#fff; border-radius:20px; box-shadow:0 4px 20px rgba(99,102,241,0.08); padding:24px; position:sticky; top:20px; }
.summary-row { display:flex; justify-content:space-between; margin-bottom:12px; font-size:0.9rem; color:#6b7280; }
.summary-total { display:flex; justify-content:space-between; font-size:1.1rem; font-weight:800; color:#1e1b4b; margin-top:4px; }
.btn-checkout { width:100%; padding:14px; border:none; border-radius:12px; background:linear-gradient(135deg,#6366f1,#8b5cf6); color:#fff; font-weight:700; font-size:1rem; cursor:pointer; transition:all 0.3s; box-shadow:0 4px 15px rgba(99,102,241,0.3); text-decoration:none; display:block; text-align:center; }
.btn-checkout:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(99,102,241,0.4); color:#fff; }
.security-item { text-align:center; }
.security-item i { font-size:1.4rem; margin-bottom:6px; }
.security-item div { font-size:0.72rem; color:#6b7280; font-weight:600; }
</style>
@endpush

@section('content')
<div class="cart-page">
<div class="container">
    <h1 style="font-size:1.8rem;font-weight:800;color:#1e1b4b;margin-bottom:28px;">
        <i class="fas fa-shopping-cart me-2" style="color:#6366f1;"></i>የግዢ ጋሪ
    </h1>

    @if($cartItems->count() > 0)
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="cart-card">
                @foreach($cartItems as $item)
                <div class="cart-item" id="cart-item-{{ $item->id }}">
                    @if($item->product->images && count($item->product->images) > 0)
                        <img src="{{ Storage::url($item->product->images[0]) }}" class="cart-item-img" alt="{{ $item->product->name }}">
                    @else
                        <div class="cart-item-placeholder"><i class="fas fa-image" style="color:#a5b4fc;font-size:1.5rem;"></i></div>
                    @endif
                    <div style="flex:1;">
                        <div style="font-weight:700;color:#1e1b4b;margin-bottom:2px;">{{ $item->product->name }}</div>
                        <div style="font-size:0.78rem;color:#9ca3af;">{{ $item->product->category->name }} • {{ $item->product->brand->name }}</div>
                        <div style="color:#6366f1;font-weight:700;margin-top:4px;">Birr {{ number_format($item->unit_amount, 0, '.', ',') }}</div>
                    </div>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <button class="qty-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">−</button>
                        <input type="number" class="qty-input" value="{{ $item->quantity }}" min="1" id="qty-{{ $item->id }}" onchange="updateQuantity({{ $item->id }}, this.value)">
                        <button class="qty-btn" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                    </div>
                    <div style="font-weight:800;color:#1e1b4b;min-width:90px;text-align:right;" id="item-total-{{ $item->id }}">
                        Birr {{ number_format($item->total_amount, 0, '.', ',') }}
                    </div>
                    <button class="btn-remove" onclick="removeItem({{ $item->id }})"><i class="fas fa-trash"></i></button>
                </div>
                @endforeach
            </div>
            <div style="display:flex;gap:12px;flex-wrap:wrap;">
                <button onclick="clearCart()" style="padding:10px 20px;border:1.5px solid #fecaca;border-radius:10px;background:#fff;color:#dc2626;font-weight:600;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                    <i class="fas fa-trash me-2"></i>ጋሪ አጽዳ
                </button>
                <a href="{{ route('products') }}" style="padding:10px 20px;border:1.5px solid #e0e7ff;border-radius:10px;background:#fff;color:#6366f1;font-weight:600;text-decoration:none;transition:all 0.2s;">
                    <i class="fas fa-arrow-left me-2"></i>ግዢ ቀጥሉ
                </a>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="summary-card">
                <div style="font-weight:800;color:#1e1b4b;font-size:1.1rem;margin-bottom:20px;">የትዕዛዝ ማጠቃለያ</div>
                <div class="summary-row"><span>ድምር:</span><span id="cart-subtotal">Birr {{ number_format($total, 0, '.', ',') }}</span></div>
                <div class="summary-row"><span>የመላኪያ ዋጋ:</span><span>Birr 150</span></div>
                <hr style="border-color:#f3f4f6;">
                <div class="summary-total"><span>ጠቅላላ:</span><span id="cart-total" style="color:#6366f1;">Birr {{ number_format($total + 150, 0, '.', ',') }}</span></div>
                <div style="margin-top:20px;">
                    @auth
                        <a href="{{ route('checkout') }}" class="btn-checkout"><i class="fas fa-credit-card me-2"></i>ወደ ክፍያ ሂድ</a>
                    @else
                        <p style="text-align:center;color:#9ca3af;font-size:0.85rem;margin-bottom:12px;">ለመክፈል እባክዎ ይግቡ</p>
                        <a href="{{ route('login') }}" class="btn-checkout"><i class="fas fa-sign-in-alt me-2"></i>ይግቡ</a>
                        <div style="text-align:center;margin-top:10px;font-size:0.82rem;color:#9ca3af;">
                            መለያ የለዎትም? <a href="{{ route('register') }}" style="color:#6366f1;font-weight:600;">ይመዝገቡ</a>
                        </div>
                    @endauth
                </div>
                <div style="display:flex;justify-content:space-around;margin-top:20px;padding-top:16px;border-top:1px solid #f3f4f6;">
                    <div class="security-item"><i class="fas fa-shield-alt" style="color:#16a34a;"></i><div>ደህንነቱ የተጠበቀ</div></div>
                    <div class="security-item"><i class="fas fa-lock" style="color:#6366f1;"></i><div>ምስጠራ</div></div>
                    <div class="security-item"><i class="fas fa-credit-card" style="color:#f59e0b;"></i><div>ክፍያ</div></div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div style="text-align:center;padding:80px 20px;">
            <div style="width:90px;height:90px;background:#eef2ff;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
                <i class="fas fa-shopping-cart fa-2x" style="color:#6366f1;"></i>
            </div>
            <h3 style="font-weight:800;color:#1e1b4b;margin-bottom:8px;">ጋሪዎ ባዶ ነው</h3>
            <p style="color:#9ca3af;margin-bottom:24px;">እስካሁን ምንም ምርት አልጨመሩም።</p>
            <a href="{{ route('products') }}" style="padding:14px 32px;border:none;border-radius:50px;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;font-weight:700;text-decoration:none;box-shadow:0 4px 15px rgba(99,102,241,0.3);">
                <i class="fas fa-shopping-bag me-2"></i>ግዢ ይጀምሩ
            </a>
        </div>
    @endif
</div>
</div>

@push('scripts')
<script>
function updateQuantity(itemId, quantity) {
    if (quantity < 1) { removeItem(itemId); return; }
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        url: `/cart/${itemId}`, method: 'PUT', data: { quantity: quantity },
        success: function(r) {
            if (r.success) {
                $(`#qty-${itemId}`).val(quantity);
                $(`#item-total-${itemId}`).text('Birr ' + new Intl.NumberFormat('en').format(r.item_total));
                $('#cart-subtotal').text('Birr ' + new Intl.NumberFormat('en').format(r.cart_total));
                $('#cart-total').text('Birr ' + new Intl.NumberFormat('en').format(r.cart_total + 150));
            }
        },
        error: function() { showAlert('danger', 'ብዛቱን ማዘመን አልተሳካም'); }
    });
}
function removeItem(itemId) {
    if (!confirm('ምርቱን ከጋሪ ማስወጣት ይፈልጋሉ?')) return;
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        url: `/cart/${itemId}`, method: 'DELETE',
        success: function(r) {
            if (r.success) {
                $(`#cart-item-${itemId}`).remove();
                $('#cart-count').text(r.cart_count);
                $('#cart-subtotal').text('Birr ' + new Intl.NumberFormat('en').format(r.cart_total));
                $('#cart-total').text('Birr ' + new Intl.NumberFormat('en').format(r.cart_total + 150));
                if (r.cart_count === 0) location.reload();
            }
        },
        error: function() { showAlert('danger', 'ምርቱን ማስወጣት አልተሳካም'); }
    });
}
function clearCart() {
    if (!confirm('ጋሪውን ሙሉ ለሙሉ ማጽዳት ይፈልጋሉ?')) return;
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
    $.ajax({
        url: '/cart', method: 'DELETE',
        success: function(r) { if (r.success) location.reload(); },
        error: function() { showAlert('danger', 'ጋሪ ማጽዳት አልተሳካም'); }
    });
}
</script>
@endpush
@endsection
