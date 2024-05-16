@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header bg-primary text-white">Keranjang Belanja</div>

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
                        @forelse ($carts as $cart)
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <img src="{{ url('storage/' . $cart->product->image) }}" alt="image_product"
                                        class="img-fluid rounded">
                                </div>
                                @php
                                    $total_price += $cart->product->price * $cart->amount;
                                @endphp
                                <div class="col-md-8">
                                    <h4>{{ $cart->product->name }}</h4>
                                    <p>Jumlah: {{ $cart->amount }}</p>
                                    <p>Ukuran: {{ $cart->product->size }}</p>
                                    <p>Warna: {{ $cart->product->color }}</p>
                                    <p>Harga: Rp. {{ number_format($cart->product->price, 0, ',', '.') }}</p>
                                    <form action="{{ route('update_cart', $cart) }}" method="post">
                                        @method('patch')
                                        @csrf
                                        <input class="form-control mb-2" type="number" name='amount'
                                            value="{{ $cart->amount }}">
                                        <button type="submit" class="btn btn-primary">Perbarui</button>
                                    </form>
                                    <form action="{{ route('delete_cart', $cart) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-danger mt-2">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-center">Keranjang belanja Anda kosong.</p>
                        @endforelse
                        @if ($carts->isNotEmpty())
                            <div class="text-right">
                                <form action="{{ route('checkout') }}" method="post">
                                    @csrf
                                    <p>Total: Rp. {{ number_format($total_price, 0, ',', '.') }}</p>
                                    <button type="submit" class="btn btn-warning">Checkout</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

