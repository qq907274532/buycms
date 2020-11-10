<?php

namespace App\Http\Controllers;

use App\Exceptions\AdminExceptionHandler;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * 成功
     * @param string $message
     * @param array  $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function success($message = '操作成功', $data = [])
    {
        $data = [
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($data);
    }

    /**
     * 失败
     * @param string $message
     * @param array  $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function error($message = '操作失败', $data = [])
    {
        $data = [
            'status'  => false,
            'message' => $message,
            'data'    => $data,
        ];

        return response()->json($data);
    }

    /**
     * 返回json
     *
     * @param $status
     * @param $message
     * @param $data
     */
    protected function errorIf($status, $message = '', $data = [])
    {
        if ($status) {
            if (request()->expectsJson()) {
                $this->renderJson(false, $message, $data);
            } else {
                throw new AdminExceptionHandler($message);
            }
        }
    }

    /**
     * 返回json
     *
     * @param $status
     * @param $message
     * @param $data
     */
    protected function errorUnless($status, $message = '', $data = [])
    {
        if (!$status) {
            if (request()->expectsJson()) {
                $this->renderJson(false, $message, $data);
            } else {
                throw new AdminExceptionHandler($message);
            }
        }
    }
}
