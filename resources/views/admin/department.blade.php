   
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
                                    <h2 class="m-t-0 header-title d-inline">Basic example</h2>
                                   <button type="button" class="btn btn-lg btn-info float-right"  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button>







        
                                    <table class="table">
                                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
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
                                    {{$dps}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





<div id="myModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
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
                   
@endsection




@section('scripts')



@endsection