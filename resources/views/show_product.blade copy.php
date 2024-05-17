@extends('layouts.app')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card-header bg-dark text-white text-center">
                        <h5 class="mb-0">Detail Produk</h5>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="alert alert-success" role="alert">
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="font-weight-bold">{{ $product->name }}</h3>
                            <img src="{{ url('storage/' . $product->image) }}" alt="Gambar Produk"
                                class="img-fluid rounded mt-3" style="max-height: 300px;">
                            <p class=" fw-bold mt-2">Rp. {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                            <p class="fw-semibold">Stok: {{ $product->stock }}</p>
                            <p class="fw-semibold fst-italic">Deskripsi :</p>
                            <p class="text-right text-break text-muted mt-2">{{ $product->description }}</p>

                            <div class=" mt-4">

                                @if (!Auth::user()->is_admin)
                                    <form action="{{ route('add_to_cart', $product) }}" method="post">
                                        @csrf
                                        <div class="row justify-content-center">
                                            <div class="input-group col-md-8 mb-3 w-50">
                                                <select name="size" class="form-control w-50" required>
                                                    <option value="" disabled selected>Pilih Ukuran</option>
                                                    <option value="One Size">One Size</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                </select>
                                                <select name="color" class="form-control w-50" required>
                                                    <option value="" disabled selected>Pilih Warna</option>
                                                    <option value="Merah">Merah</option>
                                                    <option value="Biru">Biru</option>
                                                    <option value="Hijau">Hijau</option>
                                                    <option value="Hitam">Hitam</option>

                                                </select>
                                            </div>
                                            <div class="input-group col-md-8  mb-3 w-50">
                                                <input type="number" name="amount" class="form-control w-50"
                                                    placeholder="Jumlah" min="1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-success" type="submit">Tambah ke
                                                        Keranjang</button>
                                                </div>
                                            </div>
                                        </div>
                            </div>
                            </form>
                            @endif
                            <div class="row justify-content-center">
                                <div class="col-md-2">
                                    @if (Auth::user()->is_admin)
                                        <a href="{{ route('edit_product', $product) }}" class="btn btn-primary mb-3">Edit
                                            Produk</a>
                                    @endif
                                    <a href="{{ route('index_product') }}" class="btn btn-secondary">Kembali ke Semua
                                        Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
