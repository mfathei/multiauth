<?php

namespace App\Http\Controllers\API;

use App\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;
use Validator;

class AdminApiController extends Controller
{

    public $successStatus = 200;

    public function __construct()
    {
        $this->middleware('auth:admin-api')->except(['login', 'register']);
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
            return response()->json(['success' => $success, 'user' => $user->toArray()], $this->successStatus);
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
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = Admin::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['success' => $success], $this->successStatus);
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = $this->guard()->user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
