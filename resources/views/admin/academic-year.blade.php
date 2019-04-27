   
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
                                   







        
                                   <table id="selection-datatable" class="table table-bordered dt-responsive nowrap">
                                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Year</th>
                                <th>Opening Date</th>
                                <th>Closing Date</th>
                                <th>Final Date</th>
                                {{-- <th>Progress</th> --}}
                                <th>Timeleft</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($ays as $ay)

                          <tr>
                            <td>{{ $ay->id }}</td>
                            <td>{{ $ay->year }}</td>
                            <td>{{ $ay->opening_date }}</td>
                            <td>{{ $ay->closing_date }}</td>
                            <td>{{ $ay->final_date }}</td>
                            {{-- <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                              </div>
                            </td> --}}

                             @php
                                   $sdiff = Carbon\Carbon::today()->diffInDays($ay->opening_date, false);
                                   $cdiff = Carbon\Carbon::today()->diffInDays($ay->closing_date, false);
                                   $fdiff = Carbon\Carbon::today()->diffInDays($ay->final_date, false);
                                   // $stofdiff = Carbon\Carbon::parse($ay->opening_date)->diffInDays($ay->final_date, false);
                                   // $stocdiff = Carbon\Carbon::parse($ay->opening_date)->diffInDays(Carbon\Carbon::today(), false);
                                   // $pdp = (100/$stofdiff);
                                   // $progress = $pdp*$stocdiff;

                                   // $progress = round($progress);
                                   // $progress = 0;


                            @endphp
                            <td>

                                
                                <span class="badge
                                @if($sdiff>0)

                                bg-dark


                                @elseif($cdiff>0)

                                bg-success
                                    
                                @elseif($fdiff>0)

                                bg-warning

                                @else
                                 bg-danger

                                @endif

                                 ">
                                 {{ $fdiff }} days
                                </span></td>

                            <td><a href="{{route($eroute, $ay->id)}}" class="btn btn-primary w-md"><i class="mdi mdi-square-edit-outline"></i> <span> Edit</span></a></td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                    {{-- {{$ays}} --}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





                                    </div>
                   
@endsection




@section('scripts')



@endsection