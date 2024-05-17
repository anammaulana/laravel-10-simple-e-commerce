@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-3 mb-5 bg-white rounded">
                <div class="card-header bg-primary text-white">Buat Produk Baru</div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group pt-2">
                            <label for="name">Nama Produk</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukkan nama produk">
                        </div>
                        <div class="form-group pt-2">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control" placeholder="Masukkan deskripsi" rows="3"></textarea>
                        </div>
                        <div class="form-group pt-2">
                            <label for="category">Kategori</label>
                            <input type="text" id="category" name="category" class="form-control" placeholder="Masukkan kategori">
                        </div>
                        <div class="form-group pt-2">
                            <label for="price">Harga</label>
                            <input type="number" id="price" name="price" class="form-control" placeholder="Masukkan harga">
                        </div>
                        <div class="form-group pt-2">
                            <label for="stock">Stok</label>
                            <input type="number" id="stock" name="stock" class="form-control" placeholder="Masukkan stok">
                        </div>
                        <div class="form-group pt-4">
                            <label for="image">Gambar</label>
                            <input type="file" id="image" name="image" class="form-control-file">
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Kirim Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
