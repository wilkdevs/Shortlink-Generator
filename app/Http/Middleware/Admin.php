<?php

namespace App\Http\Middleware;

use App\Models\AdminModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
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

        $user_id = auth()->user()->id;

        $checkAdmin = AdminModel::where('user_id', $user_id)->get();

        if (Auth::user() && (count($checkAdmin) != 0)) {
            if ($checkAdmin[0]->deleted == 0) {
                return $next($request);
            }
        }

        return abort(404);
    }
}
