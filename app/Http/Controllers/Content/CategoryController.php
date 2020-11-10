<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/5/27
 * Time: 15:20
 */

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Services\HelperService;
use App\Services\TreeService;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

/**
 * App\Http\Controllers\Content CategoryController.
 */
class CategoryController extends Controller
{
    public function index()
    {
        $list = ArticleCategory::OrderByRaw('sort,id desc')->get();
        $list = TreeService::getTreeList($list);
        view()->share([
            'keyName'        => 'id',
            'useEdit'        => true,
            'useOperation'   => true,
            'editPath'       => 'content/category/edit',
            'operationPath'  => 'content/category/operation',
            'branchView'     => 'content.tree.branch',
            'branchCallback' => function (ArticleCategory $list) {
                return view('content.category.item', ['list' => $list])->render();
            },
        ]);

        return view('content.category.index', [
            'items'      => $list,
            'treeId'     => 'tree-' . uniqid(),
            'useCreate'  => true,
            'createPath' => 'content/category/create',
        ]);
    }

    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $list = ArticleCategory::where('status', ArticleCategory::STATUS_ENABLE)->OrderByRaw('sort asc,id desc')->get();
            $list = TreeService::getTreeList($list);

            return view('content.category.create', ['list' => $list, 'optionHtml' => TreeService::recursiveSelectOption($list)]);
        }

        $data = $this->validate($request, [
            'parent_id' => '',
            'keywords'  => 'required|max:100',
            'name'      => 'required|max:45',
            'desc'      => '',
            'status'    => 'required|in:1,2',
        ]);

        $result = ArticleCategory::create($data);
        HelperService::adminLog(true, '添加分类', $result->id);

        return $this->success();
    }

    public function edit(Request $request)
    {
        $id = $request->input('id');
        $permission = ArticleCategory::findOrFail($id);

        if ($request->method() == 'GET') {
            $list = ArticleCategory::where('status', ArticleCategory::STATUS_ENABLE)->OrderByRaw('sort asc,id desc')->get();
            $list = TreeService::getTreeList($list);

            return view('content.category.edit', ['permission' => $permission, 'optionHtml' => TreeService::recursiveSelectOption($list, 0, $permission['parent_id'])]);
        }
        $data = $this->validate($request, [
            'parent_id' => '',
            'keywords'  => 'required|max:100',
            'name'      => 'required|max:45',
            'desc'      => '',
            'status'    => 'required|in:1,2',
        ]);

        $permission->update($data);
        HelperService::adminLog(true, '修改分类', $id);

        return $this->success();
    }

    /**
     * 删除
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function operation(Request $request)
    {
        $id = $request->input('id');
        $info = ArticleCategory::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $info->is_delete = ArticleCategory::IS_DELETE;
        if ($info->save()) {
            HelperService::adminLog(true, '删除分类', $id);

            return $this->success();
        } else {
            return $this->error('删除失败');
        }
    }

    //排序
    public function sort(Request $request)
    {
        $data = $this->validate($request, [
            '_order' => 'required|json',
        ]);

        $tree = json_decode($data['_order'], true);
        ArticleCategory::saveOrder($tree, 0, array_flip(Arr::flatten($tree)));

        return $this->success();
    }
}
