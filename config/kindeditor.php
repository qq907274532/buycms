<?php
/**
 * Created by PhpStorm.
 * Author: ChenHua <Http://www.ichenhua.cn>
 * Date: 2018/6/15 11:31
 */

return [
    "default"     => 'local', //默认返回存储位置url
    "dirver"      => ['local'], //存储平台
    "connections" => [
        "local"  => [
            'prefix' => 'uploads/'.date('Ymd'),
        ],
        "qiniu"  => [
            'access_key' => '',
            'secret_key' => '',
            'bucket'     => '',
            'prefix'     => '',
            'domain'     => ''
        ],
        "aliyun" => [
            'ak_id'     => env('OSS_ACCESS_ID',''),
            'ak_secret' => env('OSS_ACCESS_KEY',''),
            'end_point' => env('OSS_ENDPOINT',''),
            'bucket'    => env('OSS_BUCKET',''),
            'prefix'    => env('OSS_PREFIX',date('Ymd').'/'),
        ],
    ],
];
