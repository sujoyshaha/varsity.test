   
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

                   

    <div class="">

      
      
     
            <div class="card-box">
      <form id="year-change" method="get" action="{{ route(Request::route()->getName()) }}  ">

  

                                       <div class="form-group row">
                                            
                                            


                                            <div class="col-sm-6">
                                                 {{-- <label>Select Academic Year</label> --}}

                                                <select class="form-control float-right" id="academic-year" name="year">
                                                  @foreach ($ays as $ay)
                                                  @isset($selectedYear)
                                                      <option value="{{ $ay->year }}" {{ $ay->year == $selectedYear ? 'selected="selected"' : '' }}>{{ $ay->year }}</option>
                                                  @else
                                                      <option value="{{ $ay->year }}">{{ $ay->year }}</option>
                                                  @endisset
                                                  @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-6">

                                              <button type="submit" class="btn btn-block btn-success">Submit</button>




                                            </div>




                                        </div>








                </form>


     
               <div class="col-md-12 ">













                              
                            </div> 
      
                                  
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->





   







<div class="row">
                            
                                
        
                            <div class="col-xl-6">

                              <div id="artpercentage" style="height: 370px; width: 100%;"></div>


                            </div>

<div class="col-xl-6">




                                <div class="card-box">

                                  
                                                                      
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


                                                   

                                                                

                  <br />



                  <div class="card-box widget-chart-one gradient-success bx-shadow-lg">
                  <div class="float-left">
                  <input data-plugin="knob" data-width="80" data-height="80" data-linecap=round data-fgColor="#ffffff" data-bgcolor="rgba(255,255,255,0.2)" value="{{ round((count($articles))*$scper, 2) }}" data-skin="tron" data-angleOffset="180" data-readOnly=true data-thickness=".2" />
                </div>
              <div class="widget-chart-one-content text-right">
                  <p class="text-white mb-0 mt-2">

                      @foreach($deps as $dep)

                                               @if($dep->id == $rp)
                                                
                                                  {{ $dep->name }}

                                                  @endif
                                                
                                              @endforeach

                  


                </p>
                  <h3 class="text-white">{{ round((count($articles))*$scper, 2) }}%</h3>
              </div>
          </div>

        


                                            @endforeach


                                 
                                       
                                        </div> <!-- end col -->
                                    </div> <!-- end row-->
                                    
                                </div> <!-- end card-box-->
                            </div> <!-- end col-->
        
                        </div>








    </div>






                                    </div>
                    
@endsection






@section('scripts')


<script type="text/javascript">
window.onload = function() {

var options = {
  title: {
    text: "Website Traffic Source"
  },
  data: [{
      type: "pie",
      startAngle: 45,
      showInLegend: "true",
      legendText: "{label}",
      indexLabel: "{label} ({y})",
      yValueFormatString:"#,##0.#"%"",
      dataPoints: [
        { label: "Organic", y: 36 },
        { label: "Email Marketing", y: 31 },
        { label: "Referrals", y: 7 },
        { label: "Twitter", y: 7 },
        { label: "Facebook", y: 6 },
        { label: "Google", y: 10 },
        { label: "Others", y: 3 }
      ]
  }]
};
$("#chartContainer").CanvasJSChart(options);

}
</script>



<script type="text/javascript">
window.onload = function() {

var options = {
  exportEnabled: true,
  animationEnabled: true,
  title:{
    text: "Percentage of Contributions"
  },
  legend:{
    horizontalAlign: "right",
    verticalAlign: "center"
  },
  data: [{
    type: "pie",
    showInLegend: true,
    toolTipContent: "<b>{name}</b>: ${y} (#percent%)",
    indexLabel: "{name}",
    legendText: "{name} (#percent%)",
    indexLabelPlacement: "inside",
    dataPoints: [



  @foreach($reps as $rp => $articles)
            
         

      { y: {{ round((count($articles))*$scper, 2) }}, 

    @foreach($deps as $dep)

        @if($dep->id == $rp)
                                                
        name: "{{ $dep->name }}" },

       @endif

 @endforeach



 @endforeach

      
    ]
  }]
};
$("#artpercentage").CanvasJSChart(options);

}


</script>









<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>  
<script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
@endsection