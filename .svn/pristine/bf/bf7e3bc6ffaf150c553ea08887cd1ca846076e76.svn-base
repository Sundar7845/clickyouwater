<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginForm()
    {
        return view('login.login');
    }

    public function forgetPassword()
    {
        return view('forget_password');
    }

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'txtMobile'   => 'required',
    //         'txtPassword' => 'required'
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withInput()->withErrors($validator);
    //     }
    //     $user = User::where('mobile', $request->txtMobile)->first();
    //     if (!$user) {
    //         $notification = array(
    //             'message' => 'Invalid credentials or InActive User!',
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    //     if (Auth::attempt([
    //         'mobile' => $request->txtMobile,
    //         'password' => $request->txtPassword
    //     ], $request->get('remember')) && $user->is_active == 1) {

    //         $notification = array(
    //             'message' => 'Logged in successfully',
    //             'alert-type' => 'success'
    //         );
    //         return redirect()->route('dashboard')->with($notification);
    //     } else {
    //         $notification = array(
    //             'message' => 'Invalid credentials or InActive User!',
    //             'alert-type' => 'error'
    //         );
    //         return redirect()->back()->with($notification);
    //     }
    // }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'txtMobile'   => 'required',
                'txtPassword' => 'required'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $credentials = [
                'mobile'   => $request->txtMobile,
                'password' => $request->txtPassword,
                'is_active' => 1
            ];
            if (Auth::attempt($credentials)) {
                $notification = [
                    'message'     => 'Logged in successfully',
                    'alert-type'  => 'success'
                ];
                return redirect()->route('dashboard')->with($notification);
            } else {
                $notification = [
                    'message'     => 'Invalid credentials or inactive user!',
                    'alert-type'  => 'error'
                ];
            }
            return redirect()->back()->with($notification);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }


    public function logout(Request $request)
    {
        try {
            Auth::logout();
            Session::flush();
            $request->session()->invalidate();
            $notification = array(
                'message' => 'Logged Out Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('login')->with($notification);
        } catch (\Exception $e) {
            $this->Log(__FUNCTION__, 'GET', $e->getMessage(), Auth::user()->id, request()->ip(), gethostname());
        }
    }
}
