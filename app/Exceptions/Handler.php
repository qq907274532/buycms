<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            $data = [
                'status'  => false,
                'message' => '',
            ];

            switch (true) {
                case $exception instanceof ValidationException:
                    $data['message'] = current($exception->errors())[0];
                    break;
                case $exception instanceof AuthorizationException:
                    $data['message'] = '无权操作';
                    break;
                case $exception instanceof TokenMismatchException:
                    $data['message'] = 'CsrfToken错误，请重新刷新页面。';
                    break;
                case $exception instanceof MethodNotAllowedHttpException || $exception instanceof NotFoundHttpException:
                    $data['message'] = '请求内容不存在';
                    break;

                default:
                    break;
            }

            return response()->json($data);
        }

        switch (true) {
            case $exception instanceof AuthorizationException:
                return response(view('errors.403'));
                break;
            case $exception instanceof MethodNotAllowedHttpException || $exception instanceof NotFoundHttpException:
                return response(view('errors.404'));
                break;
            case $exception instanceof AdminExceptionHandler:
                return response(view('errors.common', ['message' => $exception->getMessage()]));
            default:
                break;
        }
        return parent::render($request, $exception);
    }
}
