@extends('layouts.index')

@section('content')
    <div class="container mx-auto py-2"> <!-- Mengurangi padding y dari py-4 menjadi py-2 -->
        <div class="flex justify-center">
            <div class="max-w-2xl"> <!-- Mengurangi lebar maksimal dari max-w-4xl menjadi max-w-2xl -->
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <div class="bg-gray-800 text-white text-center p-2"> <!-- Mengurangi padding dari p-4 menjadi p-2 -->
                        <h5 class="text-lg font-semibold">Detail Produk</h5> <!-- Mengurangi ukuran teks dari text-xl menjadi text-lg -->
                    </div>

                    <div class="p-2"> <!-- Mengurangi padding dari p-4 menjadi p-2 -->
                        @if (session('status'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-1 rounded relative" role="alert"> <!-- Mengurangi padding dari px-4 py-3 menjadi px-2 py-1 -->
                                {{ session('status') }}
                            </div>
                        @endif

                        @if (session('message'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-2 py-1 rounded relative" role="alert"> <!-- Mengurangi padding dari px-4 py-3 menjadi px-2 py-1 -->
                                {{ session('message') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-2 py-1 rounded relative" role="alert"> <!-- Mengurangi padding dari px-4 py-3 menjadi px-2 py-1 -->
                                <ul class="list-disc pl-3"> <!-- Mengurangi padding left dari pl-5 menjadi pl-3 -->
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="text-center">
                            <h3 class="text-xl font-bold">{{ $product->name }}</h3> <!-- Mengurangi ukuran teks dari text-2xl menjadi text-xl -->
                            <img src="{{ url('storage/' . $product->image) }}" alt="Gambar Produk"
                                class="mx-auto rounded mt-2 h-48 object-cover"> <!-- Mengurangi margin top dari mt-3 menjadi mt-2 dan tinggi dari h-72 menjadi h-48 -->
                            <p class="text-md font-bold mt-1">Rp. {{ number_format($product->price, 0, ',', '.') }}</p> <!-- Mengurangi margin top dari mt-2 menjadi mt-1 -->
                            <p class="text-sm font-semibold">Stok: {{ $product->stock }}</p> <!-- Mengurangi ukuran teks dari text-md menjadi text-sm -->
                            <p class="font-semibold italic">Deskripsi:</p>
                            <p class="text-gray-600 mt-1">{{ $product->description }}</p> <!-- Mengurangi margin top dari mt-2 menjadi mt-1 -->

                            <div class="mt-2"> <!-- Mengurangi margin top dari mt-4 menjadi mt-2 -->

                                @if (!Auth::user()->is_admin)
                                    <form action="{{ route('add_to_cart', $product) }}" method="post">
                                        @csrf
                                        <div class="flex justify-center space-x-2"> <!-- Mengurangi space-x dari space-x-4 menjadi space-x-2 -->
                                            <div class="w-1/2">
                                                <select name="size" class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="" disabled selected>Pilih Ukuran</option>
                                                    <option value="One Size">One Size</option>
                                                    <option value="S">S</option>
                                                    <option value="M">M</option>
                                                    <option value="L">L</option>
                                                </select>
                                            </div>
                                            <div class="w-1/2">
                                                <select name="color" class="form-select block w-full mt-1 rounded-md border-gray-300 shadow-sm" required>
                                                    <option value="" disabled selected>Pilih Warna</option>
                                                    <option value="Merah">Merah</option>
                                                    <option value="Biru">Biru</option>
                                                    <option value="Hijau">Hijau</option>
                                                    <option value="Hitam">Hitam</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex justify-center mt-2">
                                            <input type="number" name="amount" class="form-input block w-1/4 rounded-md border-gray-300 shadow-sm"
                                                placeholder="Jumlah" min="1">
                                            <button class="ml-2 px-4 py-1 bg-green-500 text-white rounded hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-700" type="submit">Tambah ke Keranjang</button>
                                        </div>
                                    </form>
                                @endif
                                <div class="flex justify-center space-x-2 mt-2">
                                    @if (Auth::user()->is_admin)
                                        <a href="{{ route('edit_product', $product) }}" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-700">Edit Produk</a>
                                    @endif
                                    <a href="{{ route('index_product') }}" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-700">Kembali ke Semua Produk</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

