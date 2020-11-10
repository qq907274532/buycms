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
class Article extends CommonModel
{
    protected $table = 'article';
    public $primaryKey = 'id';



    const IS_TOP           = 1;//置顶
    const IS_NOT_TOP       = 2;//取消置顶
    const IS_RECOMMEND     = 1;//推荐
    const IS_NOT_RECOMMEND = 2;//取消推荐

    public static $recommendMap = [
        self::IS_RECOMMEND     => '推荐',
        self::IS_NOT_RECOMMEND => '取消推荐',
    ];
    public static $topMap = [
        self::IS_TOP     => '置顶',
        self::IS_NOT_TOP => '取消置顶',
    ];


    public function category()
    {
        return $this->hasOne(ArticleCategory::class, 'id', 'cat_id');
    }

    /**
     * 查询文章
     *
     * @param array $search
     * @param int   $limit
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function search($search = [], $limit = 20)
    {
        $query = static::query();
        foreach ($search as $field => $value) {
            if (empty($value)) {
                continue;
            }
            if (in_array($field, ['nick'])) {
                continue;
            }
            if ($field == 'created_at_start') {
                $query->whereRaw("created_at >= '{$value}'");
                continue;
            }
            if ($field == 'created_at_end') {
                $query->whereRaw("created_at <= '{$value}'");
                continue;
            }
            $query->where($field, $value);
        }
        $query->normal();
        $query->orderBy('created_at', 'desc');

        return $query->paginate($limit);
    }
}
