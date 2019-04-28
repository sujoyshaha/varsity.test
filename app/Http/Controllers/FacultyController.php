<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\AcademicYear;
use App\Department;
use App\Article;
use App\Comment;
use App\Student;
use App\Faculty;
use App\ConPhoto;
use Cookie;
// use App\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
// use App\ConPhoto;
use App\ArtImg;



class FacultyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         // $this->middleware('auth');
        $this->middleware('auth:faculty');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)


    {

         $data['title'] ="Dashboard";

        $user_id = Auth::guard('faculty')->user()->id;
        $dep_id = Auth::guard('faculty')->user()->department_id;


        


         


           

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



    public function facultyProfile()
    {

        $data['title'] ="User Profile";
        //$uid = Auth::user()->id;

        $uid = Auth::guard('faculty')->user()->id;


        $data['user'] =Faculty::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }




  
    public function facupostPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);     
        $uid = Auth::guard('faculty')->user()->id;
        $user = Faculty::findOrFail($uid);

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
      


       public function facuupdateuserProfile(Request $request)
    {



        $this->validate($request,[

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'photo' => 'max:2048',
            
        ]);


        // $user_id = Auth::user()->id;
        $user_id = Auth::guard('faculty')->user()->id;


       
        $myprofile = Faculty::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = Faculty::whereEmail($nemail)->first();

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
$hasPhoto = Faculty::wherePhoto($photo)->first();
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



    public function getFacultyarticles(Request $request)
    {
        $data['title'] = "Article";
        
     
      
        
        // $uay = Cookie::get('uay');
        // $uay = Cookie::get('uay');

        // $data['cns']= Article::orderBy('id','asc')->get();

        $dep_id = Auth::guard('faculty')->user()->department_id;


        $data['cns']= Article::whereDepId($dep_id)->orderBy('id','asc')->get();


        

         $data['acys']= AcademicYear::orderBy('id','asc')->get();

        if ($request->year) {

            $this->validate($request,[
                'year' => 'required|exists:academic_years,year',
            ]);
            // $data['cns']= Article::where('year',$request->year)->orderBy('id','desc')->get();

            $data['cns']= Article::whereDepId($dep_id)->where('year',$request->year)->orderBy('id','asc')->get();
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

   









public function getfacultyArticlePercentage(Request $request)
    {






        $data['title'] = "Number of Articles";

        $dep_id = Auth::guard('faculty')->user()->department_id;

        if ($request->academic_year) {

        $this->validate($request,[
            'academic_year' => 'required|exists:academic_years,id',
        ]);

       // Cookie::queue('uay', $request->academic_year, 300);

         //$uay = $request->academic_year;
        }

        
        $data['rptype'] = 1;



       

        // if ($uay) {
        //     $cay = AcademicYear::findOrFail($uay);
        // }else{
            $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
       // }
        $data['cay'] = $cay;

    

         $data['reps'] = Article::whereDepId($dep_id)->where('year',$cay->year)->get()->groupBy('dep_id');

         $data['withcom'] = Article::whereDepId($dep_id)->whereIn('file_status',[2])->count();
         $data['pending'] = Article::whereDepId($dep_id)->whereIn('file_status',[1])->count();
         $data['accepted'] = Article::whereDepId($dep_id)->whereIn('file_status',[3])->count();
         $data['acceptedcommented'] = Article::whereDepId($dep_id)->whereIn('file_status',[4])->count();


        



        // $reps = Contribution::with('user')->get()->groupBy('user.department_id');
        $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['deps'] = Department::all();
        $data['articles'] = Article::all();


        return view('admin.faculty-percentageof-articles', $data);
    }




public function getfacultyArticleNumbers(Request $request)
    {






        $data['title'] = "Number of Articles";

        $dep_id = Auth::guard('faculty')->user()->department_id;

        if ($request->academic_year) {

        $this->validate($request,[
            'academic_year' => 'required|exists:academic_years,id',
        ]);

       // Cookie::queue('uay', $request->academic_year, 300);

         //$uay = $request->academic_year;
        }

     



       

        // if ($uay) {
        //     $cay = AcademicYear::findOrFail($uay);
        // }else{
            $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
       // }
        $data['cay'] = $cay;

    

         $data['reps'] = Article::whereDepId($dep_id)->where('year',$cay->year)->get()->groupBy('dep_id');

         $data['withcom'] = Article::whereDepId($dep_id)->whereIn('file_status',[2])->count();
         $data['pending'] = Article::whereDepId($dep_id)->whereIn('file_status',[1])->count();
         $data['accepted'] = Article::whereDepId($dep_id)->whereIn('file_status',[3])->count();
         $data['acceptedcommented'] = Article::whereDepId($dep_id)->whereIn('file_status',[4])->count();


        



        // $reps = Contribution::with('user')->get()->groupBy('user.department_id');
        $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['deps'] = Department::all();
        $data['articles'] = Article::all();


        return view('admin.faculty-numberof-articles', $data);
    }







  
  
}
