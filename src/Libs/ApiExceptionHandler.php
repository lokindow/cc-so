<?php

namespace Src\Libs;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Src\Libs\Log;

class ApiExceptionHandler extends ExceptionHandler
{

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        /*
         * Removes stacktrace from logging,
         * this makes it easy to store log on cloudwatch
         * (no multiline logging messages)
         * from https://stackoverflow.com/questions/30583567/laravel-5-remove-stack-trace
         */
        // keep stacktrace on local development
        if (env('APP_ENV') === 'local') {
            parent::report($exception);
        }
        else {
            // logs just the error (no stacktrace)
            $objLog = new Log();
            $objLog->writeLine(
                'error',
                '['.$exception->getCode().'] "'.$exception->getMessage().'" on line '.$exception->getTrace()[0]['line'].' of file '.$exception->getTrace()[0]['file']
            );
        }
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
        if ($request instanceof Request &&
            strpos((string) $request->getHttpHost(), "api.") !== false){
            return $this->handleApiException($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Custom handler to handle api exceptions (with REST response)
     *
     * @param Request $objRequest
     * @param Exception $objException
     * @return JsonResponse
     */
    private function handleApiException($objRequest, Exception $objException)
    {
        $objException = $this->prepareException($objException);

        if ($objException instanceof HttpResponseException) {
            $objException = $objException->getResponse();
        }

        if ($objException instanceof ValidationException) {
            $objException = $this->convertValidationExceptionToResponse($objException, $objRequest);
        }

        $objUtils = new Utils();
        $intStatusCode = method_exists($objException, 'getStatusCode') ? $objException->getStatusCode() : 500;

        return $objUtils->getApiError($intStatusCode);
    }
}
