<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/5/27
 * Time: 15:45
 */

namespace App\Services;

/**
 * App\Lib Tree.
 */
class TreeService
{

    static function recursiveSelectOption($permissions, $index = 0, $current = 0)
    {
        $html = '';
        if(empty($permissions)){
            return $html;
        }
        foreach ($permissions as $permission) {
            $selected = '';
            if ($permission['id'] == $current) {
                $selected = 'selected';
            }

            $html .= sprintf('<option value="%s" %s>%s</option>', $permission['id'], $selected, str_repeat('　', $index) . $permission['name']);

            if ($permission['children']) {

                $html .= self::recursiveSelectOption($permission['children'], $index + 1, $current);
            }
        }

        return $html;
    }

    /**
     * 生成权限树
     * @param        $list
     * @param int    $parentId
     * @param string $key
     *
     * @return array
     */
    static function getTreeList($list,$parentId = 0,$key = 'parent_id')
    {
        $branch = [];

        foreach ($list as $node) {
            if ($node[$key] == $parentId) {
                $node['children'] = static::getTreeList($list, $node['id']);

                $branch[] = $node;
            }
        }

        return $branch;
    }


}
