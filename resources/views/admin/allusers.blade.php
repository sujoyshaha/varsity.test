   
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
                                    
                                   {{-- <button type="button" class="btn btn-lg btn-info  "  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button> <br /> --}}







        
                                    {{-- <table class="table"> --}}

                                     

                                <table id="selection-datatable" class="table table-bordered dt-responsive nowrap">
                                  <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Department</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>



                        @foreach($users as $user)

                          <tr class="align-middle">
                            <td class="align-middle">{{ $user->id }}</td>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            <td class="align-middle">{{ $user->dep->name }}</td>
                            <td class="align-middle">

                              @if($user->role == 5)

                              <span class="badge bg-success">Admin</span>

                              @elseif($user->role == 4)

                              <span class="badge bg-warning">Marketing Manage</span>

                              @elseif($user->role == 3)

                              <span class="badge bg-primary">Marketing Coordinator</span>

                              @elseif($user->role == 2)

                              <span class="badge bg-primary">Student</span>

                              @else

                              <span class="badge bg-danger">Faculty</span>
                              @endif</td>
                            <td>
                                <a href="{{ route($eroute,$user->id) }}" class="btn btn-block btn-primary btn-sm">Edit</a> 
                                {{-- <a data-href="{{ route($droute,$post->id) }}" class="cat-delete text-danger"> Delete</a> --}}
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