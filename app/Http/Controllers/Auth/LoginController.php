<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $phone = $request->input('phone');
        $password = $request->input('password');
        // echo $phone;
        // die();
        if ($phone == '' || $password == '') {
            return response()->json([
                'status' => 404,
                'message' => 'Phone / Password is required!',
                'data' => new class{},
            ]);
        }
        
        // $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
            $user = $this->guard()->user();
            $user->generateToken();

            $user = User::findOrFail($user->toArray()['id']);
            $data = new class{};
            $data->user = $user->toArray();

            return response()->json([
                'status' => 200,
                'message' => 'Succesfully Loged In',
                'data' => $data,
            ]);
        }

        return response()->json([
            'status' => 404,
            'message' => 'Wrong Email / Password',
            'data' => new class{},
        ]);

        // return $this->sendFailedLoginResponse($request);
    }

    public function logoutApi(Request $request)
    {
        $data = new class{};

        $data->login_status = 'Logged Out';

        return response()->json(['status' => 200, 'message' => 'User logged out.', 'data' => $data], 200);
    }
}
