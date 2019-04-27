   
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

                                     

                                <table id="selection-datatable" class="table table-bordered dt-responsive nowrap">
                                  <thead>
                            <tr>
                                <th>#</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                {{-- <th>Department</th> --}}
                                
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>



                        @foreach($cns as $cn)

                          <tr>
                            <td>{{ $cn->id }}</td>
                            <td>{{ $cn->first_name }}  </td>
                            <td>{{ $cn->last_name }}  </td>
                            <td>{{ $cn->phone }}</td>
                            <td>{{ $cn->email }}</td>
                            {{-- <td class="align-middle">{{ $cn->dep->name }}</td> --}}
                          
                            <td>
                                <a href="{{ route('edit-admin',$cn->id) }}" class="btn btn-block btn-primary btn-sm">Edit</a> 
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