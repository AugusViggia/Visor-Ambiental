<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Helpers\Alert\AlertType;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->enabled) {
            auth('web')->logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            flashAlert(__('Account is banned.'), AlertType::DANGER);

            return redirect()->route('login');
        }

        return $next($request);
    }
}
