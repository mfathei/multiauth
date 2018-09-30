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
        // dd($this->guard());
        if ($this->sessionGuard()->attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = $this->sessionGuard()->user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success, 'user' => $user->toArray()], $this->statusCode);
        }

        return response()->json(['error' => 'Unauthorized.'], 401);
    }

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
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
            // dd('dzfjsd');
            $this->setStatusCode(401)->respondWithErrors($validator->errors());
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = $this->repo->create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        $this->responsd(['success' => $success]);
    }

    /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout()
    {
        $user = $this->guard()->user();
        $user->token()->revoke();
        $this->respond(['success' => 'You are logged out.']);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = $this->guard()->user();
        $this->respond(['success' => $user]);
    }

}
