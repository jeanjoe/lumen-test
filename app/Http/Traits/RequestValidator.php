<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Validator;

trait RequestValidator
{

    use HttpResponse;


    /**
     * Validate Requests
     * 
     * @return HttpResponse
     * @return void
     */
    public function validateRequest($data = [], $rules = [])
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            $this->message = 'The given data was invalid.';
            $this->payload = ['error' => $validator->errors()->toArray()];
            $this->statusCode = 400;
            return $this->sendJsonResponse();
        }
        return true;
    }
}
