   
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
                                <th style="width: 10px">ID</th>
                                <th>Department Name</th>
                                <th>Create Date</th>
                                
                                {{-- <th>Progress</th> --}}
                                {{-- <th style="width: 40px">Timeleft</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($dps as $dp)

                          <tr>
                            <td>{{ $dp->id }}</td>
                            <td>{{ $dp->name }}</td>
                            <td>{{ $dp->created_at }}</td>
                         
                            
                            {{-- <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                              </div>
                            </td> --}}
                            {{-- <td><span class="badge bg-danger">55 days</span></td> --}}

                            <td><a href="{{route($eroute, $dp->id)}}" class="btn btn-primary w-md"><i class="mdi mdi-square-edit-outline"></i> <span> Edit</span></a></td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                    {{-- {{$dps}} --}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->






                     </div>
@endsection




@section('scripts')



@endsection