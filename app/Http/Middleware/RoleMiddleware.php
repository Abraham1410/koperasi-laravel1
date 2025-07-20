<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware  // <- Nama class harus sesuai nama file
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (strtolower($user->role) !== strtolower($role)) {
            abort(403, 'Unauthorized access');
        }

        return $next($request);
    }
}
