<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
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
        $this->reportable(function (Throwable $e) {
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->route('login');
            }
        });
        
        
    }

    public function render($request, Throwable $exception)
    {
        // Determine whether it is an API interface
        if($request->is('api/*')) {
            $response = [];
            $error = $this->convertExceptionToResponse($exception);
            $response['message'] = $exception->getMessage();
            $response['status_code'] = $error->getStatusCode();
            if(config('app.debug')) {
                if($error->getStatusCode() >= 500) {
                    $response['debug']['line'] = $exception->getLine(); // error line
                    $response['debug']['file'] = $exception->getFile(); // error file
                    $response['debug']['class'] = get_class($exception); // error position
                    $response['debug']['trace'] = explode("\n", $exception->getTraceAsString()); //Error stack
                }
            }
            // response api
            return response()->json($response, $error->getStatusCode());
        } else {
            // response web
            return parent::render($request, $exception);
        }
    }
}
