<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/5/27
 * Time: 15:24
 */

namespace App\Models;

/**
 * App\Models Category.
 */
class ArticleCategory extends CommonModel
{
    protected $table = 'article_category';


    public $primaryKey = 'id';

    protected $guarded = [];



    /**
     * 生成权限树
     *
     * @param $nodes Collection
     * @param $parentId
     *
     * @return array
     */
    public static function tree($nodes, $parentId = 0)
    {
        $branch = [];

        foreach ($nodes as $node) {
            if ($node['parent_id'] == $parentId) {
                $children = static::tree($nodes, $node['id']);

                if ($children) {
                    $node['children'] = $children;
                }

                $branch[] = $node;
            }
        }

        return $branch;
    }

    /**
     * 修改排序
     *
     * @param $tree
     * @param $parentId
     * @param $orderMap
     *
     * @return none
     */
    public static function saveOrder($tree = [], $parentId = 0, $orderMap = [])
    {
        foreach ($tree as $branch) {
            $node = static::find($branch['id']);

            $node['parent_id'] = $parentId;
            $node['sort'] = $orderMap[(int)$branch['id']];
            $node->save();

            if (isset($branch['children'])) {
                static::saveOrder($branch['children'], $branch['id'], $orderMap);
            }
        }
    }
}
