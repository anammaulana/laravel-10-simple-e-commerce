@extends('layouts.index')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex justify-center">
        <div class="w-full max-w-lg">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <div class="bg-blue-600 text-white p-4 rounded-t-lg font-bold text-xl">Buat Produk Baru</div>
                @if ($errors->any())
                <div class="bg-red-500 text-white font-semibold p-3 rounded-lg" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="p-4">
                    <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="form-group">
                            <label for="name" class="font-semibold">Nama Produk</label>
                            <input type="text" id="name" name="name" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan nama produk">
                        </div>
                        <div class="form-group">
                            <label for="description" class="font-semibold">Deskripsi</label>
                            <textarea id="description" name="description" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" rows="3" placeholder="Masukkan deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="category" class="font-semibold">Kategori</label>
                            <input type="text" id="category" name="category" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan kategori">
                        </div>
                        <div class="form-group">
                            <label for="price" class="font-semibold">Harga</label>
                            <input type="number" id="price" name="price" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan harga">
                        </div>
                        <div class="form-group">
                            <label for="stock" class="font-semibold">Stok</label>
                            <input type="number" id="stock" name="stock" class="form-control mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Masukkan stok">
                        </div>
                        <div class="form-group">
                            <label for="image" class="font-semibold">Gambar</label>
                            <input type="file" id="image" name="image" class="form-control-file mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <button type="submit" class="btn btn-success mt-3">Kirim Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
