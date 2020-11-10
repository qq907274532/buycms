<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperateLog extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    //constructor
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('admin.table.operate_log'));

        parent::__construct($attributes);
    }

    /**
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

            if ($field == 'created_at_start') {
                $query->where('created_at', '>=', $value);
                continue;
            } elseif ($field == 'created_at_end') {
                $query->where('created_at', '<=', $value);
                continue;
            } elseif ($field == 'action_uri') {
                $query->where('action_uri', 'like', $value . '%');
                continue;
            }

            $query->where($field, $value);
        }

        $query->orderBy('id', 'desc');

        return $query->paginate($limit);
    }
}
