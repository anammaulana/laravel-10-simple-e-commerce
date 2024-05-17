@extends('layouts.index')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="bg-white shadow-xl rounded-lg p-6">
                    <div class="bg-blue-600 text-white p-4 rounded-t-lg font-bold text-xl">Semua Pesanan</div>

                    <div class="p-4">
                        @if (session('message'))
                            <div class="bg-green-500 text-white font-semibold p-3 rounded-lg shadow-md" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($orders->isEmpty())
                            <div class="bg-blue-100 text-blue-800 p-4 rounded-lg font-semibold shadow-md" role="alert">
                                Tidak ada pesanan yang tersedia saat ini.
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($orders as $order)
                                    @if (Auth::user()->is_admin || $order->user_id == Auth::id())
                                        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                            <div class="px-4 py-5 sm:px-6">
                                                <a href="{{ route('show_order', $order) }}" class="text-blue-600 hover:text-blue-900">
                                                    <h3 class="text-lg leading-6 font-medium">Detail Order</h3>
                                                </a>
                                                <p class="mt-1 max-w-2xl text-sm text-gray-500">Oleh: {{ $order->user->name }}</p>
                                            </div>
                                            <div class="border-t border-gray-200">
                                                <dl>
                                                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                        <dt class="text-sm font-medium text-gray-500">Checkout pada:</dt>
                                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                            {{ $order->created_at->isoFormat('dddd, D MMMM YYYY') }}
                                                            <span class="text-gray-400">{{ \Carbon\Carbon::parse($order->created_at)->diffForHumans() }}</span>
                                                        </dd>
                                                    </div>
                                                    @if ($order->is_paid && $order->estimated_delivery_time)
                                                        @php
                                                            $estimatedDeliveryTime = \Carbon\Carbon::parse($order->estimated_delivery_time);
                                                        @endphp
                                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                            <dt class="text-sm font-medium text-gray-500">Waktu Pengiriman Estimasi:</dt>
                                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                                {{ $estimatedDeliveryTime->isoFormat('dddd, D MMMM YYYY') }}
                                                            </dd>
                                                        </div>
                                                    @endif
                                                </dl>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse">
                                                @if ($order->is_paid)
                                                    <span class="inline-flex rounded-md shadow-sm">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-500 text-white shadow-md">Bukti Pembayaran telah di konfirmasi</span>
                                                    </span>
                                                @elseif ($order->is_rejected)
                                                    <span class="inline-flex rounded-md shadow-sm">
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-500 text-white shadow-md">Pembayaran telah ditolak</span>
                                                    </span>
                                                @else
                                                    @if ($order->payment_receipt)
                                                        <a href="{{ url('storage/' . $order->payment_receipt) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-500 hover:bg-blue-400 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition duration-150 ease-in-out shadow-md">
                                                            Lihat Bukti Pembayaran
                                                        </a>
                                                    @else
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 shadow-md">Pembeli belum mengirim bukti pembayaran</span>
                                                    @endif
                                                @endif
                                            </div>
                                            @if (!$order->is_paid && $order->payment_receipt && Auth::user()->is_admin)
                                                <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                                    <form action="{{ route('confirm_payment', $order) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-yellow-500 hover:bg-yellow-400 focus:outline-none focus:border-yellow-700 focus:shadow-outline-yellow active:bg-yellow-700 transition duration-150 ease-in-out shadow-md">
                                                            Konfirmasi Pembayaran
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('reject_payment', $order) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="ml-3 inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-500 hover:bg-red-400 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-700 transition duration-150 ease-in-out shadow-md">
                                                            Tolak Pembayaran
                                                        </button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        <div class="mt-4">
                            {{$orders->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

