   
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
                                    
                                   {{-- <button type="button" class="btn btn-lg btn-info  "  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button> <br /> --}}




               


        
                                    {{-- <table class="table"> --}}

                                     

{{--  @if(Auth::guard()->user()->role == 5) --}}
                                <table id="selection-datatable" class="table table-bordered dt-responsive nowrap">
                                  <thead>
                                      <tr>
                                          <th>ID</th>
                                          <th>Article Name</th>
                                          <th>Opening Date</th>
                                          <th>Closing Date</th>
                                          <th>Submitted</th>        
                                          <th>Submitted By</th>        
                                          <th>Academic Year</th>
                                                                       
                                          {{-- <th>Final Date</th> --}}
                                          <th>Status</th>
                                          {{-- <th>Time Left to Update File</th> --}}
                                          
                                          {{-- <th>Progress</th> --}}
                                          <th>Timeleft</th>
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
                            <td class="align-middle">{{ $cn->student->first_name }} {{ $cn->student->last_name }}</td> 

                            <td class="align-middle">{{ $cn->year }}</td>




                               <td class="align-middle">

                              @if($cn->file_status == 1)

                              <span class="btn btn-primary btn-sm">Submitted</span>

                              @elseif($cn->file_status == 2)

                              <span class="btn btn-warning btn-sm">Commented</span>

                              @elseif($cn->file_status == 3)

                              <span class="btn btn-success btn-sm">Accepted</span>


                              @elseif($cn->file_status == 4)

                              <span class="btn btn-success btn-sm">Accepted</span>

                              
                              <span class="btn btn-warning btn-sm">Commented</span>


                              @else

                              <span class="btn btn-danger btn-sm">Rejected</span>
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


                            <td><a href="{{ route('single-stdarticle', $cn->id) }}" class="btn btn-primary ">View</a> <a href="{{route($eroute, $cn->id)}}" class="btn btn-primary "><i class="mdi mdi-square-edit-outline"></i> <span> Edit</span></a> 


                              <a href="{{ route('delete-article', $cn->id) }}" class="btn btn-danger ">Delete</a> 



                              </td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                   {{--  {{$cns}} --}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->






                   
@endsection




@section('scripts')






     {{--    <script>
  $(function () {
    $("#selection-datatable").addClass( 'nowrap' ).DataTable({
      "responsive": true
    });
    // $('#example2').DataTable({
    //   "paging": true,
    //   "lengthChange": false,
    //   "searching": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false
    // });
  });
</script> --}}




@endsection


@section('datatable-files')



@endsection