<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class UserAuthController extends Controller
{
    public function getLogin()
    {
        $data['login'] = 'post-student-login';
        return view('auth.login-admin', $data);
    }
    public function postLogin(Request $request)
    {

        if (Auth::guard('student')->attempt([
            'email' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/student/contributions');
        }

        if (Auth::guard('coordinator')->attempt([
            'email' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/coordinator/contributions');
        }

        if (Auth::guard('manager')->attempt([
            'email' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/manager/contributions');
        }

        if (Auth::guard('faculty')->attempt([
            'email' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/faculty/contributions');
        }

        if (Auth::guard('admin')->attempt([
            'email' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/admin/academic-years');
        }

        $request->session()->flash('message', 'Login incorrect!');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        session()->flash('message', 'Just Logged Out!');
        return redirect('/');
    }



}