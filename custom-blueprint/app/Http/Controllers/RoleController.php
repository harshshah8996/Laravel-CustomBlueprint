<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Common\CustomResponse;

use Exception;

class RoleController extends Controller
{
    protected $custom_response;

    public function __construct(CustomResponse $custom_response)
    {
        $this->custom_response = $custom_response;
    }

    public function createRole(Request $request)
    {
        try {
            $role_data = $request->all();
            $role = Role::create([
                'name' => $role_data['name']
            ]);

            $message = 'Success';
            $response = $this->custom_response->getSuccessResponse($role, $message);
            return $this->custom_response->sendResponse($response);

        } 
        catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Save Role';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }

    public function updateRole(Request $request, $id)
    {
        try {

            $role_data = $request->all();
            $role = Role::where('id', $id)->first();
            $role->name = $role_data['name'];
            $role->save();

            $message = 'Success';
            $response = $this->custom_response->getSuccessResponse($role, $message);
            return $this->custom_response->sendResponse($response);
        } 
        catch (Exception $e) {
            $errors =  $e->getMessage();
            $message =  'Error In Update Role';
            $response = $this->custom_response->getErrorResponse($errors, $message);
            return $this->custom_response->sendResponse($response);
        }
    }

    public function getRole(Request $request, $id)
    {
        $role = Role::withTrashed()->where('id', $id)->first();
        $message = 'Success';
        $response  = $this->custom_response->getSuccessResponse($role, $message);
        return $this->custom_response->sendResponse($response);
    }

    public function getAllRoles(Request $request)
    {
        $roles = Role::withTrashed()->get();
        $message = 'Success';
        $response  = $this->custom_response->getSuccessResponse($roles, $message);
        return $this->custom_response->sendResponse($response);
    }

    public function deleteRole(Request $request, $id)
    {
        $role = Role::where('id', $id)->first();
        $role ->delete();
        $message = 'Success';
        $response  = $this->custom_response->getSuccessResponse(null, $message);
        return $this->custom_response->sendResponse($response);
    }
}
