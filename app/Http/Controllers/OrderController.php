<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Carbon;



class OrderController extends Controller
{
    public function checkout(Request $request)
    {
        $user_id = Auth::id();
        $carts = Cart::where('user_id', $user_id)->get();
    
        $user = Auth::user();
    
        if(empty($user->address) || empty($user->no_telepon)){
            return redirect()->route('show_profile')->with('error', 'Lengkapi alamat dan nomor telepon pada profil Anda sebelum melanjutkan checkout.');
        }
    
        if($carts->isEmpty())
        {
            return Redirect::back();
        }
    
        $order = Order::create([
            'user_id' => $user_id
        ]);
    
        foreach ($carts as $cart ) {
            $product = Product::find($cart->product_id);
    
            $product->update([
                'stock' => $product->stock - $cart->amount
            ]);
    
            Transaction::create([
                'amount' => $cart->amount,
                'order_id' => $order->id,
                'product_id' => $cart->product_id,
                'size_id' => $cart->product_id,
                'color_id' => $cart->product_id,
            ]);
            $cart->delete();
        }
    
        return Redirect::route('show_order', compact('order'));
    }
    

    public function index_order()
    {
        $orders = Order::paginate(3);
        return view('index_order', compact('orders'));
    }

    public function show_order(Order $order)
    {
        $user = Auth::user();
        $is_admin = $user->is_admin;

        if($is_admin || $order->user_id == $user->id)
        {
            return view('show_order', compact('order'));

        }

        return Redirect::route('index_order');
    }

    public function submit_payment_receipt(Order $order, Request $request)
    {
        $request->validate([
            'payment_receipt' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);
    
        $file = $request->file('payment_receipt');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('public/payment_receipts', $filename);
    
        $order->payment_receipt = 'payment_receipts/' . $filename;
        $order->save();
    
        return redirect()->back()->with('status', 'Bukti pembayaran berhasil diupload.');

        // $file = $request->file('payment_receipt');
        // $path = time() . '_' .     $order->id . '.' . $file->getClientOriginalExtension();

        // Storage::disk('local')->put('public/' . $path,  file_get_contents($file));

        // $request->validate([
        //     'payment_receipt' => 'required'
        // ]);
        // $order->update([
        //     'payment_receipt' => $path
        // ]);

        

        return Redirect::back();
    }

    public function confirm_payment(Order $order)
    {
        $order->update([
            'is_paid' => true
        ]);
    
        // Pastikan estimated_delivery_time sudah berupa objek Carbon
        if (!$order->estimated_delivery_time) {
            $estimatedDeliveryTime = Carbon::now()->addDays(3); // Contoh: estimasi 3 hari dari sekarang
            $order->estimated_delivery_time = $estimatedDeliveryTime;
            $order->save();
        }
    
        return Redirect::back();
    }
    
    public function rejectPayment(Order $order)
    {
        $order->is_rejected = true;
        $order->is_paid = false;
        $order->payment_receipt = null; // Atau tindakan lain yang sesuai
    
        $order->save();
    
        return redirect()->back()->with('status', 'Pembayaran telah ditolak.');
    }
    
    
}
