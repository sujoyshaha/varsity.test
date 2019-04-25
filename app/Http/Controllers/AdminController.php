<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use App\Admin;
use App\AcademicYear;
use App\Department;
use App\Article;
use App\ArtImg;
use App\Student;
use App\ConPhoto;
use App\Comment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('backend.admin-dashboard',['title' => 'Academic Year']);
    }


    public function userProfile()
    {

        $data['title'] ="User Profile";
        //$uid = Auth::user()->id;

        $uid = Auth::guard('admin')->user()->id;


        $data['user'] =Admin::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }


    public function allUsers()
    {
        $data['title'] = "User";
        $data['eroute'] = "edit-user";
        $users = User::paginate(100);
        $data['users'] =$users;
        return view('admin.allusers', $data);
    }
      



    public function addUser()
    {

        $data['title'] ="User Profile";
        $data['dep'] = Department::all();
        //$uid = Auth::user()->id;

        // $uid = Auth::guard('admin')->user()->id;


        // $data['user'] =Admin::findOrFail($uid);
     
        return view('admin.add-user',$data);
    }




      public function postUser( Request $request)
    {
      $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            // 'last_name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'phone' => ['required', 'string'],
            // 'role' => ['required', 'numeric','max:20'],
            // 'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

// 'password' => Hash::make($data['password']),
      

        $adduser['first_name'] = $request->first_name;
        // $adduser['last_name'] = $request->last_name;
        // $adduser['email'] = $request->email;
        // $adduser['phone'] = $request->phone;
        // $adduser['role'] = $request->role;
        // $adduser['password'] = Hash::make($request->password);

        Admin::create($adduser);





        session()->flash('message', 'Admin Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();
    }






    public function addStudent()
    {

        $data['title'] ="User Profile";
       
        //$uid = Auth::user()->id;

        // $uid = Auth::guard('admin')->user()->id;


        // $data['user'] =Admin::findOrFail($uid);
     
        return view('admin.add-user',$data);
    }




      public function postStudent( Request $request)
    {
      $this->validate($request,[
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            // 'email' => 'required|unique:student,email',
           // 'email' => 'required', 'string', 'email',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:student'],

           // 'email' => ['required', 'string', 'email', 'max:255', 'unique:student'],
            'phone' => ['required', 'string'],
          //  'role' => ['required', 'numeric','max:20'],
            'department_id' => 'required|exists:departments,id',
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);


        
// 'password' => Hash::make($data['password']),
      

        $addstudent['first_name'] = $request->first_name;
        $addstudent['last_name'] = $request->last_name;
        $addstudent['email'] = $request->email;
        $addstudent['phone'] = $request->phone;
        $addstudent['department_id'] = $request->department_id;
       // $adduser['role'] = $request->role;
        $addstudent['password'] = Hash::make($request->password);

        Student::create($addstudent);





        session()->flash('message', 'Student Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();
    }


    
    public function postPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);     
        $uid = Auth::guard('admin')->user()->id;
        $user = Admin::findOrFail($uid);

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


        // $user_id = Auth::user()->id;
        $user_id = Auth::guard('admin')->user()->id;


       
        $myprofile = Admin::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = Admin::whereEmail($nemail)->first();

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
$hasPhoto = Admin::wherePhoto($photo)->first();
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

    public function getAcademicYear()
    {
         $data['title'] = "Academic Year";
         $data['eroute'] = "edit-academic-year";
         $data['ays']= AcademicYear::orderBy('id','asc')->get();

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

     public function addAcademicYear()
    {

        $data['title'] ="Add Academic Year";
        //$uid = Auth::user()->id;

        // $uid = Auth::guard('admin')->user()->id;


        // $data['user'] =Admin::findOrFail($uid);
     
        return view('admin.add-academic-year',$data);
    }

      public function editAcademicYear($id)
    {
         $ay= AcademicYear::findOrFail($id);

         return view('admin.edit-academic-year',['title' => 'Update Academic Year', 'ay' => $ay, 'uroute' => 'update-academic-year']);
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
         $data['dps']= Department::orderBy('id','asc')->get();

         return view('admin.department',$data);
    }

   public function addDepartment()
    {

        $data['title'] ="Add Department";
        //$uid = Auth::user()->id;

        // $uid = Auth::guard('admin')->user()->id;


        // $data['user'] =Admin::findOrFail($uid);
     
        return view('admin.add-department',$data);
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















    //  public function getArticle()
    // {
    //      $data['title'] = "Article";
    //      $data['eroute'] = "edit-article";
    //      $data['cns']= Article::orderBy('id','asc')->paginate(10);
    //      $data['acys']= AcademicYear::orderBy('id','asc')->get();

    //      return view('admin.admin-article',$data);
    // }





    public function getArticle(Request $request)
    {
        $data['title'] = "Contribution";
        $data['route'] = "post-contribution";
        $data['eroute'] = "edit-contribution";
        $data['sroute'] = "single-contribution";
        $data['aroute'] = "approve-contribution";
      
        
        // $uay = Cookie::get('uay');
        // $uay = Cookie::get('uay');

        if ($request->year) {

        $this->validate($request,[
            'year' => 'required|exists:academic_years,year',
        ]);

        $nray = AcademicYear::where('year',$request->year)->first();

        // $uay = $nray->id;

        // Cookie::queue('uay', $uay, 300);

         
        }

        $data['cns']= Article::orderBy('id','asc')->get();
        $data['acys'] = AcademicYear::orderBy('id', 'desc')->get();

        // if ($uay) {
        //     $cay = AcademicYear::findOrFail($uay);
        // }else{
        //     $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
        // }


        // $data['cay'] = $cay;
        // $data['cons'] = Contribution::whereAcademicYear($cay->id)->orderBy('id', 'asc')->paginate(10);
        // $data['allcons'] = Contribution::whereAcademicYear($cay->id)->get()->count();
        // $data['comcons'] = Contribution::whereAcademicYear($cay->id)->whereIn('status',[2,4])->count();
        // $data['apvcons'] = Contribution::whereAcademicYear($cay->id)->whereIn('status',[3,4])->count();
        // $data['pencons'] = Contribution::whereAcademicYear($cay->id)->whereNotIn('status',[3,4])->count();





        return view('admin.admin-article', $data);
    }



    // public function getArticle(Request $request)
    // {
    //     $data['title'] = "Article";
    //     $data['route'] = "post-article";
    //     $data['eroute'] = "edit-article";
    //     $data['sroute'] = "single-article";
    //     $data['aroute'] = "approve-article";
      
        
    //     // $uay = Cookie::get('uay');
       

    //     $data['acys'] = AcademicYear::orderBy('id', 'desc')->get();

        
    //     $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
    //     $data['cay'] = $cay;
    //     $data['cns'] = Article::where('year',$cay->year)->orderBy('id', 'asc')->paginate(10);

    //     return view('admin.admin-article', $data);
    // }





 // public function ApproveArticle(Request $request){

 //        $this->validate($request,[
 //            'id' => 'required',
 //            'id.*' => 'numeric|exists:articles,id',
 //        ]);

 //        $ids = $request->id;

 //    foreach ($ids as $id) {
            
       

 //        $con = Article::findOrFail($id);

 //        if ($con->file_status == 1) {
 //            $con->file_status = 3;

 //            $con->save();
 //        }elseif ($con->file_status == 2) {
 //            $con->file_status = 4;
 //            $con->save();
 //        }elseif ($con->file_status == 3 || $con->file_status == 4 ) {
            
 //        }else{
 //        session()->flash('message', ' One or more Contribution is already approved or something went wrong with it!');
 //        Session::flash('type', 'warning');
 //        return redirect()->back();
 //        }

 //    }
 //        session()->flash('message', 'Contribution(s) status Successfully updated!');
 //        Session::flash('type', 'success');
 //        return redirect()->back();
  
 //    }



   


 public function getApproveArticle($id){
        $con = Article::findOrFail($id);

         // 1=Submitted, 2=Commented, 3= Accepted, 4= Accepted + Commented 5= rejected

        if ($con->file_status == 1) {
            $con->file_status = 3;

            $con->save();
        }elseif ($con->file_status == 2) {
            $con->file_status = 4;
            $con->save();
        }else{
        session()->flash('message', 'Article is already approved or something went wrong!');
        Session::flash('type', 'warning');
        return redirect()->back();
        }

        session()->flash('message', 'Article file_status Successfully updated!');
        Session::flash('type', 'success');
        return redirect()->back();
        
    }


    public function postApproveArticles(Request $request){

        $this->validate($request,[
            'id' => 'required',
            'id.*' => 'numeric|exists:contributions,id',
        ]);

        $ids = $request->id;

    foreach ($ids as $id) {
            # code...
       

        $con = Article::findOrFail($id);

        if ($con->file_status == 1) {
            $con->file_status = 3;

            $con->save();
        }elseif ($con->file_status == 2) {
            $con->file_status = 4;
            $con->save();
        }elseif ($con->file_status == 3 || $con->file_status == 4 ) {
            # Do nothing...
        }else{
        session()->flash('message', ' One or more Article is already approved or something went wrong with it!');
        Session::flash('type', 'warning');
        return redirect()->back();
        }

    }
        session()->flash('message', 'Article(s) file_status Successfully updated!');
        Session::flash('type', 'success');
        return redirect()->back();
  
    }




  public function getSingleArticle($id)
    {
        $data['title'] = "Single Article";

        // $data['uroute'] = "update-article";
        $data['route'] = "add-stdcomment";
        $data['eroute'] = "edit-stdarticle";

        // $uid = Auth::user()->id;

        // $data['isDep'] = 2;
        // $data['eroute'] = "edit-academic-year";
        $data['artimgs'] = ArtImg::where('art_id',$id)->get();
        $data['con'] = Article::findOrFail($id);
      
        // $con = Article::findOrFail($id);


        // if ($uid != $con->user_id) {

        // session()->flash('message', "You don't have the required permission to view the requested page!");
        // Session::flash('type', 'danger');
        // return redirect()->back();        
        // }

                 $data['comments'] = Comment::whereArtId($id)->orderBy('id', 'asc')->paginate(10);
                 $data['comcount'] = Comment::whereArtId($id)->count();

       // $con = Article::findOrFail($id);

        // $acyear = AcademicYear::findOrFail($con->academic_year);



        // $con = Article::findOrFail($id);

        // $uid = Auth::user()->id; 

        // if ($uid != $con->user_id) {
        //     session()->flash('message', 'You do not have permission to view this page!');
        //     Session::flash('type', 'error');
        //     return redirect()->route('stdarticles');
        // }
        return view('admin.single-article', $data);
    }




    //    public function postComment($id,Request $request)
    // {


    //     $con = Article::findOrFail($id);
    //     $uid = Auth::guard('admin')->user()->id; 


    //    if ($con->status ==2 || $con->status ==4) {

    //    $this->validate($request,[
    //         'comment' => 'required|string',
    //     ]);


    //     $com['comment'] = $request->comment;
    //     $com['user_id'] = $uid;
    //     $com['user_role'] = 1; // 1=admin, 3=student, 2= coordinator, 4= faculty
    //     $com['art_id'] = $id;

    //     Comment::create($com);

    //     session()->flash('message', 'Comment Successfully Added!');
    //     Session::flash('type', 'success');
    //     return redirect()->back();


    //     }

    //     else{
    //     session()->flash('message', 'You can not interact with a faculty unless it has been commented!');
    //     Session::flash('type', 'warning');

    //     return redirect()->back();
    //    }
    // }









    public function postComment($id,Request $request)
    {


       $con = Article::findOrFail($id);


      $uid = Auth::guard('admin')->user()->id;

       $this->validate($request,[
            'comment' => 'required|string',
        ]);


      $com['comment'] = $request->comment;
        $com['user_id'] = $uid;
        $com['user_role'] = 1; // 1=admin, 3=student, 2= coordinator, 4= faculty
        $com['art_id'] = $id;


        Comment::create($com);


        if ($con->file_status == 1) {
            $con->file_status = 2;

            $con->save();
        }elseif ($con->file_status == 3) {
            $con->file_status = 4;
            $con->save();
        }elseif ($con->file_status == 3 || $con->file_status == 4 ) {
            # Do nothing...
        }else{
        session()->flash('message', 'Something went wrong with your update please contact the server admin!');
        Session::flash('type', 'warning');
        return redirect()->back();
        }

        session()->flash('message', 'Comment Successfully Added!');
        Session::flash('type', 'success');




        return redirect()->back();
    }





    // public function getArticleReport(Request $request)
    // {
    //     $data['title'] = "Number of Contributions";

    //     // $uay = Cookie::get('uay');

    //     if ($request->academic_year) {

    //     $this->validate($request,[
    //         'academic_year' => 'required|exists:academic_years,id',
    //     ]);

    //     // Cookie::queue('uay', $request->academic_year, 300);

    //     //  $uay = $request->academic_year;
    //     }

        
        


       

    //     // if ($uay) {
    //     //     $cay = AcademicYear::findOrFail($uay);
    //     // }else{
    //     //     $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
    //     // }

    //         // $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();

    //     $data['cay'] = $cay;
    //     $data['reps'] = Article::whereYear('id')->get();
    //     // $reps = Contribution::with('user')->get()->groupBy('user.department_id');
    //     $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
    //     $data['deps'] = Department::all();


    //     return view('admin.reports', $data);
    // }













    public function getArticleReport(Request $request)
    {






        $data['title'] = "Number of Contributions";

        //$uay = Cookie::get('uay');

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

          // $data['reps'] = Article::whereAcademicYear($cay->id)->with('user')->get()->groupBy('user.department_id');

         $data['reps'] = Article::where('year',$cay->year)->get()->groupBy('dep_id');


            // $data['reps'] = Article::whereYear('year',$cay->id)->with('student')->get()->groupBy('student.dep_id');

        // DB::table('users')->where('name', 'John')->value('email');

        // $data['reps'] = Article::where('year',$cay->year)->get()->groupBy('student.dep_id');
        
        // dd($data);




        // $reps = Contribution::with('user')->get()->groupBy('user.department_id');
        $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['deps'] = Department::all();


        return view('admin.reports', $data);
    }



    //   public function getContributionPercentage(Request $request)
    // {
        



    //     $data['title'] = "Number of Contributions";

    //     //$uay = Cookie::get('uay');

    //     if ($request->academic_year) {

    //     $this->validate($request,[
    //         'academic_year' => 'required|exists:academic_years,id',
    //     ]);

    //    // Cookie::queue('uay', $request->academic_year, 300);

    //      //$uay = $request->academic_year;
    //     }

        
    //     $data['rptype'] = 1;



       

    //     // if ($uay) {
    //     //     $cay = AcademicYear::findOrFail($uay);
    //     // }else{
    //         $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
    //    // }
    //     $data['cay'] = $cay;

    //       // $data['reps'] = Article::whereAcademicYear($cay->id)->with('user')->get()->groupBy('user.department_id');

    //      $data['reps'] = Article::where('year',$cay->year)->get()->groupBy('dep_id');


    //         // $data['reps'] = Article::whereYear('year',$cay->id)->with('student')->get()->groupBy('student.dep_id');

    //     // DB::table('users')->where('name', 'John')->value('email');

    //     // $data['reps'] = Article::where('year',$cay->year)->get()->groupBy('student.dep_id');
        
    //     // dd($data);




    //     // $reps = Contribution::with('user')->get()->groupBy('user.department_id');
    //     $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();
    //     $data['deps'] = Department::all();


    //     return view('admin.reports', $data);
    // }
}
