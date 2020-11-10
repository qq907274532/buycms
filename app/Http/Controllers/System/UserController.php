<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Role;
use App\Services\HelperService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {

        $users = AdminUser::with('roles')->where('is_delete', 1)->paginate(20);

        return view('system.user.index', ['users' => $users]);
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
            $roles = Role::normal()->status()->get();
            return view('system.user.create', ['roles' => $roles]);
        }

        $data = $this->validate($request, [
            'username' => 'required|unique:' . config('admin.table.user') . '|max:45',
            'password' => 'required|min:6',
            'realname' => 'required|max:45',
            'phone'    => 'nullable|digits:11',
            'email'    => 'nullable|email',
            'role_ids' => 'required|array',
        ]);

        $roleIds = $data['role_ids'];
        unset($data['role_ids']);

        $data['password'] = Hash::make($data['password']);

        $user = AdminUser::create($data);
        $user->roles()->attach($roleIds);
        HelperService::adminLog(true, '添加管理员', $user->id);

        return $this->success();
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $user = AdminUser::with('roles')->findOrFail($id);

        if ($user->isAdministrator()) {
            throw new AuthorizationException();
        }

        if ($request->method() == 'GET') {
            $roles = Role::normal()->status()->get();

            return view('system.user.edit', ['user' => $user, 'roles' => $roles]);
        }

        $data = $this->validate($request, [
            'password' => 'nullable|min:6',
            'realname' => 'required|max:45',
            'phone'    => 'nullable|digits:11',
            'email'    => 'nullable|email',
            'role_ids' => 'required|array',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $roleIds = $data['role_ids'];
        unset($data['role_ids']);

        $user->update($data);
        $user->roles()->sync($roleIds);
        HelperService::adminLog(true, '修改管理员', $id);

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
        $info = AdminUser::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $status = $info->status == AdminUser::STATUS_ENABLE ? AdminUser::STATUS_DISABLE : AdminUser::STATUS_ENABLE;
        $info->status = $status;
        if ($info->save()) {
            $message = AdminUser::$statusMap[$status];
            HelperService::adminLog(true, $message . "用户", $id);

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
        $info = AdminUser::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $info->is_delete = AdminUser::IS_DELETE;
        if ($info->save()) {
            HelperService::adminLog(true, '删除用户', $id);

            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }
}
