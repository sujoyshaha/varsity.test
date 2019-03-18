   
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
                                <th>Title</th>
                                <th>Academic Year</th>
                                <th>Date Submitted</th>
                                <th>Opening Date</th>
                                <th>Closing Date</th>
                                <th>Final Date</th>
                                <th>Status</th>
                                {{-- <th>Time Left to Update File</th> --}}
                                
                                {{-- <th>Progress</th> --}}
                                {{-- <th style="width: 40px">Timeleft</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        @foreach($cns as $cn)

                          <tr>
                            <td>{{ $cn->id }}</td>
                            <td>{{ $cn->title }}</td>
                            <td>{{ $cn->year }}</td>
                            <td>{{ $cn->created_at }}</td>

                            <td class="align-middle">{{ $cn->ayear->opening_date }}</td>
                            <td class="align-middle">{{ $cn->ayear->closing_date }}</td>
                            <td class="align-middle">{{ $cn->ayear->final_date }}</td>



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

                            <td>

                         
                         
                            
                            {{-- <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                              </div>
                            </td> --}}
                            {{-- <td><span class="badge bg-danger">55 days</span></td> --}}

                            <td><a href="{{route($eroute, $cn->id)}}" class="btn btn-primary w-md"><i class="mdi mdi-square-edit-outline"></i> <span> Edit</span></a>  <a href="{{ route('single-stdcontribution', $cn->id) }}" class="btn btn-warning btn-sm">Interact</a></td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                    {{$cns}}
                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





<div id="myModal" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myModalLabel">Contributions</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body" >
                                                  
                                                <form role="form" method="post" action="{{route('post-contribution')}}" enctype="multipart/form-data">

                                                  @csrf

                                             <div class="card-body">
                                                    <div class="form-group">
                             

                                    <select class="form-control" id="role" name="year">
                                      @foreach($acys as $acy)
                                        <option value="{{$acy->year}}">{{$acy->year}}</option>

                                           @endforeach
                                       
                                    </select>

                            
                            </div>
                            </div>



                                                  <div class="card-body">
                                                    <div class="form-group">
                                                      <label for="exampleInputEmail1">contribution title</label>
                                                      <input type="text" class="form-control" id="year" name="title" placeholder="2019" value=" {{old('title')}}">
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">contribution doc file</label>
                                                      <input type="file" class="form-control" id="opening-date" name="doc" placeholder="DD/MM" value="{{old('doc')}}" >
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Contribution photo</label>
                                                      <input type="file" class="form-control" id="closing-date" name="file[]" placeholder="DD/MM" multiple="" value="{{old('files')}}">
                                                    </div>


                                                  


                                                    
                                                    {{-- <a href="{{ route('contributions') }}" class="btn btn-secondary" >Back</a> --}}
                                                    <a href="{{ route('contributions') }}"class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</a>
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