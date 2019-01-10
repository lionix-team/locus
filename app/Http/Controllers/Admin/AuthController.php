<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\StatusCodeHelper;
use App\Helpers\TokenHelper;
use App\Http\Resources\UserResource;
use App\Models\UserRole;
use App\Repositories\UserRoleRepository;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Response;

class AuthController extends Controller
{
    private $statusCode;
    private $success;
    private $data;
    private $errors;

    public function __construct()
    {
        $this->statusCode = StatusCodeHelper::HTTP_BAD_REQUEST;
        $this->success = false;
        $this->data = [];
        $this->errors = [];
    }

    /**
     * Login
     *
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        $role = (new UserRoleRepository())->getByName(UserRole::ROLE_ADMIN)->id;
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'role_id' => $role])) {
            $user = Auth::user();
            $this->statusCode = StatusCodeHelper::HTTP_OK;
            $this->success = true;
            $this->data = [
                'user' => new UserResource($user),
                'token_info' => TokenHelper::generateToken($user)
            ];
        } else {
            $this->statusCode = StatusCodeHelper::HTTP_UNAUTHORIZED;
            $this->errors['message'] = 'wrong_credentials';
        }
        return Response::api($this->success, $this->data, $this->errors, $this->statusCode);
    }
}
