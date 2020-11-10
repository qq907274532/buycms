<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/6/2
 * Time: 15:47
 */

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use App\Services\HelperService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * App\Http\Controllers\Content SlideController.
 */
class SlideController extends Controller
{
    public function index()
    {
        return view('content/slide/index', ['list' => Slide::normal()->orderBy('sort', 'asc')->get()]);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            return view('content.slide.create');
        }

        $data = $this->validate($request, [
            'url'    => 'required|url',
            'title'  => 'required|max:200',
            'img'    => 'required',
            'sort'   => 'required|numeric',
        ]);

        $result = Slide::create($data);
        if($result){
            HelperService::adminLog(true, '添加轮播', $result->id);
            return $this->success();
        }else{
            return $this->error('添加失败');
        }

    }

    //排序
    public function sort(Request $request)
    {
        $data = $this->validate($request, [
            'ids' => 'required|array',
        ]);

        $tree = $data['ids'];
        Slide::saveOrder($tree, array_flip(Arr::flatten($tree)));

        return $this->success();
    }

    public function edit(Request $request)
    {
        $id = $request->get('id');
        $info = Slide::findOrFail($id);

        if ($request->method() == 'GET') {
            return view('content.slide.edit', ['info' => $info]);
        }

        $data = $this->validate($request, [
            'url'    => 'required|url',
            'title'  => 'required|max:200',
            'img'    => 'required',
            'sort'   => 'required|numeric',
        ]);

        $info->update($data);
        HelperService::adminLog(true, '修改轮播图', $id);

        return $this->success();
    }

    /**
     * 操作
     *
     * @param Request $request
     */
    public function operation(Request $request)
    {
        $id = $request->input('id');
        $info = Slide::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }

        $status = $info['status'] == Slide::STATUS_DISABLE ? Slide::STATUS_ENABLE : Slide::STATUS_DISABLE;
        $info->status = $status;

        if ($info->save()) {
            $message = Slide::$statusMap[$status];
            HelperService::adminLog(true, $message . '轮播图', $id);

            return $this->success($message . '成功');
        } else {
            return $this->error('操作失败');
        }

    }

    /**
     * 删除
     *
     * @param Request $request
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');
        if (empty($id)) {
            return $this->error(false, '参数有误');
        }
        $ids = is_array($id) ? $id : [$id];
        $result = Slide::whereIn('id', $ids)->update(['is_delete' => Slide::IS_DELETE]);
        if ($result) {
            HelperService::adminLog(true, '删除轮播图', '');

            return $this->success();
        } else {
            return $this->error('删除失败');
        }

    }
}
