<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\GroupMember;
use Illuminate\Support\Facades\Auth;

class CanViewGroup
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
        $group = Group::findOrFail($request->route('id'));

        if (Auth::user()->role && $group->user_id != Auth::id()) {
            return abort(404);
        }

        if ( Auth::user()->role == 0 && ! GroupMember::where(['group_id' => $group->id, 'user_id' => Auth::id()])->exists()) {
            return abort(404);
        }

        return $next($request);
    }
}
