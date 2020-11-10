<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/6/2
 * Time: 17:47
 */

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\HelperService;
use Illuminate\Http\Request;

/**
 * App\Http\Controllers\User\Index IndexController.
 */
class IndexController   extends Controller
{
     public function index()
     {
         $search = [
             'phone'            => request('phone', ''),
             'created_at_start' => request('created_at_start', ''),
             'created_at_end'   => request('created_at_end', ''),
         ];
         $list = User::search($search)->appends($search);
         return view('user.index.index',['list'=>$list]);
     }

    /**
     * 操作
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function operation(Request $request)
    {
        $id = $request->post('id');
        $info = User::findOrFail($id);

        $status = $info['status'] == User::STATUS_DISABLE ? User::STATUS_ENABLE : User::STATUS_DISABLE;

        $info->update(['status' => $status]);
        HelperService::adminLog(true, User::$statusMap[$status] . '用户', $id);
        return $this->success();
    }
}
