<?php

namespace App\Models;

use App\Traits\Common;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AdminUser extends Authenticatable
{
    use Notifiable,Common;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const STATUS_ENABLE  = 1;
    const STATUS_DISABLE = 2;
    const IS_DELETE      = 2;
    const IS_NOT_DELETE  = 1;
    public static $statusMap = [
        self::STATUS_DISABLE => '禁用',
        self::STATUS_ENABLE  => '启用',
    ];

    //constructor
    public function __construct(array $attributes = [])
    {
        $this->setTable(config('admin.table.user'));

        parent::__construct($attributes);
    }

    public function isAdministrator()
    {
        return $this->username == 'admin';
    }

    public function roles($status = 0)
    {
        if ($status) {

            return $this->belongsToMany('App\Models\Role', config('admin.table.role_user'),'user_id','role_id')->where(config('admin.table.role') . '.status', $status);
        }

        return $this->belongsToMany('App\Models\Role', config('admin.table.role_user'),'user_id','role_id');
    }

    public function allPermissions()
    {
        return $this->roles()->with('permissions')->get()->pluck('permissions')->flatten();
    }
}
