<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\OperateLog;


class OperateLogController extends Controller
{
    public function index()
    {
        $search = [
            'username'         => request('username'),
            'action_uri'       => request('action_uri'),
            'action'           => request('action'),
            'resource_id'      => request('resource_id'),
            'created_at_start' => request('created_at_start'),
            'created_at_end'   => request('created_at_end'),
        ];

        $logs = OperateLog::search($search, 20);
        $logs->appends($search);

        return view('system.operate-log.index', ['logs' => $logs]);
    }
}
