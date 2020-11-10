<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2018/11/19
 * Time: 17:35
 */

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Utils\HttpClient;
use Illuminate\Support\Facades\Auth;

/**
 * App\Http\Controllers HomeController.
 */
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->isAdministrator()) {
            $permissions = Permission::where('status', 1)->where('type', 2)->orderBy('sort')->get();
        } else {

            $roles = Auth::user()->roles(1)->with([
                'permissions' => function ($query) {
                    $query->where('admin_permission.status', 1)->where('admin_permission.type', 2)->orderBy('admin_permission.sort');
                }
            ])->get();
            $permissions = $roles->pluck('permissions')->flatten();
        }

        $permissions = Permission::tree($permissions);

        return view('home', ['permissions' => $permissions]);
    }

}
