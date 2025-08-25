<?php

namespace App\Http\Middleware;

use App\Models\AdminModel;
use App\Models\AccessRightsModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccessRights
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

        $checkAdmin = AdminModel::withTrashed()
            ->where('user_id', $user_id)
            ->first();

        if (Auth::user() && $checkAdmin && $checkAdmin->deleted_at === null) {

            $checkAccessRights = AccessRightsModel::where('admin_id', $checkAdmin['id'])->first();

            if ($request->is('admin/link/*') && $checkAccessRights['links'] == 1) {
                return $next($request);
            } else if ($request->is('admin/setting/*') && $checkAccessRights['settings'] == 1) {
                return $next($request);
            } else if ($request->is('admin/staff/*') && $checkAccessRights['admin_staff'] == 1) {
                return $next($request);
            } else if ($request->is('admin/visitors/*') && $checkAccessRights['visitors'] == 1) {
                return $next($request);
            }

            // Redirects when access is denied

            // links access denied
            else if ($request->is('admin/link/*')) {
                if ($checkAccessRights['visitors'] == 1) {
                    return redirect("/admin/visitors/list");
                } else if ($checkAccessRights['admin_staff'] == 1) {
                    return redirect("/admin/staff/list");
                } else if ($checkAccessRights['settings'] == 1) {
                    return redirect("/admin/setting/metatag");
                }
            }

            // visitorss access denied
            else if ($request->is('admin/visitors/*')) {
                if ($checkAccessRights['links'] == 1) {
                    return redirect("/admin/link/list");
                } else if ($checkAccessRights['settings'] == 1) {
                    return redirect("/admin/setting/metatag");
                } else if ($checkAccessRights['admin_staff'] == 1) {
                    return redirect("/admin/staff/list");
                }
            }

            // Settings access denied
            else if ($request->is('admin/setting/*')) {
                if ($checkAccessRights['links'] == 1) {
                    return redirect("/admin/link/list");
                } else if ($checkAccessRights['visitors'] == 1) {
                    return redirect("/admin/visitors/list");
                } else if ($checkAccessRights['admin_staff'] == 1) {
                    return redirect("/admin/staff/list");
                }
            }

            // Staff access denied
            else if ($request->is('admin/staff/*')) {
                if ($checkAccessRights['links'] == 1) {
                    return redirect("/admin/link/list");
                } else if ($checkAccessRights['visitors'] == 1) {
                    return redirect("/admin/visitors/list");
                } else if ($checkAccessRights['settings'] == 1) {
                    return redirect("/admin/settings/metatag");
                }
            }

            // If no access to anything
            return abort(403, 'Unauthorized access.');
        }

        return abort(404);
    }
}
