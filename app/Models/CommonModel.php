<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<svip_zx1103@163.com>
 * @email  svip_zx1103@163.com
 * User: svip_zx
 * Date: 2020/10/24
 * Time: 07:35
 */

namespace App\Models;

use App\Traits\Common;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models CommonModel.
 */
class CommonModel extends Model
{
    use Common;

    protected $guarded = [];

    const IS_DELETE      = 2;
    const IS_NOT_DELETE  = 1;
    const STATUS_ENABLE  = 1;
    const STATUS_DISABLE = 2;
    public static $statusMap = [
        self::STATUS_DISABLE => '禁用',
        self::STATUS_ENABLE  => '启用',
    ];
    public static $deleteMap = [
        self::IS_DELETE     => '删除',
        self::IS_NOT_DELETE => '正常',
    ];
}
