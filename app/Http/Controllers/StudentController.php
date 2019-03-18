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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('backend.admin-dashboard');
    }

    




    //  public function getContribution()
    // {
    //      $data['title'] = "Contribution";
    //      $data['eroute'] = "edit-contribution";
    //      $data['cns']= Contribution::orderBy('id','asc')->paginate(2);
    //      $data['acys']= AcademicYear::orderBy('id','asc')->get();

    //      return view('admin.contribution',$data);
    // }


     public function getContribution(Request $request)
    {
        $data['title'] = "Contribution";
        $data['route'] = "post-stdcontribution";
        $data['eroute'] = "edit-stdcontribution";
        $data['sroute'] = "single-stdcontribution";
        $data['yroute'] = "stdcontributions-year";

        $ays = AcademicYear::orderBy('id', 'desc')->get();
        $uay = Cookie::get('uay');

        if ($request->year) {

        $this->validate($request,[
            'year' => 'required|exists:academic_years,year',
        ]);

        $nray = AcademicYear::where('year',$request->year)->first();

        $uay = $nray->id;

        Cookie::queue('uay', $uay, 300);    
        }

        if ($uay) {
            $cay = AcademicYear::findOrFail($uay);
        }else{
            $cay = AcademicYear::whereYear('opening_date', '=', date('Y'))->first();
        }
        $data['cay'] = $cay;
        $uid = Auth::user()->id;
        $data['cons'] = Contribution::whereAcademicYear($cay->id)->whereUserId($uid)->orderBy('id', 'asc')->paginate(10);
        $data['ays'] = AcademicYear::orderBy('id', 'desc')->get();

        return view('contribution', $data);
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


        // if ($uid != $con->user_id) {

        // session()->flash('message', "You don't have the required permission to view the requested page!");
        // Session::flash('type', 'danger');
        // return redirect()->back();        
        // }

        // $data['comments'] = Comment::whereConId($id)->orderBy('id', 'asc')->paginate(10);
        // $data['comcount'] = Comment::whereConId($id)->count();

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
