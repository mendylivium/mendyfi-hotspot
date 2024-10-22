<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()) {
            return redirect()
            ->route('admin.auth.login')
            ->with([
                'type'      =>  'danger',
                'message'   =>  'Please Login First'
            ]);
        }

        // if(!auth()->user()->can('admin-function')) {
        //     return redirect()
        //     ->route('client.dashboard')
        //     ->with([
        //         'type'      =>  'danger',
        //         'message'   =>  'You are not allowed!'
        //     ]);
        // }

        return $next($request);
    }
}
