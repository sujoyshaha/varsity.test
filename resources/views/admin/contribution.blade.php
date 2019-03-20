   
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
                                    
                                   <button type="button" class="btn btn-lg btn-info  "  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button> <br />







        
                                    <table class="table">
                                        <thead>
                            <tr>
                                <th style="width: 10px">ID</th>
                                <th class="align-middle">Article Name</th>
                                <th class="align-middle">Opening Date</th>
                                <th class="align-middle">Closing Date</th>
                                <th class="align-middle">Submitted</th>        
                                <th class="align-middle">Academic Year</th>
                                
                                
                                
                                {{-- <th>Final Date</th> --}}
                                <th>Status</th>
                                {{-- <th>Time Left to Update File</th> --}}
                                
                                {{-- <th>Progress</th> --}}
                                <th style="width: 40px">Timeleft</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($cns as $cn)

                          <tr>
                            <td class="align-middle">{{ $cn->id }}</td>
                            <td class="align-middle">{{ $cn->title }}</td>
                            <td class="align-middle">{{ $cn->ayear->opening_date }}</td>
                            <td class="align-middle">{{ $cn->ayear->closing_date }}</td>
                            {{-- <td class="align-middle">{{ $cn->ayear->final_date }}</td> --}}
                            <td class="align-middle">{{ $cn->created_at }}</td>
                            <td class="align-middle">{{ $cn->year }}</td>




                               <td class="align-middle">

                              @if($cn->status == 1)

                              <span class="badge bg-primary text-white">Submitted</span>

                              @elseif($cn->status == 2)

                              <span class="badge bg-warning text-white">Commented</span>

                              @elseif($cn->status == 3)

                              <span class="badge bg-success text-white">Accepted</span>
                              @else

                              <span class="badge bg-danger text-white">Rejected</span>
                              @endif

                            </td>

                           @php
                              // $odiff = Carbon\Carbon::today()->diffInDays($acayear->opening_date, false);
                              // $cdiff = Carbon\Carbon::today()->diffInDays($con->acyear->closing_date, false);
                              // $fdiff = Carbon\Carbon::today()->diffInDays($con->acyear->final_date, false);


                           // $sdiff = Carbon\Carbon::today()->diffInDays($cn->opening_date, false);
                                   $cdiff = Carbon\Carbon::today()->diffInDays($cn->ayear->closing_date, false);
                                   $fdiff = Carbon\Carbon::today()->diffInDays($cn->ayear->final_date, false);
                            @endphp
                            <td class="align-middle">

                                
                                <span class="badge
                                @if($cdiff>0)

                                bg-success
                                    
                                @elseif($fdiff>0)

                                bg-warning

                                @else
                                 bg-danger

                                @endif

                                 ">
                                 {{ $fdiff }} days
                                </span></td>


                            <td><a href="{{ route('single-stdcontribution', $cn->id) }}" class="btn btn-primary ">View</a> <a href="{{route($eroute, $cn->id)}}" class="btn btn-primary "><i class="mdi mdi-square-edit-outline"></i> <span> Edit</span></a>  </td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                    {{$cns}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->






                   
@endsection




@section('scripts')



@endsection