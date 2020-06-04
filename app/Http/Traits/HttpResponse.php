<?php

namespace App\Http\Traits;

trait HttpResponse {

    protected $statusCode = 200;
    protected $message = "";
    protected $payload = [];
    protected $status = false; 

    /**
     * Send HTTP JSON Response
     * 
     * @return Illuminate\Support\Facades\Response
     */
    public function sendJsonResponse()
    {
        $response = [
            'status' => $this->status,
            'message' => $this->message,
        ];

        if (!empty($this->payload)) {
            $response = array_merge($response, $this->payload);
        }
        return response()->json($response, $this->statusCode);
    }
}