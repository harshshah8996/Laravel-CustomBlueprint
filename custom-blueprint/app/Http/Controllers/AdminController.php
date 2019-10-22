<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Common\CustomResponse;
use App\User;

use Exception;

class AdminController extends Controller
{
    protected $custom_response;

    public function __construct(CustomResponse $custom_response)
    {
        $this->custom_response = $custom_response;
    }

    public function saveUser(Request $request)
    {
        try {

            $user_data = $request->all();

            Validator::make($user_data,[
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string',
                'role_id' => 'required|integer|exists:roles,id',
            ])->validate();

            $user = User::create([
                'name' => $user_data['name'],
                'email' => $user_data['email'],
                'password' => Hash::make($user_data['password']),
                'role_id' => $user_data['role_id']
            ]);

            $message = 'Success';
            $response = $this->custom_response->getSuccessResponse($user, $message);
            return $this->custom_response->sendResponse($response);

        } catch (ValidationException $e) {
            $errors = $e->errors();
            $message = 'Validation Error';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);

        }
        catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Save User';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }

    public function updateUser(Request $request, $id)
    {
        try {

            $user_data = $request->all();
            $user = User::where('id', $id)->first();
            $user->name = $user_data['name'];
            $user->save();

            $message = 'Success';
            $response = $this->custom_response->getSuccessResponse($user, $message);
            return $this->custom_response->sendResponse($response);

        } catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Save User';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }

    public function getUser(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        $message = 'Success';
        $response  = $this->custom_response->getSuccessResponse($user, $message);
        return $this->custom_response->sendResponse($response);
    }

    public function getAllUsers(Request $request)
    {
        $users = User::all();
        $message = 'Success';
        $response  = $this->custom_response->getSuccessResponse($users, $message);
        return $this->custom_response->sendResponse($response);
    }
}

