   
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
                                <th>Year</th>
                                <th>Opening Date</th>
                                <th>Closing Date</th>
                                <th>Final Date</th>
                                {{-- <th>Progress</th> --}}
                                <th style="width: 40px">Timeleft</th>
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
                            <td class="align-middle">

                                
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
                                    {{$ays}}
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
                                                  
                                                <form role="form" method="post" action="{{route('post-academic-year')}}">

                                                  @csrf
                                                  <div class="card-body">
                                                    <div class="form-group">
                                                      <label for="exampleInputEmail1">Academic Year</label>
                                                      <input type="text" class="form-control" id="year" name="year" placeholder="2019" >
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Opening Date</label>
                                                      <input type="date" class="form-control" id="opening-date" name="opening_date" placeholder="DD/MM" >
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Closing Date</label>
                                                      <input type="date" class="form-control" id="closing-date" name="closing_date" placeholder="DD/MM" >
                                                    </div>


                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Final Date</label>
                                                      <input type="date" class="form-control" id="final-date" name="final_date" placeholder="DD/MM" >
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