<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/5/29
 * Time: 18:19
 */

namespace App\Models;

/**
 * App\Models Article.
 */
class Slide extends CommonModel
{
    protected $table = 'slide';
    public $primaryKey = 'id';

    protected $guarded = [];


    /**
     * 修改排序
     * @param array $tree
     * @param array $orderMap
     */
    public static function saveOrder($tree = [], $orderMap = [])
    {
        foreach ($tree as $branch) {
            $node = static::find($branch);
            $node['sort']      = $orderMap[(int) $branch];
            $node->save();

            if (isset($branch['children'])) {
                static::saveOrder($branch['children'], $orderMap);
            }
        }
    }
}
