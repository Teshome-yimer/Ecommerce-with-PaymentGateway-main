@extends('layouts.app')

@section('title', 'የትዕዛዝ ዝርዝር')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2><i class="fas fa-receipt me-2"></i>ትዕዛዝ #{{ $order->id }}</h2>
                    <small class="text-muted"><i class="fas fa-calendar me-1"></i>የተደረገው {{ $order->created_at->format('d M Y, H:i') }}</small>
                </div>
                <a href="{{ route('orders.history') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>ወደ ትዕዛዞቼ
                </a>
            </div>

            <!-- Order Status -->
            <div class="card-clean mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-3">የትዕዛዝ ሁኔታ</h5>
                            <div class="d-flex gap-3 align-items-center">
                                <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'processing' ? 'warning' : ($order->status === 'canceled' ? 'danger' : 'primary')) }} fs-6">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }} fs-6">
                                    Payment {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex gap-2 justify-content-md-end flex-wrap">
                                @if($order->payment_status === 'paid')
                                    <a href="{{ route('invoice.download', $order) }}" class="btn btn-success"><i class="fas fa-download me-2"></i>ደረሰኝ አውርዱ</a>
                                    <a href="{{ route('invoice.preview', $order) }}" class="btn btn-outline-info"><i class="fas fa-eye me-2"></i>ደረሰኝ ይመልከቱ</a>
                                @endif

                                @if(in_array($order->status, ['new', 'processing']))
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-outline-danger" onclick="return confirm('ትዕዛዙን መሰረዝ ይፈልጋሉ?')"><i class="fas fa-times me-2"></i>ሰርዝ</button>
                                    </form>
                                @endif

                                @if($order->status === 'delivered')
                                    <form action="{{ route('orders.reorder', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-primary"><i class="fas fa-redo me-2"></i>እንደገና ዕዘዝ</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Order Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card-clean">
                        <div class="card-header"><h5 class="mb-0"><i class="fas fa-box me-2"></i>የታዘዙ ምርቶች</h5></div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 60%">ምርት</th>
                                            <th style="width: 15%" class="text-center">ብዛት</th>
                                            <th style="width: 25%" class="text-end">ዋጋ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($item->product && $item->product->images)
                                                        <img src="{{ Storage::url($item->product->images[0]) }}"
                                                             class="rounded me-3"
                                                             style="width: 60px; height: 60px; object-fit: cover;"
                                                             alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                             style="width: 60px; height: 60px;">
                                                            <i class="fas fa-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-1">{{ $item->product->name ?? 'ምርት ተሰርዟል' }}</h6>
                                                        @if($item->product)
                                                            <small class="text-muted">
                                                                {{ $item->product->category->name ?? '' }} • {{ $item->product->brand->name ?? '' }}
                                                            </small>
                                                        @endif
                                                        <div class="small text-muted">የአንድ ዋጋ: Birr {{ number_format($item->unit_amount, 0, '.', ',') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge bg-light text-dark">{{ $item->quantity }}</span>
                                            </td>
                                            <td class="text-end align-middle">
                                                <strong>Birr {{ number_format($item->total_amount, 2, '.', ',') }}</strong>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary & Info -->
                <div class="col-lg-4">
                    <!-- Order Summary -->
                    <div class="card-clean mb-4">
                        <div class="card-header"><h6 class="mb-0"><i class="fas fa-calculator me-2"></i>ማጠቃለያ</h6></div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2"><span>ድምር:</span><span>Birr {{ number_format($order->items->sum('total_amount'), 0, '.', ',') }}</span></div>
                            @if($order->shipping_amount)
                            <div class="d-flex justify-content-between mb-2"><span>የመላኪያ ዋጋ:</span><span>Birr {{ number_format($order->shipping_amount, 0, '.', ',') }}</span></div>
                            @endif
                            <hr>
                            <div class="d-flex justify-content-between"><strong>ጠቅላላ:</strong><strong class="text-primary">Birr {{ number_format($order->grand_total, 0, '.', ',') }}</strong></div>
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="card-clean mb-4">
                        <div class="card-header"><h6 class="mb-0"><i class="fas fa-credit-card me-2"></i>የክፍያ መረጃ</h6></div>
                        <div class="card-body">
                            <div class="mb-2"><small class="text-muted">የክፍያ ዘዴ:</small><div>{{ $order->payment_method ?? 'አልተገለጸም' }}</div></div>
                            <div class="mb-2"><small class="text-muted">የክፍያ ሁኔታ:</small>
                                <div><span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'pending' ? 'warning' : 'danger') }}">{{ $order->payment_status==='paid'?'ተከፍሏል':($order->payment_status==='pending'?'በመጠባበቅ':'አልተሳካም') }}</span></div>
                            </div>
                            @if($order->notes)<div><small class="text-muted">ማስታወሻ:</small><div class="small">{{ $order->notes }}</div></div>@endif
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    @if($order->address)
                    <div class="card-clean">
                        <div class="card-header"><h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>የመላኪያ አድራሻ</h6></div>
                        <div class="card-body">
                            <address class="mb-0">
                                <strong>{{ $order->address->first_name }} {{ $order->address->last_name }}</strong><br>
                                {{ $order->address->street_address }}<br>
                                {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->zip_code }}<br>
                                {{ $order->address->country }}<br>
                                <abbr title="Phone">P:</abbr> {{ $order->address->phone }}
                            </address>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Order Timeline (if needed) -->
            @if($order->status !== 'new')
            <div class="card-clean mt-4">
                <div class="card-header"><h6 class="mb-0"><i class="fas fa-history me-2"></i>የትዕዛዝ ታሪክ</h6></div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item"><div class="timeline-marker bg-success"></div><div class="timeline-content"><h6 class="timeline-title">ትዕዛዝ ተቀበለ</h6><p class="timeline-description">{{ $order->created_at->format('d M Y, H:i') }}</p></div></div>
                        @if($order->payment_status === 'paid')
                        <div class="timeline-item"><div class="timeline-marker bg-success"></div><div class="timeline-content"><h6 class="timeline-title">ክፍያ ተረጋገጠ</h6><p class="timeline-description">ክፍያ ተቀብሏል</p></div></div>
                        @endif
                        @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                        <div class="timeline-item"><div class="timeline-marker bg-warning"></div><div class="timeline-content"><h6 class="timeline-title">በሂደት ላይ</h6><p class="timeline-description">ትዕዛዝዎ እየተዘጋጀ ነው</p></div></div>
                        @endif
                        @if(in_array($order->status, ['shipped', 'delivered']))
                        <div class="timeline-item"><div class="timeline-marker bg-info"></div><div class="timeline-content"><h6 class="timeline-title">ተላከ</h6><p class="timeline-description">ትዕዛዝዎ በመምጣት ላይ ነው</p></div></div>
                        @endif
                        @if($order->status === 'delivered')
                        <div class="timeline-item"><div class="timeline-marker bg-success"></div><div class="timeline-content"><h6 class="timeline-title">ደረሰ</h6><p class="timeline-description">ትዕዛዝ በተሳካ ሁኔታ ደርሷል</p></div></div>
                        @endif
                        @if($order->status === 'canceled')
                        <div class="timeline-item"><div class="timeline-marker bg-danger"></div><div class="timeline-content"><h6 class="timeline-title">ተሰረዘ</h6><p class="timeline-description">ትዕዛዝ ተሰርዟል</p></div></div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
    }

    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 0;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .timeline-title {
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .timeline-description {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .d-flex.gap-2 {
            flex-direction: column;
        }
    }
</style>
@endpush
@endsection
