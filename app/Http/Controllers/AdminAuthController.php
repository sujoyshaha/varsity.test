<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class AdminAuthController extends Controller
{
    public function getLogin()
    {
        return view('auth.login-admin');
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