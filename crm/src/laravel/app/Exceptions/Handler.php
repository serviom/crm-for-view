<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Exception;
use App\Services\Microservices\ErrorLog;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var string[]
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
       $this->renderable(function (Throwable $e, $request) {
           $isLogging = config('app.EnableError');

           if($isLogging){
                $error = [];
                $error['request'] = request()->fullUrl();
                $error['method']  = request()->method();
                $error['referer']  = request()->headers->get('referer');
                $error['data']= request()->post();
                $error['file']    = $e->getFile();
                $error['code']    = $e->getCode();
                $error['line']    = $e->getLine();
                $error['message'] = $e->getMessage();
                $error['trace']   = array_slice($e->getTrace(), 0, 10);

                $err= new ErrorLog();
                $err->addLog([
                    'title' => $e->getMessage(),
                    'tenant_id' => 0,
                    'user_id' => Auth::guard()->user() ? Auth::guard()->user()->getAuthIdentifier() : null,
                    'user_name' => Auth::guard()->user() ? Auth::guard()->user()->name : null,
                    'ip' => is_null(request()->header('x-forwarded-for')) ? request()->ip() : request()->header('x-forwarded-for'),
                    'log' => $error
                ]);
            }
        });
    }

    public function render($request, Throwable $exception) {
        if ($exception instanceof AuthorizationException) {
            return response()->json(['message' => 'Помилка доступу'], 403);
        } else {
            return parent::render($request, $exception);
        }
    }
}
