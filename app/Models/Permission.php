<?php

namespace App\Models;


class Permission extends CommonModel
{
    protected $guarded = [];

    //constructor
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('admin.table.permission'));

        parent::__construct($attributes);
    }

    /**
     * 生成权限树
     *
     * @param $nodes Collection
     * @param $parentId
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
     * @param array $tree
     * @param int   $parentId
     * @param array $orderMap
     */
    public static function saveOrder($tree = [], $parentId = 0, $orderMap = [])
    {
        foreach ($tree as $branch) {
            $node = static::find($branch['id']);

            $node['parent_id'] = $parentId;
            $node['sort']      = $orderMap[(int) $branch['id']];
            $node->save();

            if (isset($branch['children'])) {
                static::saveOrder($branch['children'], $branch['id'], $orderMap);
            }
        }
    }
}
