<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class AdminAuthController extends Controller
{
    public function getLogin()
    {
        $data['login'] = 'post-login-admin';
        return view('auth.login-admin', $data);
    }
    public function postLogin(Request $request)
    {

        if (Auth::guard('admin')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/admin/academic-years');
        } elseif (Auth::guard('student')->attempt([
            'username' => $request->username,
            'password' => $request->password,
        ])
        ) {

            // Authentication passed...
            return redirect('/student/contributions');
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