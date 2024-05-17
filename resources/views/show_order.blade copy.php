                    @extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header bg-primary text-white">Detail Order</div>

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
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

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">User: <strong>{{ $order->user->name }}</strong></li>
                            <li class="list-group-item">No telepon: <strong>{{ $order->user->no_telepon }}</strong></li>
                            <li class="list-group-item">Alamat: <strong>{{ $order->user->address }}</strong></li>
                            <li class="list-group-item">Transaksi:
                                <ul>
                                    @foreach ($order->transactions as $trans)
                                        <li>
                                            <p>Produk: <strong>{{ $trans->product->name }}</strong></p>
                                            <p>Ukuran: <strong>{{$trans->product->size}}</strong></p>
                                            <p>Warna: <strong>{{$trans->product->color}}</strong></p>
                                            <p>Jumlah: <strong>{{ $trans->amount }} pcs</strong></p>
                                            <p>Harga: Rp.
                                                <strong>{{ number_format($trans->product->price * $trans->amount, 0, ',', '.') }}</strong>
                                            </p>
                                        </li>
                                        @php
                                            $total_price += $trans->product->price * $trans->amount;
                                        @endphp
                                    @endforeach
                                </ul>
                            </li>
                            <hr>
                            <p>Total: Rp. <strong>{{ number_format($total_price, 0, ',', '.') }}</strong></p>
                            @if (!$order->is_paid && !$order->is_rejected && !$order->payment_receipt && !Auth::user()->is_admin)
                                <li class="list-group-item">
                                    <form id="uploadForm" action="{{ route('submit_payment_receipt', $order) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        <label for="submit_payment_receipt">Upload Bukti Pembayaran:</label>
                                        <br>
                                        <input type="file" name="payment_receipt" id="submit_payment_receipt">
                                        <button type="submit" class="btn btn-primary mt-3">Upload Bukti Pembayaran</button>
                                    </form>
                                </li>
                            @elseif ($order->is_paid)
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-success">Bukti pembayaran sudah
                                        dikonfirmasi</button>
                                </li>
                            @elseif ($order->is_rejected)
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-danger">Bukti pembayaran telah ditolak</button>
                                </li>
                            @elseif ($order->payment_receipt == true)
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-info">Bukti pembayaran sudah dikirim</button>
                                </li>
                            @endif
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

