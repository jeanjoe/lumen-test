<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Http\Traits\HttpResponse;
use App\Http\Traits\RequestValidator;
use Exception;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use HttpResponse, RequestValidator;

    /**
     * Get All Users from the Database
     * 
     * @return App\User;
     */
    public function index()
    {
        $users = User::with('ratings.ratedBy', 'averageRating')->get();
        $this->message = 'User Data';
        $this->payload = [
            'users' => $users
        ];
        $this->status = true;
        return $this->sendJsonResponse();
    }

    /**
     * Save User to Database
     */
    public function store(Request $request)
    {
        try {
            $validate = $this->validateRequest($request->all(), [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|string|min:8|max:16|confirmed'
            ]);
            if ($validate !== true) {
                return $validate;
            }

            $request['password'] = Hash::make($request['password']);
            $data = $request->only(['name', 'email', 'password']);

            $user = User::create($data);
            $this->message = 'User registered successfully';
            $this->payload = ['user' => $user];
            $this->statusCode = 201;
            $this->status = true;

            return $this->sendJsonResponse();
        } catch (Exception $ex) {
            $this->message = 'Unable to registere this User';
            $this->payload = ['error' => $ex->getMessage()];
            $this->statusCode = 400;
            return $this->sendJsonResponse();
        }
    }

    /**
     * Get User with specified Id
     * 
     * @var integer
     * 
     * @return App\User
     */
    public function show($id)
    {
        try {
            $user = User::with('ratings', 'averageRating')->findOrFail($id);
            $this->message = 'User retrieved successfully';
            $this->payload = ['user' => $user];
            $this->statusCode = 200;
            $this->status = true;

            return $this->sendJsonResponse();
        } catch (Exception $ex) {
            $this->message = 'Unable to find this User.';
            $this->payload = ['error' => $ex->getMessage()];
            $this->statusCode = 404;
            return $this->sendJsonResponse();
        }
    }
}
