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
    public function index()
    {
        $data['title'] = "Academic Year";
        return view('backend.admin-dashboard',$data);
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















     public function getArticle()
    {
         $data['title'] = "Article";
         $data['eroute'] = "edit-studentarticle";
         $data['cns']= Article::orderBy('id','asc')->get();
         // $data['cns']= Article::orderBy('id','asc')->paginate(10);
         $data['acys']= AcademicYear::orderBy('id','asc')->get();

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
        $con['dep_id'] = $request->department;
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

        

        session()->flash('message', 'Article Successfully Added!');
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
            session()->flash('message', 'You can not submit or edit before the Starting date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $diff = $ct->diffInDays($acyear->final_date, false);


            // dd($diff);

            if ($diff < 0) {
            session()->flash('message', 'You can not edit after Final Submission date of the academic year!');
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
            session()->flash('message', 'You can not submit or edit before the Starting date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->back();
            }

            $diff = $ct->diffInDays($acyear->final_date, false);


            // dd($diff);

            if ($diff < 0) {
            session()->flash('message', 'You can not edit after the Final Submission date of the academic year!');
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






        

        session()->flash('message', 'Article Successfully Updated!');
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


       if ($con->status ==2 || $con->status ==4) {

       $this->validate($request,[
            'comment' => 'required|string',
        ]);


        $com['comment'] = $request->comment;
        $com['user_id'] = $uid;
        $com['user_role'] = 3; // 1=admin, 3=student, 2= coordinator, 4= faculty
        $com['art_id'] = $id;

        Comment::create($com);

        session()->flash('message', 'Comment Successfully Added!');
        Session::flash('type', 'success');
        return redirect()->back();


        }

        else{
        session()->flash('message', 'You can not interact with a faculty unless it has been commented!');
        Session::flash('type', 'warning');

        return redirect()->back();
       }
    }






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
