   
@extends('layouts.master.dashboard')
@section('backend-content')

     
@section('academic-css')
         

<style type="text/css">
  
.table th, .table td {
   
     vertical-align: middle; 
   
}


</style>
      
@endsection


               
 <div class="col-lg-12">

                   

    <div class="row">
      <div class="col-xl-4">


          <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
              <div class="float-left">
                  <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{$totalArticles}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
              </div>
              <div class="widget-chart-one-content text-right">
                  <p class="text-white mb-0 mt-2">Total Articles</p>
                  <h3 class="text-white">{{$totalArticles}}</h3>
              </div>
          </div>

      
      
     </div>



           <div class="col-xl-4">



          <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
              <div class="float-left">
                  <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{$totalDepartments}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
              </div>
              <div class="widget-chart-one-content text-right">
                  <p class="text-white mb-0 mt-2">Total Departments</p>
                  <h3 class="text-white">{{$totalDepartments}}</h3>
              </div>
          </div>

      
     </div>



           <div class="col-xl-4">
            
          <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
              <div class="float-left">
                  <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{$totalStudents}}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
              </div>
              <div class="widget-chart-one-content text-right">
                  <p class="text-white mb-0 mt-2">Total Students</p>
                  <h3 class="text-white">{{$totalStudents}}</h3>
              </div>
          </div>
         


      
      
            </div>


           <div class="col-xl-4">



          <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
              <div class="float-left">
                  <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ $withcom }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
              </div>
              <div class="widget-chart-one-content text-right">
                  <p class="text-white mb-0 mt-2">Total Article With Comments</p>
                  <h3 class="text-white">{{ $withcom }}</h3>
              </div>
          </div>

      
          </div>


           <div class="col-xl-4">



            <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
                <div class="float-left">
                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ $nocom }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                </div>
                <div class="widget-chart-one-content text-right">
                    <p class="text-white mb-0 mt-2">Total Article Without Comments</p>
                    <h3 class="text-white">{{ $nocom }}</h3>
                </div>
            </div>

      
        </div>

@if(Auth::guard('admin')->check())

           <div class="col-xl-4">



            <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
                <div class="float-left">
                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ $totalComments }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                </div>
                <div class="widget-chart-one-content text-right">
                    <p class="text-white mb-0 mt-2">Total Comments</p>
                    <h3 class="text-white">{{ $totalComments }}</h3>
                </div>
            </div>

      
        </div>

        @endif

@if(Auth::guard('coordinator')->check())


            <div class="col-xl-4">



            <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
                <div class="float-left">
                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ $yourComments }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                </div>
                <div class="widget-chart-one-content text-right">
                    <p class="text-white mb-0 mt-2">Your Comments</p>
                    <h3 class="text-white">{{ $yourComments }}</h3>
                </div>
            </div>

      
        </div>


@elseif(Auth::guard('student')->check())

            <div class="col-xl-4">



            <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
                <div class="float-left">
                    <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ $yourComments }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".1" />
                </div>
                <div class="widget-chart-one-content text-right">
                    <p class="text-white mb-0 mt-2">Your Comments</p>
                    <h3 class="text-white">{{ $yourComments }}</h3>
                </div>
            </div>

      
        </div>



@endif


            
    </div>
  <div>
@endsection






@section('scripts')



@endsection