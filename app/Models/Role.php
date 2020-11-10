<?php

namespace App\Models;

class Role extends CommonModel
{
    protected $guarded = [];

    //constructor
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('admin.table.role'));

        parent::__construct($attributes);
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', config('admin.table.role_permission'));
    }
}
