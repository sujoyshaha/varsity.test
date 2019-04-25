   
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

      
      
     
                                <div class="card-box">
                <form role="form" method="post" action="{{ route(Request::route()->getName()) }}" >
      @csrf                  


          <div class="form-group">
            <select class="form-control" name="academic_year">
              <option selected="selected">Choose Academic Year</option>
              @foreach($ays as $ay)
              <option value="{{ $ay->id }}">{{ $ay->year }}</option>
              @endforeach
            </select>
          </div>



           <div class="form-group">
            <button type="submit" class="btn btn-block btn-primary">Submit</button>
          </div>


</form>


     
               <div class="col-md-12 ">
                                <div class="card-box">
                                    <h4 class="header-title">Pie Chart</h4>
        
                                    <div class="mt-4">
                                        <div id="sparkline3" class="text-center"></div>
                                    </div>
                                </div> <!-- end card-box -->



                                <div class="card-box">
                                    <h4 class="header-title">Pie Chart</h4>
        
                                    <div id="pie-chart">
                                        <div id="pie-chart-container" class="flot-chart mt-5" style="height: 350px;">
                                        </div>
                                    </div>
                                </div> <!-- end card-box-->
                            </div> 

        
                                           {{--     <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Number of Contributions sujoy now</th>
                        <th>Percentage</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($reps as $rp => $articles)
                      <tr class="align-middle">
                        <td class="align-middle">
                          @foreach($deps as $dep)
                            
                             @if($dep->id == $rp)
                              {{ $dep->name }}
                            @endif
                            
                          @endforeach
                        </td>
                        <td class="align-middle">{{ count($articles) }}</td> --}}



                {{--     @php

                    $totalcon = 0;
                    foreach($reps as $rp => $articles){

                      $totalcon = $totalcon + $articles->count();

                    }

                    if ($totalcon){
                      $scper = (100/$totalcon);
                    }else{
                    $scper = 0;
                    }

                    
                      
                    @endphp
                   

                    <td class="align-middle">{{ round((count($articles))*$scper, 2) }} %</td> --}}

                    {{--   </tr>
                    @endforeach
                  </tbody>
                </table> 

 --}}







                {{--   <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Percentage of Contributions</th>
                    </tr>
                  </thead>
                  <tbody>

                    @php

                    $totalcon = 0;
                    foreach($reps as $rp => $articles){

                      $totalcon = $totalcon + $articles->count();

                    }

                    if ($totalcon){
                      $scper = (100/$totalcon);
                    }else{
                    $scper = 0;
                    }

                    
                      
                    @endphp
                    @foreach($reps as $rp => $articles)
                      <tr class="align-middle">
                        <td class="align-middle">
                          @foreach($deps as $dep)

                           @if($dep->id == $rp)
                            
                              {{ $dep->name }}

                              @endif
                            
                          @endforeach
                        </td>
                        <td class="align-middle">{{ round((count($articles))*$scper, 2) }} %</td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>    --}}            
                                  
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->





   







<div class="row">
                            <div class="col-xl-6">
                                <div class="card-box">
                                    
                                                                        <h4 class="header-title mb-4">Number of Contributions</h4>
                                    <div class="row">
                                 
                                        <div class="col-md-12">
                                            
