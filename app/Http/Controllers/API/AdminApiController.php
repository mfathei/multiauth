<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Repositories\Repository;
use Illuminate\Http\Request;
use Auth;
use Validator;

class AdminApiController extends ApiController
{
    // Repository
    protected $repo;

    public function __construct(Admin $admin)
    {
        $this->middleware('auth:admin-api')->except(['login', 'register']);
        $this->repo = new Repository($admin);
    }

    protected function guard()
    {
        return Auth::guard('admin-api');
    }

    protected function sessionGuard()
    {
        return Auth::guard('admin');
    }

    public function login()
    {
        if ($this->sessionGuard()->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = $this->sessionGuard()->user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return $this->respond(['success' => $success, 'user' => $user->toArray()]);
        }

        return $this->respondUnauthorized();
    }

    /**
     * Register api
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:admins',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
            'job_title' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->setStatusCode(401)->respondWithErrors($validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = $this->repo->create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return $this->respond(['success' => $success]);
    }

    /**
     * logout api
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function logout()
    {
        $user = $this->guard()->user();
        $user->token()->revoke();
        return $this->respond(['success' => 'You are logged out.']);
    }

    /**
     * details api
     *
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function details()
    {
        $user = $this->guard()->user();
        return $this->respond(['success' => $user]);
    }

}
