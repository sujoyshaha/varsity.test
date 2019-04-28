<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\AcademicYear;
use App\Department;
use App\Comment;
use App\Contribution;
use App\Student;
use App\Manager;
use App\ConPhoto;
use App\Article;
use Cookie;
use Zip;
// use App\Auth;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
// use App\ConPhoto;
use App\ArtImg;



class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         // $this->middleware('auth');
        $this->middleware('auth:manager');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)


    {

         $data['title'] ="Dashboard";

        $user_id = Auth::guard('manager')->user()->id;
        $dep_id = Auth::guard('manager')->user()->department_id;


        


         


           

        if ($request->academic_year) {

        $this->validate($request,[
            'year' => 'required|exists:academic_years,year',
        ]);

       
        }
       
            $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
        
        
      
        $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['deps'] = Department::all();
        // $data['cons'] = Contribution::whereStatus(1)->orderBy('id', 'asc')->paginate(10);
        // $data['allcons'] = Article::whereYear($cay->id)->get()->count();
        $data['withcom'] = Article::whereDepId($dep_id)->whereIn('file_status',[2,4])->count();

// $data['cns']= Article::whereDepId($dep_id)->orderBy('id','asc')->get();


        $data['nocom'] = Article::whereDepId($dep_id)->whereIn('file_status',[1,3])->count();

        
        // $data['nocoms'] = Article::whereYear($cay->id)->whereNotIn('status',[2,4])->where('created_at', '<=', Carbon::now()->subDays(14)->toDateTimeString())->count();





        $data['totalArticles'] = Article::whereDepId($dep_id)->count();
        $data['totalDepartments'] = Department::all()->count();
        $data['totalStudents'] = Student::whereDepartmentId($dep_id)->count();
        $data['totalComments'] = Comment::whereIn('user_role',[2])->count();
        $data['yourComments'] = Comment::whereUserId($user_id)->whereIn('user_role',[2])->count();

         

        return view('admin.dashboard',$data);
    }


    public function managerProfile()
    {

        $data['title'] ="User Profile";
        //$uid = Auth::user()->id;

        $uid = Auth::guard('manager')->user()->id;


        $data['user'] =Manager::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }




  
    public function manapostPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);     
        $uid = Auth::guard('manager')->user()->id;
        $user = Manager::findOrFail($uid);

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
      


       public function manaupdateuserProfile(Request $request)
    {



        $this->validate($request,[

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'photo' => 'max:2048',
            
        ]);


        // $user_id = Auth::user()->id;
        $user_id = Auth::guard('manager')->user()->id;


       
        $myprofile = Manager::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = Manager::whereEmail($nemail)->first();

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
$hasPhoto = Manager::wherePhoto($photo)->first();
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






  
    public function getManagerArticles(Request $request)
    {
        $data['title'] = "Article";
        
     
      
        
        // $uay = Cookie::get('uay');
        // $uay = Cookie::get('uay');

        // $data['cns']= Article::orderBy('id','asc')->get();

        $dep_id = Auth::guard('manager')->user()->department_id;


        $data['cns']= Article::orderBy('id','asc')->get();


        

         $data['acys']= AcademicYear::orderBy('id','asc')->get();

        if ($request->year) {

            $this->validate($request,[
                'year' => 'required|exists:academic_years,year',
            ]);
            // $data['cns']= Article::where('year',$request->year)->orderBy('id','desc')->get();

            $data['cns']= Article::where('year',$request->year)->orderBy('id','asc')->get();
             $data['selectedYear'] = $request->year;
        }



        
        // $data['acys'] = AcademicYear::orderBy('id', 'desc')->get();
       


        return view('admin.admin-article', $data);
    }




 public function getSingleArticle($id)
    {
        $data['title'] = "Single Article";

        // $data['uroute'] = "update-article";
        $data['route'] = "add-stdcomment";
        $data['eroute'] = "edit-stdarticle";

        $data['artimgs'] = ArtImg::where('art_id',$id)->get();
        $data['con'] = Article::findOrFail($id);
      
        

                 $data['comments'] = Comment::whereArtId($id)->orderBy('id', 'asc')->paginate(10);
                 $data['comcount'] = Comment::whereArtId($id)->count();

      
        return view('admin.single-article', $data);
    }






    public function getAcademicYear()
    {
         $data['title'] = "Academic Year";
         $data['eroute'] = "edit-academic-year";
         $data['ays']= AcademicYear::orderBy('id','asc')->paginate(2);

         return view('admin.academic-year',$data);
    }



    public function postAcademicYear( Request $request)
    {
      $this->validate($request,[
            'year' => 'required|numeric|max:2999|min:2019',
            'opening_date' => 'required|date',
            'closing_date' => 'required|date',
            'final_date' => 'required|date',
        ]);


        $cartd = Carbon::today();

        $differ = $cartd->diffInDays($request->opening_date, false);

        if ($differ < 0) {
        session()->flash('message', 'Start time can not be older than today!');
        Session::flash('type', 'error');
        return redirect()->back();
        }

        $od=Carbon::parse($request->opening_date);
        $cdiff = $od->diffInDays($request->closing_date, false);

        if ($cdiff < 1) {
        session()->flash('message', 'The closing date can not be older than opening date!');
        Session::flash('type', 'error');
        return redirect()->back();
        }

        $cd=Carbon::parse($request->closing_date);
        $fdiff = $cd->diffInDays($request->final_date, false);

        if ($fdiff < 1) {
        session()->flash('message', 'The final date can not be older than closing date!');
        Session::flash('type', 'error');
        return redirect()->back();
        }

        // dd($differ."<br>".$cdiff."<br>".$fdiff);

        $add['year'] = $request->year;
        $add['opening_date'] = $request->opening_date;
        $add['closing_date'] = $request->closing_date;
        $add['final_date'] = $request->final_date;

        AcademicYear::create($add);





        session()->flash('message', 'Academic Year Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();
    }

      public function editAcademicYear($id)
    {
         $data['title'] = "Update Academic Year";
         $data['uroute'] = "update-academic-year";
         $data['ay']= AcademicYear::findOrFail($id);

         return view('admin.edit-academic-year',$data);
    }


     public function updateAcademicYear($id, Request $request)
    {

        $this->validate($request,[
            'year' => 'required|numeric|max:2999|min:2019',
            'opening_date' => 'required|date',
            'closing_date' => 'required|date',
            'final_date' => 'required|date',
        ]);

          $acayear= AcademicYear::findOrFail($id);


           $cartd = Carbon::today();

                  if ($acayear->opening_date !=$request->opening_date) {
            $differ = $cartd->diffInDays($request->opening_date, false);

            if ($differ < 0) {
            session()->flash('message', 'Starting date can not be changed to older dates!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $od=Carbon::parse($request->opening_date);
            $cdiff = $od->diffInDays($request->closing_date, false);

            if ($cdiff < 1 && $acayear->closing_date ==$request->closing_date) {
            session()->flash('message', 'Opening date can not be later than the closing date!');
            Session::flash('type', 'error');
            return redirect()->back();
            }
            }


            if ($acayear->closing_date !=$request->closing_date) {
            $od=Carbon::parse($request->opening_date);
            $cdiff = $od->diffInDays($request->closing_date, false);

            if ($cdiff < 1) {
            session()->flash('message', 'Closing date can not be changed to older dates!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $cd=Carbon::parse($request->closing_date);
            $fdiff = $cd->diffInDays($acayear->final_date, false);

            if ($fdiff < 1 && $acayear->final_date == $request->final_date) {
            session()->flash('message', 'The Closing date can not be changed to later than the final date!');
            Session::flash('type', 'error');
            return redirect()->back();
            }
            }

            if ($acayear->final_date !=$request->final_date) {
            $cd=Carbon::parse($request->closing_date);
            $fdiff = $cd->diffInDays($request->final_date, false);

            if ($fdiff < 1) {
            session()->flash('message', 'The final date can not be changed to older dates!');
            Session::flash('type', 'error');
            return redirect()->back();
            }
            }


        $acayear['year'] = $request->year;
        $acayear['opening_date'] = $request->opening_date;
        $acayear['closing_date'] = $request->closing_date;
        $acayear['final_date'] = $request->final_date;

        $acayear->save();


        session()->flash('message', 'Academic Year Successfully updated!');
        Session::flash('type', 'success');
        return redirect()->back();
    }





    public function getDepartment()
    {
         $data['title'] = "Departments";
         $data['eroute'] = "edit-department";
         $data['dps']= Department::orderBy('id','asc')->paginate(2);

         return view('admin.department',$data);
    }



    public function postDepartment( Request $request)
    {
      $this->validate($request,[
            'name' => 'required',
        ]);


        $adp['name'] = $request->name;

        Department::create($adp);





        session()->flash('message', 'Department Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();
    }

      public function editDepartment($id)
    {
         $data['title'] = "Update Department";
         $data['uroute'] = "update-department";
         $data['dp']= Department::findOrFail($id);

         return view('admin.edit-department',$data);
    }


     public function updateDepartment($id, Request $request)
    {

        $this->validate($request,[
           'name' => 'required|string',
        ]);

          $dp= Department::findOrFail($id);

          $dp['name']= $request->name;


           

        $dp->save();


        session()->flash('message', 'Academic Year Successfully updated!');
        Session::flash('type', 'success');
        return redirect()->back();
    }















     public function getContribution()
    {
         $data['title'] = "Contribution";
         $data['eroute'] = "edit-contribution";
         $data['cns']= Contribution::orderBy('id','asc')->paginate(2);
         $data['acys']= AcademicYear::orderBy('id','asc')->get();

         return view('admin.contribution',$data);
    }



    public function postContribution( Request $request)
    {
      $this->validate($request,[
            'title' => 'required',
            'year' => 'required|exists:academic_years,year',
            'doc' => 'required|file|mimes:doc,docx,pdf|max:5120',
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,svg,jpg,gif|max:2048',
        ]);


        $cn['title'] = $request->title;
        $cn['year'] = $request->year;
        $cn['file_name'] = $request->doc->getClientOriginalName();
        $request->doc->store('public/upload');
        // $cn['mana_id'] = $request->title;

        $files = $request->file('file');

        $cn = Contribution::create($cn);
        $lcn = $cn->id;

        foreach ($files as $file) {
             $img['con_id'] = $lcn;
             $img['name'] = $file->getClientOriginalName();
             $file->store('public/upload');
               ConPhoto::create($img);
         } 

      





        session()->flash('message', 'Contribution Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();
    }

      public function editContribution($id)
    {
         $data['title'] = "Update Contribution";
         $data['uroute'] = "update-contribution";
         $data['cn']= Contribution::findOrFail($id);
           $data['acys']= AcademicYear::orderBy('id','asc')->get();

         return view('admin.edit-contribution',$data);
    }


     public function updateContribution($id, Request $request)
    {

        // $this->validate($request,[
        //    'name' => 'required|string',
        // ]);

        //   $dp= Department::findOrFail($id);

        //   $dp['name']= $request->name;


           

        // $dp->save();


        // session()->flash('message', 'Academic Year Successfully updated!');
        // Session::flash('type', 'success');
        // return redirect()->back();
    }
}
