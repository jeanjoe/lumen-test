<?php

namespace App\Http\Controllers;

use App\Http\Traits\HttpResponse;
use App\Http\Traits\RequestValidator;
use App\Rating;
use Exception;
use Illuminate\Http\Request;

class RatingController extends Controller
{

    use HttpResponse, RequestValidator;

    /**
     * Get All Ratings from the Database
     * 
     * @return App\Rating;
     */
    public function index()
    {
        $ratings = Rating::with('user', 'ratedBy')->get();
        $this->message = 'Rating Data';
        $this->payload = [
            'ratings' => $ratings
        ];
        $this->status = true;
        return $this->sendJsonResponse();
    }

    /**
     * Save Rating to Database
     */
    public function store(Request $request)
    {
        try {
            $validate = $this->validateRequest($request->all(), [
                'rated_by' => 'required|exists:users,id',
                'rating' => 'required|integer|min:1|max:10',
                'user_id' => 'required|exists:users,id'
            ]);
            if ($validate !== true) {
                return $validate;
            }

            if ($request['rated_by'] == $request['user_id']) {
                $this->message = 'You cannot rate yourself';
                $this->statusCode = 400;
                return $this->sendJsonResponse();
            }

            $data = $request->only(['rated_by', 'rating', 'user_id']);

            $rating = Rating::create($data);
            $this->message = 'Rating saved successfully';
            $this->payload = ['rating' => $rating];
            $this->statusCode = 201;
            $this->status = true;

            return $this->sendJsonResponse();
        } catch (Exception $ex) {
            $this->message = 'Unable to save this Rating';
            $this->payload = ['error' => $ex->getMessage()];
            $this->statusCode = 400;
            return $this->sendJsonResponse();
        }
    }
}
