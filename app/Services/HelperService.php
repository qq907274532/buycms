<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<svip_zx1103@163.com>
 * @email  svip_zx1103@163.com
 * User: svip_zx
 * Date: 2020/10/15
 * Time: 19:50
 */

namespace App\Services;

use App\Models\OperateLog;
use Illuminate\Support\Facades\Auth;

/**
 * App\Services Helper.
 */
class HelperService
{
    /**
     * log to admin_operate_log.
     *
     * @param string $path
     *
     * @return string
     */
    public static function adminLog($status, $action, $resourceId, $result = '')
    {

        $input = request()->input();
        foreach ($input as $field => $value) {
            if (in_array($field, config('admin.log.ignore_fields'))) {
                unset($input[$field]);
            }
        }

        $moreInfo = [
            'ip'      => request()->getClientIp(),
            'headers' => request()->headers->all(),
            'input'   => $input,
        ];

        $data = array (
            'user_id'     => Auth::user()->id,
            'username'    => Auth::user()->username,
            'action'      => $action,
            'action_uri'  => ltrim(request()->path(), config('admin.route.prefix') . '/'),
            'resource_id' => $resourceId,
            'result'      => $status ? ($result ? : '操作成功') : '操作失败',
            'more_info'   => json_encode($moreInfo),
            'created_at'  => date('Y-m-d H:i:s')
        );
        OperateLog::create($data);
    }
    public static function random_number($length = 6)
    {
        $pool = '0123456789';

        return substr(str_shuffle(str_repeat($pool, $length)), 0, $length);
    }
}
