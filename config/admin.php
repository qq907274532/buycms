<?php
/**
 * Created by PhpStorm.
 *
 * @author svip_zx<907274532@qq.com>
 * @email  907274532@qq.com
 * User: svip_zx
 * Date: 2020/3/9
 * Time: 12:56
 */
return [
    //iframe init page
    'homepage' => 'account/profile',

    /*
     * admin name. `logo`选项为空时启用
     */
    'name' => '运营管理后台',

    'logo' => '<b>运营</b> 管理后台',

    'hotel_manager_client' => env('HOTEL_MANAGER_API_URL', ''),
    // skin
    'skin'      => 'skin-blue',

    //table
    'table' => [
        'permission'	  => 'admin_permission',
        'user'			  => 'admin_user',
        'role'			  => 'admin_role',
        'role_user'		  => 'admin_role_user',
        'role_permission' => 'admin_role_permission',
        'operate_log'	  => 'admin_operate_log'
    ],

    //上传
    'ess' => [
        'key'    => env('ESS_ACCESS_KEY', ''),
        'secret' => env('ESS_SECRET_KEY', ''),
        'url'    => env('ESS_URL', ''),
        'bucket' => env('ESS_BUCKET', ''),
    ],

    'log' => [
        'ignore_fields' => [
            'password',
            'password_confirmation'
        ],

    ],
];
