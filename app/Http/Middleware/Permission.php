<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/3/9
 * Time: 13:20
 */

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
/**
 * App\Http\Middleware Permission.
 */
class Permission
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next)
    {
        $uri = $request->decodedPath();
        if (config('admin.route.prefix')) {
            $uri = str_replace(config('admin.route.prefix') . '/', '', $uri);
        }
        if ($this->check($uri)) {
            return $next($request);
        }

        throw new AuthorizationException("No Permission");
    }

    public function check($uri)
    {
        if (Auth::user()->isAdministrator()) {
            return true;
        }

        if (!Auth::user()->allPermissions()->first(function ($permission) use ($uri) {
            if ($permission['wild_uri'] == '#' || $permission['status'] == 2) {
                return false;
            }

            $pattern = ltrim($permission['wild_uri'], '/');
            if ($pattern == $uri) {
                return true;
            }

            $pattern = str_replace('#', '\#', $pattern);
            $match   = preg_match('#^' . $pattern . '$#', $uri);

            return (bool) $match;
        })) {
            return false;
        }

        return true;
    }
}
