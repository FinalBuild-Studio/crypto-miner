<?php

namespace App\Exceptions;

use Exception;
use ErrorException;
use TypeError;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthenticationException::class,
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        TokenMismatchException::class,
        ValidationException::class,
        GeneralException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($this->isHttpException($exception)) {
            return parent::render($request, $exception);
        }

        $code    = method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500;
        $message = '未知的錯誤';

        switch (get_class($exception)) {
            case AuthenticationException::class:
            case AuthorizationException::class:
                $code    = 401;
                $message = '您的token已經失效或是過期，請重新登入';
                break;
            case TypeError::class:
            case FatalThrowableError::class:
                $code = 400;
                break;
            case ModelNotFoundException::class:
                $code    = 404;
                $message = '找不到資源';
                break;
            case GeneralException::class:
                $message = $exception->getMessage();
                break;
        }

        if ($request->wantsJson()) {
            $payload = method_exists($exception, 'getPayload') ? $exception->getPayload() : [];
            $error  = [
                'message' => $message
            ];

            return response()
                ->json($error, $code);
        }


        return back()
            ->with('error', $message);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()
            ->guest(action('Auth\LoginController@index'));
    }
}
