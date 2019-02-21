<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Generate basic API response array
     *
     * @param string $collection - e.g. classes, membership-classes, etc.
     * @param boolean $success - default true
     * @param int $status_code - default 200
     * @return array
     * @internal param string $data_type - e.g. classes, membership-classes, etc.
     */
    function buildResponseArray($collection, $success = true, $status_code = 200)
    {
        return $response = [
            'collection' => $collection,
            'success' => ($success ? true : false),
            'api' => 'Checkpoint',
            'version' => '1.0',
            'code' => $status_code,
        ];
    }

    /**
     * Constructs the response object
     *
     * @param $message
     * @param $status
     * @return 
     */
    public function buildResponse($message, $status)
    {
        $response = $this->buildResponseArray('errors', false, $status);
        $response['message'] = $message;
        return response($response, $status);
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
        if ($exception instanceof GennerateUUID5NameNotDefined) {
            return $this->buildResponse('Name for the UUID was not defined.', 409);
        } else if ($exception instanceof GenerateUUID5Failed) {
            return $this->buildResponse('Name for the UUID was not defined.', 409);
        }
        return parent::render($request, $exception);
    }
}
