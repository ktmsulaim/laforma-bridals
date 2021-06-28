<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomerActiveMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = auth('customer')->user();

        if($customer && $customer->status === 1) {
            return $next($request);
        }

        return redirect()->route('customer.inactive');
    }
}
