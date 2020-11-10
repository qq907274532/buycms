<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Services\HelperService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // role list
    public function index()
    {
        return view('system.role.index', ['roles' => Role::normal()->get()]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('system.role.create');
        }

        $data = $this->validate($request, [
            'name'        => 'required|max:45',
            'description' => 'max:255',
        ]);

        $result = Role::create($data);
        HelperService::adminLog(true, '添加权限组', $result->id);

        return $this->success();
    }



    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edit(Request $request)
    {
        $id = $request->get('id');
        $role = Role::findOrFail($id);

        if ($request->method() == 'GET') {
            return view('system.role.edit', ['role' => $role]);
        }

        $data = $this->validate($request, [
            'name'        => 'required|max:45',
            'description' => 'max:255',
        ]);

        $role->update($data);
        HelperService::adminLog(true, '修改权限组', $id);

        return $this->success();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPermissions(Request $request)
    {
        $id = $request->input('id');
        $role = Role::with('permissions')->findOrFail($id);

        $selectedIds = $role->permissions->pluck('id')->toArray();

        $permissions = Permission::normal()->where('status',Permission::STATUS_ENABLE)->OrderBy('sort')->get();
        $permissions = Permission::tree($permissions);

        view()->share([
            'keyName'        => 'id',
            'branchView'     => 'tree.branch',
            'branchCallback' => function (Permission $permission) use ($selectedIds) {
                return view('system.role.permission-item', ['permission' => $permission, 'selectedIds' => $selectedIds])->render();
            },
        ]);

        return view('system.role.permissions', [
            'role'   => $role,
            'items'  => $permissions,
            'treeId' => 'tree-' . uniqid(),
        ]);
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function postPermissions(Request $request)
    {
        $id = $request->input('id');
        $role = Role::where(['is_delete' => 1, 'id' => $id])->first();
        if (is_null($role)) {
            return $this->error("查询信息失败");
        }
        $data = $this->validate($request, [
            'permission_ids' => 'required|array',
        ]);

        $role->permissions()->sync($data['permission_ids']);
        HelperService::adminLog(true, '分配权限', $id);
        return $this->success();
    }
    /**
     * 更新状态
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function switch_status(Request $request)
    {
        $id = $request->input('id');
        $info = Role::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $status = $info->status == Role::STATUS_ENABLE ? Role::STATUS_DISABLE : Role::STATUS_ENABLE;
        $info->status = $status;
        if ($info->save()) {
            $message = Role::$statusMap[$status];
            HelperService::adminLog(true, $message . "角色", $id);

            return $this->success($message . "成功");
        } else {
            return $this->error("操作失败");
        }
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
        $info = Role::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $info->is_delete = Role::IS_DELETE;
        if ($info->save()) {
            HelperService::adminLog(true, '删除角色', $id);

            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }
}
