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
        // Check if the user is authenticated and is an active admin.
        if (!Auth::check()) {
            return abort(404);
        }

        $userId = auth()->user()->id;
        $checkAdmin = AdminModel::withTrashed()->where('user_id', $userId)->first();

        // If the user is not an active admin, deny access.
        if (!$checkAdmin || $checkAdmin->deleted_at !== null) {
            return abort(403, 'Unauthorized access.');
        }

        $checkAccessRights = AccessRightsModel::where('admin_id', $checkAdmin['id'])->first();

        // If the user has no defined access rights, deny access.
        if (!$checkAccessRights) {
            return abort(403, 'Unauthorized access.');
        }

        // Define a mapping of route patterns to required permissions.
        // The most specific routes are listed first to prevent general patterns
        // from overriding specific ones.
        $accessMap = [
            'admin/link/*/visitors'  => 'visitors',  // Specific check for the visitors page
            'admin/link/*'           => 'links',     // General check for all other link pages
            'admin/setting/*'        => 'settings',
            'admin/staff/*'          => 'admin_staff',
        ];

        // Flag to track if the user has permission to access the requested route.
        $hasPermission = false;

        // Check for access to the current route.
        foreach ($accessMap as $routePattern => $permission) {
            // Check if the current request URL matches the route pattern.
            if ($request->is($routePattern)) {
                // If a match is found, check if the user has the required permission.
                if ($checkAccessRights[$permission] == 1) {
                    $hasPermission = true;
                    break; // Exit the loop since we found the most specific match
                } else {
                    // The user does not have permission for this specific route.
                    // The flag remains false and the loop breaks.
                    break;
                }
            }
        }

        // If the user has permission, allow the request to proceed.
        if ($hasPermission) {
            return $next($request);
        }

        // If the current route is denied, find the first accessible route and redirect.
        // The order here determines the default redirect destination.
        if ($checkAccessRights['links'] == 1) {
            return redirect('/admin/link/list');
        } else if ($checkAccessRights['admin_staff'] == 1) {
            return redirect('/admin/staff/list');
        } else if ($checkAccessRights['settings'] == 1) {
            return redirect('/admin/setting/metatag');
        } else if ($checkAccessRights['visitors'] == 1) {
             // Redirect to the links list if only visitors access is available,
             // as the visitor page requires a specific short URL.
            return redirect('/admin/link/list');
        }

        // If the user has no access to any defined module, deny access.
        return abort(403, 'Unauthorized access.');
    }
}
