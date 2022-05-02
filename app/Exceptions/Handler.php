<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Src\Libs\Log;
use Throwable;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $e)
    {
        $intStatusCode = 500;
        $arrJson = [
            'error' => [
                "message" => __("custom.generic_error"),
                "details" => ENV('APP_ENV') == "local" ? $e->getMessage() : null
            ]
        ];

        if (get_class($e) == "Symfony\Component\HttpKernel\Exception\HttpException" || get_parent_class($e) == "Symfony\Component\HttpKernel\Exception\HttpException") {
            $arrJson['error'] = json_decode($e->getMessage());
            $intStatusCode = $e->getStatusCode();
        }

        $objLog = new Log();
        $objLog->writeLine(
            'error',
            'ExceptionHandler: ',
            $arrJson
        );

        return response()->json($arrJson, $intStatusCode);
    }

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
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
