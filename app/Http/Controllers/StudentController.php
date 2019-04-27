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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
// use App\ConPhoto;
use App\ArtImg;
//use Cookie;
// use App\Auth;




class StudentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         // $this->middleware('auth');
        $this->middleware('auth:student');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)


    {

         $data['title'] ="Dashboard";

        $user_id = Auth::guard('student')->user()->id;
        $dep_id = Auth::guard('student')->user()->department_id;


        


         


           

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
        $data['totalComments'] = Comment::whereIn('user_role',[2,3])->count();
        $data['yourComments'] = Comment::whereUserId($user_id)->whereIn('user_role',[3])->count();

         

        return view('admin.dashboard',$data);
    }


 public function studentProfile()
    {

        $data['title'] ="User Profile";
        //$uid = Auth::user()->id;

        $uid = Auth::guard('student')->user()->id;


        $data['user'] =Student::findOrFail($uid);
     
        return view('backend.user-profile',$data);
    }




  
    public function stdpostPass(Request $request)
    {

        $this->validate($request,[

'password' => ['required', 'string', 'min:6', 'confirmed'],

]);     
        $uid = Auth::guard('student')->user()->id;
        $user = Student::findOrFail($uid);

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
      


       public function stdupdateuserProfile(Request $request)
    {



        $this->validate($request,[

            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string',
            'photo' => 'max:2048',
            
        ]);


        // $user_id = Auth::user()->id;
        $user_id = Auth::guard('student')->user()->id;


       
        $myprofile = Student::findOrFail($user_id);


        //for update email | existing email | 

        $exemail = $myprofile->email;
        $nemail = $request->email;

        $hasEmail = Student::whereEmail($nemail)->first();

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
$hasPhoto = Student::wherePhoto($photo)->first();
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










    public function getAcademicYear()
    {
         $data['title'] = "Academic Year";
         $data['eroute'] = "edit-academic-year";
         $data['ays']= AcademicYear::orderBy('id','asc')->paginate(2);

         return view('admin.academic-year',$data);
    }



    










     public function getArticle()
    {
         $data['title'] = "Article";
         $data['eroute'] = "edit-studentarticle";
         $user_id = Auth::guard('student')->user()->id;
         $dep_id = Auth::guard('student')->user()->department_id;
         // $data['cns']= Article::orderBy('id','asc')->paginate(10);
         $data['acys']= AcademicYear::orderBy('id','asc')->get();

         $data['cns']= Article::whereStdId($user_id)->whereDepId($dep_id)->orderBy('id','asc')->get();
         return view('admin.article',$data);
    }
    public function addArticle()
    {
         $data['title'] = "Article";
         // $data['eroute'] = "edit-studentarticle";
         // $data['cns']= Article::orderBy('id','asc')->paginate(2);
         $data['acys']= AcademicYear::orderBy('id','asc')->get();
         $data['dep'] = Department::orderBy('name','DESC')->get();

         return view('admin.add-article',$data);
    }



    // public function postArticle( Request $request)
    // {
    //   $this->validate($request,[
    //         'title' => 'required',
    //         'year' => 'required|exists:academic_years,year',
    //         'doc' => 'required|file|mimes:doc,docx,pdf|max:5120',
    //         'file' => 'required',
    //         'file.*' => 'image|mimes:jpeg,png,svg,jpg,gif|max:2048',
    //     ]);


    //     $cn['title'] = $request->title;
    //     $cn['year'] = $request->year;
    //     $cn['file_name'] = $request->doc->getClientOriginalName();
    //     $request->doc->store('public/upload');
    //     // $cn['std_id'] = $request->title;

    //     $files = $request->file('file');

    //     $cn = Article::create($cn);
    //     $lcn = $cn->id;

    //     foreach ($files as $file) {
    //          $img['con_id'] = $lcn;
    //          $img['name'] = $file->getClientOriginalName();
    //          $file->store('public/upload');
    //            ConPhoto::create($img);
    //      } 

      





    //     session()->flash('message', 'Article Successfully Added!');
    //     Session::flash('type', 'success');
    //     return redirect()->back();
    // }

    // //   public function editArticle($id)
    // // {
    // //      $data['title'] = "Update Article";
    // //      $data['uroute'] = "update-article";
    // //      $data['cn']= Article::findOrFail($id);
    // //        $data['acys']= AcademicYear::orderBy('id','asc')->get();

    // //      return view('admin.edit-article',$data);
    // // }


    // //   public function editArticle($id)
    // // {
    // //      $data['title'] = "Update Article";
    // //      $data['uroute'] = "update-article";
    // //      $data['cn']= Article::findOrFail($id);
    // //        $data['acys']= AcademicYear::orderBy('id','asc')->get();

    // //      return view('admin.edit-article',$data);
    // // }


    public function postArticle(Request $request)
    {
        $data['title'] = "Article";
        //$data['eroute'] = "edit-article";

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'year' => 'required',
            'doc' => 'required|file|mimes:doc,docx,pdf|max:5120',
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($diff."<br>".$cdiff."<br>".$fdiff);

        $acyear = AcademicYear::where($request->year);

        // $ct = Carbon::today();
        // // $cn = Carbon::now();

        //     $diff = $ct->diffInDays($acyear->opening_date, false);


        //     // dd($diff);

        //     if ($diff > 0) {
        //     session()->flash('message', 'You can not submit before the Starting date of the academic year!');
        //     Session::flash('type', 'error');
        //     return redirect()->back();
        //     }


        //     $cdiff = $ct->diffInDays($acyear->closing_date, false);


        //     // dd($cdiff."<br>".$ct."<br>".$cn);

        //     if ($cdiff < 0) {
        //     session()->flash('message', 'You can not submit after the Closing date of the academic year!');
        //     Session::flash('type', 'error');
        //     return redirect()->back();
        //     }


        $con['title'] = $request->title;
        $con['year'] = $request->year;
        $con['dep_id'] = Auth::guard('student')->user()->department_id;
        $con['std_id'] = Auth::guard('student')->user()->id;

     if ($request->doc) {
         $cyr = date("Y");
         $cmo = date("m");

         $con['file_name'] = $cyr . '/' . $cmo . '/' .$request->doc->getClientOriginalName();
         $request->doc->store('public/upload');

        $docname = pathinfo($request->doc->getClientOriginalName(), PATHINFO_FILENAME);

        $docname = preg_replace('!\s+!', ' ', $docname);
        $docname = str_replace(' ', '-', $docname);
        $docname = strtolower($docname);

        $doc = $docname . '.' . $request->doc->getClientOriginalExtension();

// $count = 0;
// $doccount = 1;

// while ($count < 1) {
// $hasPhoto = Article::wherePhoto($doc)->first();
// if ($hasPhoto) {
// $newdocname = $docname . '_' . $doccount;
// $doc = $newdocname . '.' . $request->doc->getClientOriginalExtension();
// $doccount++;
// } else {
// $count++;
// }
// }
$request->doc->move(public_path('upload/' . $cyr . '/' . $cmo), $doc);

$doc = $cyr . '/' . $cmo . '/' . $doc;

$img['doc'] = $doc;
}








        $files = $request->file('file');



        $con = Article::create($con);

        $lcon = $con->id;

        foreach ($files as $file) {

            $img['art_id'] = $lcon;
            $img['photo'] = $file->getClientOriginalName();
            // $file->store('public/upload');

     if ($file) {

$photoname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

$photoname = preg_replace('!\s+!', ' ', $photoname);
$photoname = str_replace(' ', '-', $photoname);
$photoname = strtolower($photoname);

$photo = $photoname . '.' . $file->getClientOriginalExtension();

$count = 0;
$photocount = 1;

while ($count < 1) {
$hasPhoto = ArtImg::wherePhoto($photo)->first();
if ($hasPhoto) {
$newphotoname = $photoname . '_' . $photocount;
$photo = $newphotoname . '.' . $file->getClientOriginalExtension();
$photocount++;
} else {
$count++;
}
}

$cyr = date("Y");
$cmo = date("m");

$file->move(public_path('upload/' . $cyr . '/' . $cmo), $photo);

$photo = $cyr . '/' . $cmo . '/' . $photo;

$img['photo'] = $photo;
}


            ArtImg::create($img);
           
        }

        

        session()->flash('message', 'Article Created  Successfully :)');
        Session::flash('type', 'success');
        return redirect()->back();
    }



 public function editArticle($id)

    {
        $data['title'] = "Article";

        //$data['uroute'] = "update-stdarticle";
        // $data['route'] = "stdarticles";

        $data['isDep'] = 2;
        // $data['eroute'] = "edit-academic-year";

        

        $data['ay'] = Article::findOrFail($id);

       $con = Article::findOrFail($id);

     //  $uid = Auth::student()->id; 

       // $uid = Auth::guard('student')->user()->id;

       //  if ($uid != $con->std_id) {
       //      session()->flash('message', 'You do not have permission to view this page!');
       //      Session::flash('type', 'error');
       //      return redirect()->route('studentarticles');
       //  }

        $acyear = AcademicYear::where('year',$con->year)->first();

        $ct = Carbon::today();
        // $cn = Carbon::now();


            $odiff = $ct->diffInDays($acyear->opening_date, false);


            // dd($diff);

            if ($odiff > 0) {
            session()->flash('message', 'Submission or edit can not perform before the Opening date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $diff = $ct->diffInDays($acyear->final_date, false);


            // dd($diff);

            if ($diff < 0) {
            session()->flash('message', 'Edit can not perform after Final Submission date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->route('studentarticles');
            }


        $con = Article::findOrFail($id);

        


        $data['acys'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['cn'] = $con;



        return view('admin.edit-article', $data);
    }












    //  public function updateArticle($id, Request $request)
    // {

    //     $this->validate($request,[
    //        'name' => 'required|string',
    //     ]);

    //       $dp= Department::findOrFail($id);

    //       $dp['name']= $request->name;


           

    //     $dp->save();


    //     session()->flash('message', 'Academic Year Successfully updated!');
    //     Session::flash('type', 'success');
    //     return redirect()->back();
    // }


 public function updateArticle($id, Request $request)
    {
        $data['title'] = "Article";
        // $data['eroute'] = "edit-article";

        $this->validate($request,[
            'title' => 'required|string|max:255',
            //'year' => 'required|exists:academic_years,id',
            'doc' => 'file|mimes:doc,docx,pdf|max:5120',
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($diff."<br>".$cdiff."<br>".$fdiff);
        $con = Article::findOrFail($id);

       $uid = Auth::guard('student')->user()->id;

        // if ($uid != $con->user_id) {
        //    session()->flash('message', 'You do not have permission to view this page!');
        //     Session::flash('type', 'error');
        //     return redirect()->route('studentarticles');
        // }

        

        $acyear = AcademicYear::where('year',$con->year)->first();

        $ct = Carbon::today();
        // $cn = Carbon::now();

        // dd($acyear);

            $odiff = $ct->diffInDays($acyear->opening_date, false);


            // dd($diff);

            if ($odiff > 0) {
            session()->flash('message', 'Submission or edit can not perform before the Opening date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $diff = $ct->diffInDays($acyear->final_date, false);


            // dd($diff);

            if ($diff < 0) {
            session()->flash('message', 'Edit can not perform after Final Submission date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->route('studentarticles');
            }


        $con['title'] = $request->title;
        // $con['year'] = $request->academic_year;
        // $con['user_id'] = Auth::user()->id;


            if ($request->doc) {
         $cyr = date("Y");
         $cmo = date("m");

         $con['file_name'] = $cyr . '/' . $cmo . '/' .$request->doc->getClientOriginalName();
         $request->doc->store('public/upload');

        $docname = pathinfo($request->doc->getClientOriginalName(), PATHINFO_FILENAME);

        $docname = preg_replace('!\s+!', ' ', $docname);
        $docname = str_replace(' ', '-', $docname);
        $docname = strtolower($docname);

        $doc = $docname . '.' . $request->doc->getClientOriginalExtension();

// $count = 0;
// $doccount = 1;

// while ($count < 1) {
// $hasPhoto = Article::wherePhoto($doc)->first();
// if ($hasPhoto) {
// $newdocname = $docname . '_' . $doccount;
// $doc = $newdocname . '.' . $request->doc->getClientOriginalExtension();
// $doccount++;
// } else {
// $count++;
// }
// }
$request->doc->move(public_path('upload/' . $cyr . '/' . $cmo), $doc);

$doc = $cyr . '/' . $cmo . '/' . $doc;

$img['doc'] = $doc;
}








        $files = $request->file('file');



        $con->save();

        $lcon = $con->id;

        foreach ($files as $file) {

            $img['art_id'] = $lcon;
            $img['photo'] = $file->getClientOriginalName();
            // $file->store('public/upload');

     if ($file) {

$photoname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

$photoname = preg_replace('!\s+!', ' ', $photoname);
$photoname = str_replace(' ', '-', $photoname);
$photoname = strtolower($photoname);

$photo = $photoname . '.' . $file->getClientOriginalExtension();

$count = 0;
$photocount = 1;

while ($count < 1) {
$hasPhoto = ArtImg::wherePhoto($photo)->first();
if ($hasPhoto) {
$newphotoname = $photoname . '_' . $photocount;
$photo = $newphotoname . '.' . $file->getClientOriginalExtension();
$photocount++;
} else {
$count++;
}
}

$cyr = date("Y");
$cmo = date("m");

$file->move(public_path('upload/' . $cyr . '/' . $cmo), $photo);

$photo = $cyr . '/' . $cmo . '/' . $photo;

$img['photo'] = $photo;
}


            ArtImg::create($img);
           
        }






        

        session()->flash('message', 'Article  Updated Successfully :)');
        Session::flash('type', 'success');
        return redirect()->back();
    }


    //    public function getSingleArticle($id)
    // {
    //     $data['title'] = "Single Article";

    //     // $data['uroute'] = "update-article";
    //     $data['route'] = "add-stdcomment";
    //     $data['eroute'] = "edit-stdarticle";

    //     // $uid = Auth::user()->id;

    //     // $data['isDep'] = 2;
    //     // $data['eroute'] = "edit-academic-year";
    //     $data['artimgs'] = ArtImg::where('art_id',$id)->get();
    //     $data['con'] = Article::findOrFail($id);
      
    //     // $con = Article::findOrFail($id);


    //     // if ($uid != $con->user_id) {

    //     // session()->flash('message', "You don't have the required permission to view the requested page!");
    //     // Session::flash('type', 'danger');
    //     // return redirect()->back();        
    //     // }

    //             //  $data['comments'] = Comment::whereConId($id)->orderBy('id', 'asc')->paginate(10);
    //             //  $data['comcount'] = Comment::whereConId($id)->count();

    //    // $con = Article::findOrFail($id);

    //     // $acyear = AcademicYear::findOrFail($con->academic_year);



    //     // $con = Article::findOrFail($id);

    //     // $uid = Auth::user()->id; 

    //     // if ($uid != $con->user_id) {
    //     //     session()->flash('message', 'You do not have permission to view this page!');
    //     //     Session::flash('type', 'error');
    //     //     return redirect()->route('stdarticles');
    //     // }
    //     return view('admin.single-article', $data);
    // }






 public function getSingleArticle($id)
    {
        $data['title'] = "Single Article";

        // $data['uroute'] = "update-contribution";
        $data['route'] = "add-stdcomment";
        $data['eroute'] = "edit-stdcontribution";

                //$uid = Auth::user()->id;

        $data['artimgs'] = ArtImg::where('art_id',$id)->get();
        $data['con'] = Article::findOrFail($id);

        // $data['isDep'] = 2;
        // $data['eroute'] = "edit-academic-year";
                // $data['con'] = Contribution::findOrFail($id);
                // $cons = Contribution::findOrFail($id);


                // if ($uid != $cons->user_id) {

                // session()->flash('message', "You don't have the required permission to view the requested page!");
                // Session::flash('type', 'danger');
                // return redirect()->back();        
                // }

                        $data['comments'] = Comment::whereArtId($id)->orderBy('id', 'asc')->paginate(10);
                        $data['comcount'] = Comment::whereArtId($id)->count();

       // $con = Contribution::findOrFail($id);

        // $acyear = AcademicYear::findOrFail($con->academic_year);



        $con = Article::findOrFail($id);

        // $uid = Auth::user()->id; 

        // if ($uid != $con->user_id) {
        //     session()->flash('message', 'You do not have permission to view this page!');
        //     Session::flash('type', 'error');
        //     return redirect()->route('stdcontributions');
        // }





        return view('admin.single-article', $data);
    }




    public function postComment($id,Request $request)
    {


        $con = Article::findOrFail($id);
        $uid = Auth::guard('student')->user()->id; 


       if ($con->file_status ==2 || $con->file_status ==4) {

       $this->validate($request,[
            'comment' => 'required|string',
        ]);


        $com['comment'] = $request->comment;
        $com['user_id'] = $uid;
        $com['user_role'] = 3; // 1=admin, 3=student, 2= coordinator, 4= faculty
        $com['art_id'] = $id;

        Comment::create($com);

        session()->flash('message', 'Comment Cdded Successfully :)');
        Session::flash('type', 'success');
        return redirect()->back();


        }

        else{
        session()->flash('message', 'Comment can not be posted until a faculty post a comment');
        Session::flash('type', 'warning');

        return redirect()->back();
       }
    }



 // public function postComment($id,Request $request)
 //    {


 //       $con = Article::findOrFail($id);

 //       $uid = Auth::guard('student')->user()->id; 


 //       if ($uid != $con->std_id) {

 //        session()->flash('message', "You don't have the required permission to view the requested page!");
 //        Session::flash('type', 'danger');
 //        return redirect()->back();        
 //        }

 //       if ($con->status ==2 || $con->status ==4) {

 //       $this->validate($request,[
 //            'comment' => 'required|string',
 //        ]);


 //        $com['comment'] = $request->comment;
 //        $com['user_id'] = $uid;
 //        $com['user_role'] = 3; // 1=admin, 3=student, 2= coordinator, 4= faculty
 //        $com['art_id'] = $id;

 //        Comment::create($com);

 //        session()->flash('message', 'Comment Successfully Added!');
 //        Session::flash('type', 'success');




 //        return redirect()->back();


 //        }else{
 //        session()->flash('message', 'You can not interact with a faculty unless it has been commented!');
 //        Session::flash('type', 'warning');

 //        return redirect()->back();
 //       }
 //    }





//     public function addStudent()
//     {

//         $data['title'] ="User Profile";
//         //$uid = Auth::user()->id;

//         // $uid = Auth::guard('admin')->user()->id;


//         // $data['user'] =Admin::findOrFail($uid);
     
//         return view('admin.add-user',$data);
//     }




//       public function postStudent( Request $request)
//     {
//       $this->validate($request,[
//             'first_name' => ['required', 'string', 'max:255'],
//             // 'last_name' => ['required', 'string', 'max:255'],
//             // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//             // 'phone' => ['required', 'string'],
//             // 'role' => ['required', 'numeric','max:20'],
//             // 'password' => ['required', 'string', 'min:6', 'confirmed'],
//         ]);


        
// // 'password' => Hash::make($data['password']),
      

//         $addstudent['first_name'] = $request->first_name;
//         // $adduser['last_name'] = $request->last_name;
//         // $adduser['email'] = $request->email;
//         // $adduser['phone'] = $request->phone;
//         // $adduser['role'] = $request->role;
//         // $adduser['password'] = Hash::make($request->password);

//         Student::create($addstudent);





//         session()->flash('message', 'Student Successfully Added!');
//         Session::flash('type', 'success');
//         return redirect()->back();
//     }

}
