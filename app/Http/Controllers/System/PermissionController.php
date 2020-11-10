<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Services\HelperService;
use App\Services\TreeService;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PermissionController extends Controller
{
    // role list
    public function index()
    {
        $permissions = Permission::normal()->OrderBy('sort')->get();
        $permissions = Permission::tree($permissions);

        view()->share([
            'keyName'        => 'id',
            'useEdit'        => true,
            'useDelete'      => true,
            'editPath'       => 'system/permission/edit',
            'deletePath'     => 'system/permission/delete',
            'branchView'     => 'tree.branch',
            'branchCallback' => function (Permission $permission) {
                return view('system.permission.item', ['permission' => $permission])->render();
            },
        ]);

        return view('system.permission.index', [
            'items'      => $permissions,
            'treeId'     => 'tree-' . uniqid(),
            'useCreate'  => true,
            'createPath' => 'system/permission/create',
        ]);
    }

    //create
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $permissions = Permission::normal()->where('status',Permission::STATUS_ENABLE)->OrderBy('sort')->get();
            $permissions = Permission::tree($permissions);

            return view('system.permission.create', ['permissions' => $permissions, 'optionHtml' => TreeService::recursiveSelectOption($permissions)]);
        }

        $rules = [
            'parent_id' => '',
            'slug'      => 'required|max:100',
            'name'      => 'required|max:45',
            'wild_uri'  => 'required|max:100',
            'type'      => 'required|in:1,2',
            'status'    => 'required|in:1,2',
        ];

        if (request('type') == 2) {
            $rules = array_merge($rules, [
                'menu_icon' => 'required',
                'menu_uri'  => 'required',
            ]);
        }

        $data = $this->validate($request, $rules);

        $result = Permission::create($data);
        HelperService::adminLog(true, '添加权限', $result->id);

        return $this->success();
    }

    //update
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $permission = Permission::findOrFail($id);

        if ($request->method() == 'GET') {
            $permissions = Permission::normal()->where('status',Permission::STATUS_ENABLE)->OrderBy('sort')->get();
            $permissions = Permission::tree($permissions);

            return view('system.permission.edit', ['permission' => $permission, 'optionHtml' => TreeService::recursiveSelectOption($permissions, 0, $permission['parent_id'])]);
        }

        $rules = [
            'parent_id' => '',
            'slug'      => 'required|max:100',
            'name'      => 'required|max:45',
            'wild_uri'  => 'required|max:100',
            'type'      => 'required|in:1,2',
        ];

        if (request('type') == 2) {
            $rules = array_merge($rules, [
                'menu_icon' => 'required',
                'menu_uri'  => 'required',
            ]);
        }

        $data = $this->validate($request, $rules);

        $permission->update($data);
        HelperService::adminLog(true, '修改权限', $id);

        return $this->success();
    }

    //排序
    public function sort(Request $request)
    {
        $data = $this->validate($request, [
            '_order' => 'required|json',
        ]);

        $tree = json_decode($data['_order'], true);
        Permission::saveOrder($tree, 0, array_flip(Arr::flatten($tree)));

        return $this->success();
    }

    /**
     * 删除
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {

        $id = $request->input('id');
        $info = Permission::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $info->is_delete = Permission::IS_DELETE;
        if ($info->save()) {
            HelperService::adminLog(true, '删除权限', $id);

            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }

}
