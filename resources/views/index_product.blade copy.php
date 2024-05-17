@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">All Products</h1>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <form action="{{ route('index_product') }}" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search.." value="{{ request('search') }}"
                            name="search">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Search</button>
                    </div>
                </form>
            </div>
        </div>

        @if (request('search'))
            @if ($products->count())
                <div class="container">
                    <hr>
                    <div class="row justify-content-center mt-6">
                        @foreach ($products as $product)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100 shadow-sm">
                                    <div class="card-header bg-dark text-white">
                                        <h6 class="mb-0">{{ $product->category }}</h6>
                                    </div>
                                    <img src="{{ url('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                        <p class="card-text">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                        <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($product->created_at)->diffForHumans() }}</small></p>
                                    </div>
                                    <div class="card-footer bg-white">
                                        <form action="{{ route('show_product', $product->id) }}" method="get">
                                            <button type="submit" class="btn btn-primary btn-block">View Product</button>
                                        </form>
                                        @if (Auth::check() && Auth::user()->is_admin)
                                            <form action="{{ route('delete_product', $product->id) }}" method="post" class="mt-2">
                                                @method('delete')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-block">Delete Product</button>
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
            <div class="card mb-3 shadow">
                <img src="https://source.unsplash.com/1200x500/?Clothing" class="card-img-top" alt="...">
                <div class="card-body text-center">
                    <h5 class="card-title">Explore Fashion</h5>
                    <p class="card-text">Discover the latest in Clothing, Shoes, Accessories, Bags, Jewelry</p>
                </div>
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <div class="container mt-4">
            <div class="row justify-content-center mt-4">
                @foreach ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card shadow" style="width: 20rem; background-color: #343a40; color: white;">
                            <div class="card-header bg-dark text-white">
                                <h5 class="mb-0">{{ $product->category }}</h5>
                            </div>
                            <img src="{{ url('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body bg-dark">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">Rp. {{ number_format($product->price, 0, ',', '.') }}</p>
                                <form action="{{ route('show_product', $product->id) }}" method="get">
                                    <button type="submit" class="btn btn-outline-primary">Lihat Produk</button>
                                </form>
                                @if (Auth::check() && Auth::user()->is_admin)
                                    <form action="{{ route('delete_product', $product) }}" method="post" class="mt-2">
                                        @method('delete')
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger">Hapus Produk</button>
                                    </form>
                                @endif

                                @if (!$ratingsAndFeedback->has($product->id))
                                    <div class="alert alert-warning mt-3" role="alert">
                                        Belum ada penilaian untuk produk ini.
                                    </div>
                                @else
                                    <div class="mt-3">
                                        <p><strong>Rating Rata-rata:</strong>
                                            {{ number_format($ratingsAndFeedback[$product->id]->avg_rating, 2) }}</p>
                                        <p><strong>Total Penilaian:</strong>
                                            {{ $ratingsAndFeedback[$product->id]->total_ratings }}</p>
                                        <div class="alert alert-info mt-3" role="alert">
                                            <p><strong>Umpan Balik Pengguna:</strong></p>
                                            @foreach (explode(';', $ratingsAndFeedback[$product->id]->feedbacks) as $feedback)
                                                <p class="text-break fst-italic mb-0">{{ $feedback }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if (in_array($product->id, $purchasedProducts) && !in_array($product->id, $ratedProducts))
                                    <form action="{{ route('storeRating') }}" method="post" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">Rating</label>
                                            <select class="form-select" name="rating" id="rating" required>
                                                <option value="" disabled selected>Pilih rating</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="feedback" class="form-label">Umpan Balik</label>
                                            <textarea class="form-control" name="feedback" id="feedback" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-success">Kirim Rating</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($products->isEmpty())
                    <div class="alert alert-warning mt-4" role="alert">
                        Tidak ada produk yang ditemukan.
                    </div>
                @endif
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection







