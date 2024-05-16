<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage; 

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function show_profile()
    {
        $user = Auth::user();

        return view('show_profile', compact('user'));
    }

    public function edit_profile(User $user, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required|min:8|confirmed',
            'no_telepon' => 'required',
            'address' => 'required',
            'image' => 'required',
        ]);
        $user = Auth::user();
     
        $file = $request->file('image');
        $path = time() . '_' . $user->name . '.' . $file->getClientOriginalExtension();

        Storage::disk('local')->put('public/' . $path,  file_get_contents($file));


        $user->update([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'no_telepon' => $request->no_telepon,
            'address' => $request->address,
            'image' => $path
        ]);
        

        return Redirect::back();

    }
}