@foreach($reps as $rp => $articles)


                                                                <h5 class="mb-1 mt-0">


                                           @foreach($deps as $dep)
                            
                             @if($dep->id == $rp)
                              {{ $dep->name }}
                            @endif
                            
                          @endforeach


                                             



                                              </h5>



                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">{{ count($articles) }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>


                                            @endforeach
        
                                          {{--   <h5 class="mb-1 mt-0">51,480 <small class="text-muted ml-2">www.youtube.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">39% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">45,760 <small class="text-muted ml-2">www.dribbble.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">61% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 61%;" aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">98,512 <small class="text-muted ml-2">www.behance.net</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">52% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 52%;" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">2,154 <small class="text-muted ml-2">www.vimeo.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">28% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                </div>  <!-- end card-box-->
                            </div> <!-- end col -->
        
                            <div class="col-xl-6">
                                <div class="card-box">
                                                                       <h4 class="header-title mb-4">Percentage of Contributions</h4>
                                    <div class="row">
                                 
                                        <div class="col-md-12">
                                            

                                                                 @php

                                        $totalcon = 0;
                                        foreach($reps as $rp => $articles){

                                          $totalcon = $totalcon + $articles->count();

                                        }

                                        if ($totalcon){
                                          $scper = (100/$totalcon);
                                        }else{
                                        $scper = 0;
                                        }

                                        
                                          
                                        @endphp




                                        @foreach($reps as $rp => $articles)


                                                                <h5 class="mb-1 mt-0">


                                           @foreach($deps as $dep)

                                               @if($dep->id == $rp)
                                                
                                                  {{ $dep->name }}

                                                  @endif
                                                
                                              @endforeach


                                             



                                              </h5>



                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">{{ round((count($articles))*$scper, 2) }} % </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ round((count($articles))*$scper, 2) }}%;" aria-valuenow="{{ round((count($articles))*$scper, 2) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>


                                            @endforeach
        
                                          {{--   <h5 class="mb-1 mt-0">51,480 <small class="text-muted ml-2">www.youtube.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">39% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success" role="progressbar" style="width: 39%;" aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">45,760 <small class="text-muted ml-2">www.dribbble.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">61% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info" role="progressbar" style="width: 61%;" aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">98,512 <small class="text-muted ml-2">www.behance.net</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">52% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 52%;" aria-valuenow="52" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
        
                                            <h5 class="mb-1 mt-0">2,154 <small class="text-muted ml-2">www.vimeo.com</small></h5>
                                            <div class="progress-w-percent">
                                                <span class="progress-value font-weight-bold">28% </span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-danger" role="progressbar" style="width: 28%;" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div> --}}
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                    
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
        
                        </div>








    </div>





{{-- <div id="myModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Academic year</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body" >
                                                  
                                                <form role="form" method="post" action="{{route('post-department')}}">

                                                  @csrf
                                                  <div class="card-body">
                                                    <div class="form-group">
                                                      <label for="exampleInputEmail1">Add Department</label>
                                                      <input type="text" class="form-control" id="year" name="name" placeholder="EEE" >
                                                    </div>
                                                   

                                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</button>
                                          <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add {{$title}}</button>
                                                    </div>
                                                 
                                              
                                              </div>
                                              <!-- /.card -->
                                        </div>
                                        
                                         </form>
                                                    
                                              
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div>
                    --}}
@endsection






@section('scripts')


<script>
  


$( document ).ready(function() {
    
    var DrawSparkline = function() {





        
        $('#sparkline3').sparkline([
          @foreach($reps as $rp => $contributions)
            {{ round((count($contributions))*$scper, 2) }},
          @endforeach], {
            type: 'pie',
            width: '165',
            height: '165',
            sliceColors: ['#35b8e0','#3b3e47','#e3eaef','#f34943']
        });
    
 
   


        },
        DrawMouseSpeed = function () {
            var mrefreshinterval = 500; // update display every 500ms
            var lastmousex=-1; 
            var lastmousey=-1;
            var lastmousetime;
            var mousetravel = 0;
            var mpoints = [];
            var mpoints_max = 30;
            $('html').mousemove(function(e) {
                var mousex = e.pageX;
                var mousey = e.pageY;
                if (lastmousex > -1) {
                    mousetravel += Math.max( Math.abs(mousex-lastmousex), Math.abs(mousey-lastmousey) );
                }
                lastmousex = mousex;
                lastmousey = mousey;
            });
            var mdraw = function() {
                var md = new Date();
                var timenow = md.getTime();
                if (lastmousetime && lastmousetime!=timenow) {
                    var pps = Math.round(mousetravel / (timenow - lastmousetime) * 1000);
                    mpoints.push(pps);
                    if (mpoints.length > mpoints_max)
                        mpoints.splice(0,1);
                    mousetravel = 0;
                    $('#sparkline5').sparkline(mpoints, {
                        tooltipSuffix: ' pixels per second',
                        type: 'line',
                        width: "100%",
                        height: '165',
                        chartRangeMax: 77,
                        maxSpotColor:false,
                        minSpotColor: false,
                        spotColor:false,
                        lineWidth: 1,
                        lineColor: '#31ce77',
                        fillColor: 'rgba(49, 206, 119, 0.3)',
                        highlightLineColor: 'rgba(24,147,126,.1)',
                        highlightSpotColor: 'rgba(24,147,126,.2)'
                    });
                }
                lastmousetime = timenow;
                setTimeout(mdraw, mrefreshinterval);
            }
            // We could use setInterval instead, but I prefer to do it this way
            setTimeout(mdraw, mrefreshinterval); 
        };
    
    DrawSparkline();
    DrawMouseSpeed();
    
    var resizeChart;

    $(window).resize(function(e) {
        clearTimeout(resizeChart);
        resizeChart = setTimeout(function() {
            DrawSparkline();
            DrawMouseSpeed();
        }, 300);
    });
});
</script>
@endsection