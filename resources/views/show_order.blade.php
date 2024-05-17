 @extends('layouts.index')

@section('content')
    <div class="container mx-auto p-6">
        <div class="flex justify-center">
            <div class="w-full max-w-4xl">
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="bg-blue-600 text-white p-4 rounded-t-lg font-bold text-xl">Detail Order</div>

                    <div class="p-4">
                        @if ($errors->any())
                            <div class="bg-red-500 text-white font-semibold p-3 rounded-lg" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @php
                            $total_price = 0;
                        @endphp

                        <div class="space-y-4">
                            <div class="font-semibold">User: <span class="font-normal">{{ $order->user->name }}</span></div>
                            <div class="font-semibold">No telepon: <span class="font-normal">{{ $order->user->no_telepon }}</span></div>
                            <div class="font-semibold">Alamat: <span class="font-normal">{{ $order->user->address }}</span></div>
                            <div class="font-semibold">Transaksi:
                                <div class="space-y-2 mt-2">
                                    @foreach ($order->transactions as $trans)
                                        <div class="p-3 bg-gray-100 rounded-lg">
                                            <p>Produk: <span class="font-bold">{{ $trans->product->name }}</span></p>
                                            <p>Ukuran: <span class="font-bold">{{$trans->product->size}}</span></p>
                                            <p>Warna: <span class="font-bold">{{$trans->product->color}}</span></p>
                                            <p>Jumlah: <span class="font-bold">{{ $trans->amount }} pcs</span></p>
                                            <p>Harga: Rp. <span class="font-bold">{{ number_format($trans->product->price * $trans->amount, 0, ',', '.') }}</span></p>
                                        </div>
                                        @php
                                            $total_price += $trans->product->price * $trans->amount;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                            <div class="pt-4">
                                <p class="text-lg font-bold">Total: Rp. <span class="text-green-500">{{ number_format($total_price, 0, ',', '.') }}</span></p>
                            </div>
                            @if (!$order->is_paid && !$order->is_rejected && !$order->payment_receipt && !Auth::user()->is_admin)
                                <div class="mt-4">
                                    <form id="uploadForm" action="{{ route('submit_payment_receipt', $order) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label for="submit_payment_receipt" class="block text-sm font-semibold mb-2">Upload Bukti Pembayaran:</label>
                                        <input type="file" name="payment_receipt" id="submit_payment_receipt" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-50 file:text-blue-700
                                        hover:file:bg-blue-100
                                        ">
                                        <button type="submit" class="mt-3 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Upload Bukti Pembayaran</button>
                                    </form>
                                </div>
                            @elseif ($order->is_paid)
                                <div class="mt-4">
                                    <button type="button" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Bukti pembayaran sudah dikonfirmasi</button>
                                </div>
                            @elseif ($order->is_rejected)
                                <div class="mt-4">
                                    <button type="button" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">Bukti pembayaran telah ditolak</button>
                                </div>
                            @elseif ($order->payment_receipt == true)
                                <div class="mt-4">
                                    <button type="button" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Bukti pembayaran sudah dikirim</button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

