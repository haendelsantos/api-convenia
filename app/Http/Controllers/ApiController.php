<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request as Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response as ResponseHTTP;
use Carbon\Carbon;

class ApiController extends Controller
{
    protected $statusCode = ResponseHTTP::HTTP_OK;

    /**
     * Get the value of statusCode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set the value of statusCode
     *
     * @return  self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }
    /**
     * Not Found!
     *
     * @param string $message
     * @return void
     */
    protected function respondNotFound($message = 'Not Found!')
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_NOT_FOUND)
            ->respondWithError($message);
    }

    /**
     * Not Found!
     *
     * @param string $message
     * @return void
     */
    protected function respondInternalError($message = 'Internal Error!')
    {
        return $this->setStatusCode(ResponseHTTP::HTTP_INTERNAL_SERVER_ERROR)
            ->respondWithError($message);
    }
    /**
     * Default Respond API
     * @param object data
     * @param headers array
     * @return json
     */
    protected function respond($data, $headers = [])
    {
        return Response::json($data,$this->getStatusCode(),$headers);
    }

    /**
     * Response API Error
     *
     * @param string $message
     * @return void
     */
    protected function respondWithError($message = '')
    {
        return response()->json([
            'error' => [
               'message' => $message,
               'status_code' => $this->getStatusCode()
            ]
        ]);
    }
}