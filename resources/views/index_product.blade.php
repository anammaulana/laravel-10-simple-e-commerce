@extends('layouts.index')

@section('content')
    <div class="container mx-auto">
        <h1 class="mb-4 text-center text-3xl font-bold">All Products</h1>
        <div class="flex justify-center">
            <div class="w-1/2">
                <form action="{{ route('index_product') }}" method="get" class="flex">
                    <input type="text" class="form-input flex-1 border-2 border-gray-300 rounded-l-lg p-2" placeholder="Search.." value="{{ request('search') }}" name="search">
                    <button class="bg-gray-200 border-2 border-gray-300 rounded-r-lg px-4 hover:bg-gray-300" type="submit" id="button-addon2">Search</button>
                </form>
            </div>
        </div>

        @if (request('search'))
            @if ($products->count())
                <div class="container mx-auto mt-8">
                    <hr class="my-6">
                    <div class="flex flex-wrap justify-center">
                        @foreach ($products as $product)
                            <div class="w-full md:w-1/3 mb-4 px-2">
                                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                                    <div class="bg-gray-800 text-white p-4">
                                        <h6 class="text-lg font-semibold">{{ $product->category }}</h6>
                                    </div>
                                    <img src="{{ url('storage/' . $product->image) }}" class="w-full" alt="{{ $product->name }}">
                                    <div class="p-4">
                                        <h5 class="text-xl font-semibold mb-2">{{ $product->name }}</h5>
                                        <p class="text-gray-700 mb-3">{{ Str::limit($product->description, 100) }}</p>
                                        <p class="text-gray-900 font-semibold">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="text-gray-600 text-sm">{{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</p>
                                    </div>
                                    <div class="p-4 border-t border-gray-200 flex flex-wrap justify-between items-center">
                                        <form action="{{ route('show_product', $product->id) }}" method="get" class="w-full mb-2">
                                            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Product</button>
                                        </form>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <form action="{{ route('delete_product', $product->id) }}" method="post" class="w-full">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="w-full bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete Product</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <p class="text-center">No products found.</p>
            @endif
        @else
            <!-- Default card when there is no search query -->
            <div class="bg-white mb-3 shadow overflow-hidden rounded-lg mt-8">
                <img src="https://source.unsplash.com/1200x500/?Clothing" class="w-full" alt="...">
                <div class="p-4 text-center">
                    <h5 class="text-lg font-semibold">Explore Fashion</h5>
                    <p class="text-base">Discover the latest in Clothing, Shoes, Accessories, Bags, Jewelry</p>
                </div>
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="container mx-auto mt-4">
            <div class="flex flex-wrap justify-center mt-4">
                @foreach ($products as $product)
                    <div class="w-full md:w-1/3 mb-4 px-4">
                        <div class="bg-gray-800 text-white rounded-lg shadow-lg overflow-hidden">
                            <div class="bg-gray-900 p-4">
                                <h5 class="text-lg">{{ $product->category }}</h5>
                            </div>
                            <img src="{{ url('storage/' . $product->image) }}" class="w-full" alt="{{ $product->name }}">
                            <div class="bg-gray-900 p-4">
                                <h5 class="text-xl mb-2">{{ $product->name }}</h5>
                                <p class="mb-4">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                <form action="{{ route('show_product', $product->id) }}" method="get">
                                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Lihat Produk</button>
                                </form>
                                @if (Auth::check() && Auth::user()->is_admin)
                                    <form action="{{ route('delete_product', $product) }}" method="post" class="mt-2">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded w-full">Hapus Produk</button>
                                    </form>
                                @endif

                                @if (!$ratingsAndFeedback->has($product->id))
                                    <div class="bg-yellow-100 border-yellow-500 text-yellow-700 px-4 py-3 rounded relative mt-3" role="alert">
                                        Belum ada penilaian untuk produk ini.
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <p><strong>Rating Rata-rata:</strong>
                                            {{ number_format($ratingsAndFeedback[$product->id]->avg_rating, 2) }}</p>
                                        <p><strong>Total Penilaian:</strong>
                                            {{ $ratingsAndFeedback[$product->id]->total_ratings }}</p>
                                        <div class="bg-blue-100 border-blue-500 text-blue-700 px-4 py-3 rounded relative mt-3" role="alert">
                                            <p><strong>Umpan Balik Pengguna:</strong></p>
                                            @foreach (explode(';', $ratingsAndFeedback[$product->id]->feedbacks) as $feedback)
                                                <p class="text-break italic mb-0">{{ $feedback }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if (in_array($product->id, $purchasedProducts) && !in_array($product->id, $ratedProducts))
                                    <form action="{{ route('storeRating') }}" method="post" class="mt-4 bg-white p-4 rounded-lg shadow-lg">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="mb-4">
                                            <label for="rating" class="block text-base font-semibold text-gray-800">Berikan Rating</label>
                                            <select class="form-select block w-full mt-2 text-gray-800 border-gray-400 rounded-lg shadow" name="rating" id="rating" required>
                                                <option value="" disabled selected>-- Pilih Rating Anda --</option>
                                                <option value="1">1 - Sangat Buruk</option>
                                                <option value="2">2 - Buruk</option>
                                                <option value="3">3 - Cukup</option>
                                                <option value="4">4 - Baik</option>
                                                <option value="5">5 - Sangat Baik</option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="feedback" class="block text-base font-semibold text-gray-800">Tulis Umpan Balik</label>
                                            <textarea class="form-control block w-full mt-2 text-gray-800 border-gray-400 rounded-lg shadow" name="feedback" id="feedback" rows="4" placeholder="Tuliskan pengalaman Anda menggunakan produk ini..." required></textarea>
                                        </div>
                                        <button type="submit" class="bg-green-600 hover:bg-green-800 text-white font-bold py-3 px-6 rounded-lg w-full">Submit Rating</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($products->isEmpty())
                    <div class="bg-yellow-100 border-yellow-500 text-yellow-700 px-4 py-3 rounded relative mt-4" role="alert">
                        Tidak ada produk yang ditemukan.
                    </div>
                @endif
                <div class="w-full px-4 py-3 flex justify-center">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection







