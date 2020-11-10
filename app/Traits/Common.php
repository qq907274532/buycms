<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<svip_zx1103@163.com>
 * @email  svip_zx1103@163.com
 * User: svip_zx
 * Date: 2020/10/24
 * Time: 07:34
 */

namespace App\Traits;


trait Common
{
    /**
     * @param $query
     * @return mixed
     */
    public function scopeNormal($query)
    {
        return $query->where('is_delete', '=',1);
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeStatus($query)
    {
        return $query->where('status', '=',1);
    }
}
