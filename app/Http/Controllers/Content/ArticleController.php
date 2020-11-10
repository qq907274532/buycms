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
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * App\Http\Controllers\Content CategoryController.
 */
class ArticleController extends Controller
{
    public function index()
    {
        $search = [
            'title'            => request('title', ''),
            'created_at_start' => request('created_at_start', ''),
            'created_at_end'   => request('created_at_end', ''),
            'cat_id'           => request('cat_id', 0),
        ];
        $cateList = ArticleCategory::normal()->where('status', ArticleCategory::STATUS_ENABLE)->OrderByRaw('sort asc,id desc')->get();
        $cateList = TreeService::getTreeList($cateList);
        $list = Article::search($search)->appends($search);

        return view('content.article.index', ['cateList' => $cateList, 'optionHtml' => TreeService::recursiveSelectOption($cateList, 0, $search['cat_id']), 'list' => $list]);
    }

    /**
     * 创建
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        if ($request->method() == 'GET') {
            $list = ArticleCategory::normal()->where('status', ArticleCategory::STATUS_ENABLE)->OrderByRaw('sort asc,id desc')->get();
            $list = TreeService::getTreeList($list);

            return view('content.article.create', ['optionHtml' => TreeService::recursiveSelectOption($list)]);
        }

        $data = $this->validate($request, [
            'title'        => 'required',
            'keywords'     => 'required|max:100',
            'description'  => 'required|max:45',
            'cover'        => 'required',
            'is_recommend' => 'required|in:1,2',
            'source'       => 'required',
            'is_top'       => 'required|in:1,2',
            'content'      => 'required',
            'cat_id'       => 'required',
        ]);
        $data['operator_name'] = Auth::user()->username;
        $data['operator_id'] = Auth::user()->id;
        $result = Article::create($data);
        if ($result) {
            HelperService::adminLog(true, '添加文章', $result->id);

            return $this->success('添加成功');
        } else {
            return $this->error("添加失败");
        }

    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edit(Request $request)
    {
        $id = $request->input('id');
        $info = Article::findOrFail($id);

        if ($request->method() == 'GET') {
            $list = ArticleCategory::normal()->where('status', ArticleCategory::STATUS_ENABLE)->OrderByRaw('sort asc,id desc')->get();
            $list = TreeService::getTreeList($list);

            return view('content.article.edit', ['info' => $info, 'optionHtml' => TreeService::recursiveSelectOption($list, 0, $info['parent_id'])]);
        }

        $data = $this->validate($request, [
            'title'        => 'required',
            'keywords'     => 'required|max:100',
            'description'  => 'required|max:45',
            'cover'        => 'required',
            'is_recommend' => 'required|in:1,2',
            'source'       => 'required',
            'is_top'       => 'required|in:1,2',
            'content'      => 'required',
            'cat_id'       => 'required',
        ]);


        if ($info->update($data)) {
            HelperService::adminLog(true, '修改文章', $id);

            return $this->success('修改成功');
        } else {
            return $this->error("修改失败");
        }

    }

    /**
     * 推荐
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function recommend(Request $request)
    {
        $id = $request->input('id');
        $info = Article::normal()->where('id', $id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $status = $info->is_recommend == Article::IS_RECOMMEND ? Article::IS_NOT_RECOMMEND : Article::IS_RECOMMEND;
        $info->is_recommend = $status;
        if ($info->save()) {
            $message = Article::$recommendMap[$status];
            HelperService::adminLog(true, $message . '文章', $id);

            return $this->success($message . '成功');
        } else {
            return $this->error('操作失败');
        }

    }

    /**
     * 置顶
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function top(Request $request)
    {
        $id = $request->input('id');
        $info = Article::normal()->where('id', $id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $status = $info->is_top == Article::IS_TOP ? Article::IS_NOT_TOP : Article::IS_TOP;

        $info->is_top = $status;
        if ($info->save()) {
            $message = Article::$topMap[$status];
            HelperService::adminLog(true, $message . '文章', $id);

            return $this->success($message . '成功');
        } else {
            return $this->error('操作失败');
        }

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
        $info = Article::normal()->where('id',$id)->first();
        if (is_null($info)) {
            return $this->error("查询信息失败");
        }
        $status = $info->status == Article::STATUS_ENABLE ? Article::STATUS_DISABLE : Article::STATUS_ENABLE;
        $info->status = $status;
        if ($info->save()) {
            $message = Article::$statusMap[$status];
            HelperService::adminLog(true, $message . "文章", $id);

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
        if (empty($id)) {
            return $this->error(false, '参数有误');
        }
        $ids = is_array($id) ? $id : [$id];
        $result = Article::whereIn('id', $ids)->update(['is_delete' => Article::IS_DELETE]);
        if ($result) {
            HelperService::adminLog(true, '删除文章', '');

            return $this->success('删除成功');
        } else {
            return $this->error('删除失败');
        }
    }

}
