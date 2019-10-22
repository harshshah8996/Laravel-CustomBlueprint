<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use App\Common\CustomResponse;
use App\User;

use Exception;

class AuthController extends Controller
{
    protected $custom_response;

    public function __construct(CustomResponse $custom_response)
    {
        $this->custom_response = $custom_response;
    }

    public function signUp(Request $request)
    {

        try {
            $user_data = $request->all();

            Validator::make($user_data,[
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string'
            ])->validate();

            $user_data['role_id'] = Config::get('constants.Student_ROLE_ID');

            $user = User::create([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => Hash::make($user_data['password']),
                'role_id' => $user_data['role_id']
            ]);

            $token = $user->createToken('Laravel Password Grant Client');

            $data = [
                'token' => $token->accessToken,
                'user' => $user
            ];

            $message = 'Succesfully Registered';
            $response = $this->custom_response->getSuccessResponse($data, $message);
            return $this->custom_response->sendResponse($response);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            $message = 'Validation Error';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);

        } catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Sign-Up';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }

    public function login(Request $request)
    {

        try {

            if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                $user = Auth::user();

                $token = $user->createToken('Laravel Password Grant Client');

                $data = [
                    'token' => $token->accessToken,
                    'user' => $user
                ];
                $message = 'Succesfully Logged';
                $response = $this->custom_response->getSuccessResponse($data, $message);
            } else {
                $errors = 'Unauthorised';
                $message = 'Please Enter Valid Email And Password';
                $response = $this->custom_response->getErrorResponse($errors, $message, $status = 401);
            }

            return $this->custom_response->sendResponse($response);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            $message = 'Validation Error';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);

        } catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Sign-Up';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }
}
