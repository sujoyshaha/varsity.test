<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Input as input;

use App\User;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {

        return view('backend.admin-dashboard');
    }


     public function userProfile()
    {

        $data['title'] ="User Profile";
        $uid = Auth::user()->id;
        $data['user'] =User::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }
      

    
    public function postPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);
        $user = User::find(Auth::user()->id);

 if ($user) {


    if (Hash::check(Input::get('passwordold'),$user['password']) && Input::get('password')==Input::get('password_confirmation')) {
            $user->password=bcrypt(Input::get('password'));
            $user->save();

            session()->flash('message', 'Password change Successfully!');
            Session::flash('type', 'success');
            return redirect()->back();

        }
        else{


        session()->flash('message', 'Password not changed!');
        Session::flash('type', 'error');
        return redirect()->back();
    }
           
        }



        
    }
      


       public function updateuserProfile(Request $request)
    {



        $this->validate($request,[

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'photo' => 'max:2048',
            
        ]);


        $user_id = Auth::user()->id;
       
        $myprofile = User::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = User::whereEmail($nemail)->first();

        if ($hasEmail) {
            if ($hasEmail->email == $exemail) {
                # code...
            }else{
                session()->flash('message', 'Email already exist with another user!');
                Session::flash('type', 'error');
                return redirect()->back();
            }
        }else{
            $myprofile['email'] = $request->email;
        }



        if ($request->photo) {

$photoname = pathinfo($request->photo->getClientOriginalName(), PATHINFO_FILENAME);

$photoname = preg_replace('!\s+!', ' ', $photoname);
$photoname = str_replace(' ', '-', $photoname);
$photoname = strtolower($photoname);

$photo = $photoname . '.' . $request->photo->getClientOriginalExtension();

$count = 0;
$photocount = 1;

while ($count < 1) {
$hasPhoto = User::wherePhoto($photo)->first();
if ($hasPhoto) {
$newphotoname = $photoname . '_' . $photocount;
$photo = $newphotoname . '.' . $request->photo->getClientOriginalExtension();
$photocount++;
} else {
$count++;
}
}

$cyr = date("Y");
$cmo = date("m");

$request->photo->move(public_path('upload/' . $cyr . '/' . $cmo), $photo);

$photo = $cyr . '/' . $cmo . '/' . $photo;

$myprofile['photo'] = $photo;
}






















        $email=$request->email;

        // if ($request->email) {
        //     $email= User::whereEmail($request->email)->first();
        // }


        // $em = User::whereEmail($email)->first();

        // if ($em) {
        //     session()->flash('message', 'email are taken!');
        // Session::flash('type', 'success');
        // return redirect()->back();

        // }else{
        //      $myprofile['email'] = $request->email;
        // }

        $myprofile['first_name'] = $request->first_name;
        $myprofile['last_name'] = $request->last_name;
       
       
        $myprofile['phone'] = $request->phone;
        $myprofile['email'] = $request->email;
        //$myprofile['photo'] = $request->photo;
        
            
        $myprofile->save();

        session()->flash('message', 'Your Profile Successfully updated!');
        Session::flash('type', 'success');
        return redirect()->back();

    }


    //     return view('backend.user-profile');
    // }
}
