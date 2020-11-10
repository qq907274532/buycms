<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/6/2
 * Time: 17:54
 */

namespace App\Models;

/**
 * App\Models User.
 */
class User  extends CommonModel
{
    protected $table = 'user';
    public $primaryKey = 'id';


    /**
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
            if (in_array($field, [])) {
                continue;
            }
            if ($field == 'created_at_start') {
                $query->whereRaw("created_at >= '{$value}'");
                continue;
            }
            if ($field == 'created_at_end') {
                $query->whereRaw("create_time <= '{$value}'");
                continue;
            }
            $query->where($field, $value);
        }

        $query->orderBy('create_time', 'desc');

        return $query->paginate($limit);
    }
}
