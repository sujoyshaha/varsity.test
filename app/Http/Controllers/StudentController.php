<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\AcademicYear;
use App\Department;
use App\Contribution;
use App\ConPhoto;
use App\ConImg;
use Cookie;
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















     public function getContribution()
    {
         $data['title'] = "Contribution";
         $data['eroute'] = "edit-studentcontribution";
         $data['cns']= Contribution::orderBy('id','asc')->paginate(2);
         $data['acys']= AcademicYear::orderBy('id','asc')->get();

         return view('admin.contribution',$data);
    }



    // public function postContribution( Request $request)
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

    //     $cn = Contribution::create($cn);
    //     $lcn = $cn->id;

    //     foreach ($files as $file) {
    //          $img['con_id'] = $lcn;
    //          $img['name'] = $file->getClientOriginalName();
    //          $file->store('public/upload');
    //            ConPhoto::create($img);
    //      } 

      





    //     session()->flash('message', 'Contribution Successfully Added!');
    //     Session::flash('type', 'success');
    //     return redirect()->back();
    // }

    // //   public function editContribution($id)
    // // {
    // //      $data['title'] = "Update Contribution";
    // //      $data['uroute'] = "update-contribution";
    // //      $data['cn']= Contribution::findOrFail($id);
    // //        $data['acys']= AcademicYear::orderBy('id','asc')->get();

    // //      return view('admin.edit-contribution',$data);
    // // }


    // //   public function editContribution($id)
    // // {
    // //      $data['title'] = "Update Contribution";
    // //      $data['uroute'] = "update-contribution";
    // //      $data['cn']= Contribution::findOrFail($id);
    // //        $data['acys']= AcademicYear::orderBy('id','asc')->get();

    // //      return view('admin.edit-contribution',$data);
    // // }


    public function postContribution(Request $request)
    {
        $data['title'] = "Contribution";
        //$data['eroute'] = "edit-contribution";

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'year' => 'required|exists:academic_years,year',
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
        $con['user_id'] = Auth::guard('student')->user()->id;


        $con['file_name'] = $request->doc->getClientOriginalName();
        $request->doc->store('public/upload');

        $files = $request->file('file');



        $con = Contribution::create($con);

        $lcon = $con->id;

        foreach ($files as $file) {

            $img['con_id'] = $lcon;
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
        $data['title'] = "Contribution";

        //$data['uroute'] = "update-stdcontribution";
        // $data['route'] = "stdcontributions";

        $data['isDep'] = 2;
        // $data['eroute'] = "edit-academic-year";

        

        $data['ay'] = Contribution::findOrFail($id);

       $con = Contribution::findOrFail($id);

     //  $uid = Auth::student()->id; 

       // $uid = Auth::guard('student')->user()->id;

       //  if ($uid != $con->std_id) {
       //      session()->flash('message', 'You do not have permission to view this page!');
       //      Session::flash('type', 'error');
       //      return redirect()->route('studentcontributions');
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
            return redirect()->route('studentcontributions');
            }


        $con = Contribution::findOrFail($id);

        


        $data['acys'] = AcademicYear::orderBy('id', 'desc')->get();
        $data['cn'] = $con;



        return view('admin.edit-contribution', $data);
    }












    //  public function updateContribution($id, Request $request)
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


 public function updateContribution($id, Request $request)
    {
        $data['title'] = "Contribution";
        // $data['eroute'] = "edit-contribution";

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'year' => 'required|exists:academic_years,id',
            'doc' => 'file|mimes:doc,docx,pdf|max:5120',
            'file' => 'required',
            'file.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // dd($diff."<br>".$cdiff."<br>".$fdiff);
        $con = Contribution::findOrFail($id);

       $uid = Auth::guard('student')->user()->id;

        if ($uid != $con->user_id) {
           session()->flash('message', 'You do not have permission to view this page!');
            Session::flash('type', 'error');
            return redirect()->route('studentcontributions');
        }

        

        $acyear = AcademicYear::findOrFail($con->academic_year);

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
            session()->flash('message', 'You can not edit after the Final Submission date of the academic year!');
            Session::flash('type', 'error');
            return redirect()->route('studentcontributions');
            }


        $con['title'] = $request->title;
        $con['year'] = $request->academic_year;
        // $con['user_id'] = Auth::user()->id;


        if ($request->doc) {
            $con['file_name'] = $request->doc->getClientOriginalName();

            $request->doc->store('public/upload');

            
        }

        
        

        

        $con->save();

        $lcon = $id;

        if ($request->file('file')) {

            $files = $request->file('file');

            foreach ($files as $file) {

                $img['con_id'] = $lcon;
                $img['name'] = $file->getClientOriginalName();
                $file->store('public/upload');

                ConImg::create($img);
               
            }

        }

        

        session()->flash('message', 'Contribution Successfully Updated!');
        Session::flash('type', 'success');
        return redirect()->back();
    }


       public function getSingleContribution($id)
    {
        $data['title'] = "Contribution";

        // $data['uroute'] = "update-contribution";
        $data['route'] = "add-stdcomment";
        $data['eroute'] = "edit-stdcontribution";

        $uid = Auth::user()->id;

        // $data['isDep'] = 2;
        // $data['eroute'] = "edit-academic-year";
        $data['con'] = Contribution::findOrFail($id);
        $con = Contribution::findOrFail($id);


        if ($uid != $con->user_id) {

        session()->flash('message', "You don't have the required permission to view the requested page!");
        Session::flash('type', 'danger');
        return redirect()->back();        
        }

        $data['comments'] = Comment::whereConId($id)->orderBy('id', 'asc')->paginate(10);
        $data['comcount'] = Comment::whereConId($id)->count();

       // $con = Contribution::findOrFail($id);

        // $acyear = AcademicYear::findOrFail($con->academic_year);



        $con = Contribution::findOrFail($id);

        // $uid = Auth::user()->id; 

        // if ($uid != $con->user_id) {
        //     session()->flash('message', 'You do not have permission to view this page!');
        //     Session::flash('type', 'error');
        //     return redirect()->route('stdcontributions');
        // }





        return view('admin.single-contribution', $data);
    }
}
