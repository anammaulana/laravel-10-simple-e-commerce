<?php

namespace App\Http\Controllers;

use App\Models\Orders;

use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function create_product()
    {
        return view('create_product');
    }

    public function store_product(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $path,  file_get_contents($file));

        $message = 'Produk telah di tambahkan.';
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'image' => $path
        ]);

        return Redirect::route('index_product')->with('message', $message);
    }

    public function index_product(Request $request)

    {
        $search = $request->input('search');
        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        })->paginate(6);

        // Ambil hasil rata-rata rating, jumlah total rating, dan feedback untuk setiap produk
        $ratingsAndFeedback = Rating::select('product_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as total_ratings'), DB::raw('GROUP_CONCAT(feedback SEPARATOR ";") as feedbacks'))
            ->groupBy('product_id')
            ->get()
            ->keyBy('product_id');

        $purchasedProducts = [];
        $ratedProducts = [];
        if (auth()->check()) {
            $user = auth()->user();
            $purchasedProducts = $user->purchases()->pluck('product_id')->toArray();
            $ratedProducts = Rating::where('user_id', $user->id)->pluck('product_id')->toArray();
        }

        return view('index_product', compact('products', 'purchasedProducts', 'ratedProducts', 'ratingsAndFeedback'));
    }


    public function show_product(Product $product)
    {
        return view('show_product', compact('product'));
    }

    public function edit_product(Product $product)
    {
        return view('edit_product', compact('product'));
    }

    public function update_product(Product $product, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'description' => 'required',
            'category' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);
        $message = 'Produk berhasil di update.';

        $file = $request->file('image');
        $path = time() . '_' . $request->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $path,  file_get_contents($file));


        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'category' => $request->category,
            'stock' => $request->stock,
            'image' => $path
        ]);

        return Redirect::route('show_product', $product)->with('message', $message);
    }

    public function delete_product(Product $product)
    {
        $message = 'Produk dan semua rating terkait berhasil dihapus.';
        // Hapus semua rating terkait dengan produk
        $product->ratings()->delete();

        // Hapus produk
        $product->delete();

        return redirect()->route('index_product')->with('message', $message);
    }


    public function storeRating(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required',
        ]);

        // Cek apakah pengguna sudah membeli produk
        $purchasedProduct = auth()->user()->purchases()->where('product_id', $request->product_id)->exists();
        if (!$purchasedProduct) {
            return redirect()->back()->withErrors(['error' => 'You cannot rate a product that you have not purchased.']);
        }

        // Cek apakah pengguna sudah memberikan rating untuk produk ini
        $existingRating = Rating::where('user_id', auth()->id())
            ->where('product_id', $request->product_id)
            ->exists();
        if ($existingRating) {
            return redirect()->back()->withErrors(['error' => 'You have already rated this product.']);
        }
        $message = 'Rating and feedback have been saved.';

        Rating::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'feedback' => $request->feedback,
        ]);

        return redirect()->back()->with('message', $message );
    }

    // public function storeRating(Request $request)
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'rating' => 'required|integer|min:1|max:5',
    //         'feedback' => 'required',
    //     ]);

    //     // Cek apakah pengguna sudah memberikan rating untuk produk ini
    //     $existingRating = Rating::where('user_id', auth()->id())
    //                             ->where('product_id', $request->product_id)
    //                             ->first();

    //     if ($existingRating) {
    //         return redirect()->back()->withErrors(['error' => 'You have already rated this product.']);
    //     }

    //     Rating::create([
    //         'product_id' => $request->product_id,
    //         'user_id' => Auth::id(),
    //         'rating' => $request->rating,
    //         'feedback' => $request->feedback,
    //     ]);

    //     return redirect()->back()->with('success', 'Rating dan feedback telah disimpan.');
    // }
    // {
    //     $request->validate([
    //         'product_id' => 'required|exists:products,id',
    //         'rating' => 'required|integer|min:1|max:5',
    //         'feedback' => 'required',
    //     ]);

    //     Rating::create([
    //         'product_id' => $request->product_id,
    //         'user_id' => Auth::id(),
    //         'rating' => $request->rating,
    //         'feedback' => $request->feedback,
    //     ]);

    //     return redirect()->back()->with('success', 'Rating dan feedback telah disimpan.');
    // }


}
