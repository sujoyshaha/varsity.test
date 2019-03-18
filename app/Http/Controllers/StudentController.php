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
        // $cn['std_id'] = $request->title;

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
