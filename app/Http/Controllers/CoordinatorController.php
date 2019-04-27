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
use App\Manager;
use App\Coordinator;
use App\Faculty;
use App\ConPhoto;
use App\Comment;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;




class CoordinatorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         // $this->middleware('auth');
        $this->middleware('auth:coordinator');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)


    {

         $data['title'] ="Dashboard";

        $user_id = Auth::guard('coordinator')->user()->id;
        $dep_id = Auth::guard('coordinator')->user()->department_id;


        


         


           

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




public function coordinatorProfile()
    {

        $data['title'] ="User Profile";
        //$uid = Auth::user()->id;

        $uid = Auth::guard('coordinator')->user()->id;


        $data['user'] =Coordinator::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }




  
    public function cordpostPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);     
        $uid = Auth::guard('coordinator')->user()->id;
        $user = Coordinator::findOrFail($uid);

 if ($user) {


    if (Hash::check(Input::get('passwordold'),$user['password']) && Input::get('password')==Input::get('password_confirmation')) {
            $user->password=bcrypt(Input::get('password'));
            $user->save();

            session()->flash('message', 'Password Successfully Changed :');
            Session::flash('type', 'success');
            return redirect()->back();

        }
        else{


        session()->flash('message', 'Password Changes Unsuccessful :(');
        Session::flash('type', 'error');
        return redirect()->back();
    }
           
        }



        
    }
      


       public function cordupdateuserProfile(Request $request)
    {



        $this->validate($request,[

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'photo' => 'max:2048',
            
        ]);


        // $user_id = Auth::user()->id;
        $user_id = Auth::guard('coordinator')->user()->id;


       
        $myprofile = Coordinator::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = Coordinator::whereEmail($nemail)->first();

        if ($hasEmail) {
            if ($hasEmail->email == $exemail) {
                # code...
            }else{
                session()->flash('message', 'Email exists with another user!');
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
$hasPhoto = Coordinator::wherePhoto($photo)->first();
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

        session()->flash('message', 'Profile Updated Successfully :)');
        Session::flash('type', 'success');
        return redirect()->back();

    }

















    //  public function getCordarticle()
    // {
    //      $data['title'] = "Article";
    //      $data['eroute'] = "edit-studentarticle";
    //     // $user_id = Auth::guard('student')->user()->id;
    //      $dep_id = Auth::guard('coordinator')->user()->department_id;
    //      // $data['cns']= Article::orderBy('id','asc')->paginate(10);
    //      $data['acys']= AcademicYear::orderBy('id','asc')->get();

    //      $data['cns']= Article::whereDepId($dep_id)->orderBy('id','asc')->get();
    //      return view('admin.cord-article',$data);
    // }



   public function getCordarticle(Request $request)
    {
        $data['title'] = "Article";
        
     
      
        
        // $uay = Cookie::get('uay');
        // $uay = Cookie::get('uay');

        // $data['cns']= Article::orderBy('id','asc')->get();

        $dep_id = Auth::guard('coordinator')->user()->department_id;


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
        session()->flash('message', 'This Article already approved!');
        Session::flash('type', 'warning');
        return redirect()->back();
        }

        session()->flash('message', 'Article Status  updated Successfully :)');
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

        $data['artimgs'] = ArtImg::where('art_id',$id)->get();
        $data['con'] = Article::findOrFail($id);
      
        

                 $data['comments'] = Comment::whereArtId($id)->orderBy('id', 'asc')->paginate(10);
                 $data['comcount'] = Comment::whereArtId($id)->count();

      
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


      $uid = Auth::guard('coordinator')->user()->id;

       $this->validate($request,[
            'comment' => 'required|string',
        ]);


      $com['comment'] = $request->comment;
        $com['user_id'] = $uid;
        $com['user_role'] = 2; // 1=admin, 3=student, 2= coordinator, 4= faculty
        $com['art_id'] = $id;


        Comment::create($com);


        if ($con->file_status == 1) {
            $con->file_status = 2;

            $con->save();
        }elseif ($con->file_status == 3) {
            $con->file_status = 4;
            $con->save();
        }elseif ($con->file_status == 2 || $con->file_status == 4 ) {
            
        }else{
        session()->flash('message', 'Something happened wrong!');
        Session::flash('type', 'warning');
        return redirect()->back();
        }

        session()->flash('message', 'Comment  Created Successfully :)');
        Session::flash('type', 'success');




        return redirect()->back();
    }



















}
