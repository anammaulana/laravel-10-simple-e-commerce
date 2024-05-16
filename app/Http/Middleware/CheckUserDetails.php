<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserDetails
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user->address || !$user->no_telepon) {
            $request->session()->flash('message', 'Harap lengkapi alamat dan nomor telepon Anda sebelum melanjutkan check out.');
            return redirect()->route('edit_profile');
        }

        return $next($request);
    }
}
