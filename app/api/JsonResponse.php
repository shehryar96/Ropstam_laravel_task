<?php

namespace App\api;

use Illuminate\Support\Facades\Response;

class JsonResponse
{
    public $status;
    public $statusCode;
    public $statusMessage;
    public $count;
    public $payLoad;

    public function __construct($statusValue,  $errorCodeValue, $messageValue,$countValue = 0, $payLoadvalue = null)
    {
        $this->status = $statusValue;
        $this->statusMessage = $messageValue;
        $this->statusCode = (int)$errorCodeValue;
        $this->count = $countValue;
        $this->payLoad = $payLoadvalue;
    }

    public function json($returnCode)
    {
        return Response::json($this,(int)$returnCode);
    }

}