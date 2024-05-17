@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header bg-primary text-white">Semua Pesanan</div>

                    <div class="card-body">
                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($orders->isEmpty())
                            <div class="alert alert-info" role="alert">
                                Tidak ada pesanan yang tersedia saat ini.
                            </div>
                        @else
                            <div class="row">
                                <ul class="list-group w-100">
                                    @foreach ($orders as $order)
                                        @if (Auth::user()->is_admin || $order->user_id == Auth::id())
                                            <li class="list-group-item">
                                                <div class="card mb-4 position-relative">
                                                    <div class="card-body">
                                                        <a href="{{ route('show_order', $order) }}" class="text-decoration-none">
                                                            <h5 class="card-title">Detail Order</h5>
                                                        </a>
                                                        <h6 class="card-subtitle mb-2 text-muted">Oleh: {{ $order->user->name }}</h6>
                                                        <p class="card-text">Checkout pada:
                                                            {{ $order->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</small>
                                                        </p>
                                                        @if ($order->is_paid && $order->estimated_delivery_time)
                                                            @php
                                                                $estimatedDeliveryTime = \Carbon\Carbon::parse(
                                                                    $order->estimated_delivery_time,
                                                                );
                                                            @endphp
                                                            <p>Waktu Pengiriman Estimasi:
                                                                {{ $estimatedDeliveryTime->isoFormat('dddd, D MMMM YYYY') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="card-footer bg-transparent border-0 position-absolute top-0 end-0 mt-2 me-2">
                                                        @if ($order->is_paid)
                                                            <span class="badge bg-warning text-dark">Bukti Pembayaran telah di konfirmasi</span>
                                                        @elseif ($order->is_rejected)
                                                            <span class="badge bg-danger">Pembayaran telah ditolak</span>
                                                        @else
                                                            @if ($order->payment_receipt)
                                                                <a href="{{ url('storage/' . $order->payment_receipt) }}" class="btn btn-info btn-sm">Lihat Bukti Pembayaran</a>
                                                            @else
                                                                <span class="badge bg-info">Pembeli belum mengirim bukti pembayaran</span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                        
                                                    @if (!$order->is_paid && $order->payment_receipt && Auth::user()->is_admin)
                                                        <div class="d-flex justify-content-start  bottom-0 start-0 mb-3 ms-3">
                                                            <form action="{{ route('confirm_payment', $order) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-warning me-2">Konfirmasi Pembayaran</button>
                                                            </form>
                                                            
                                                            <form action="{{ route('reject_payment', $order) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-danger">Tolak Pembayaran</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        {{$orders->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
