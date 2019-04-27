   
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
                                    {{-- <h2 class="m-t-0 header-title d-inline">Basic example</h2>
                                   <button type="button" class="btn btn-lg btn-info float-right"  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button> --}}


 <form id="year-change" method="get" action="{{ route('cord-articles')}}  ">

  
                                    
        
                                    {{-- <form class="form-horizontal"> --}}
                                        <div class="form-group row">
                                            
                                            


                                            <div class="col-sm-6">
                                                 {{-- <label>Select Academic Year</label> --}}

                                                <select class="form-control float-right" id="academic-year" name="year">
                                                  @foreach ($acys as $ay)
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
                                        
                                        
                                        
                                        
                                    {{-- </form> --}}
                                




 

               
                </form>



<form action="{{ route('approve-articles') }}" method="post">
            @csrf



        
                    <table id="selection-datatable" class="table table-bordered dt-responsive nowrap">
                        <thead>
                            <tr>
                               
                                <th>ID</th>
                                <th>Article Name</th>
                                {{-- <th>Opening Date</th> --}}
                                <th>Closing Date</th>
                                <th>Submitted</th> 
                                <th>Submitted By</th>        
                                <th>Academic Year</th>
                                <th>Departmant Name</th>
                                <th>Status</th>
                                <th>Timeleft</th>
                                <th>Action</th>
                            </tr>
                            
                        </thead>
                        <tbody>

                         @foreach($cns as $cn)

                          <tr>
                            <td>{{ $cn->id }}</td>
                            <td>{{ $cn->title }}</td>
                            {{-- <td class="align-middle">{{ $cn->ayear->opening_date }}</td> --}}
                            <td>{{ $cn->ayear->closing_date }}</td>
                            
                            {{-- <td class="align-middle">{{ $cn->ayear->final_date }}</td> --}}
                            <td>{{ $cn->created_at }}</td>
                            <td>{{ $cn->student->first_name }} {{ $cn->student->last_name }}</td> 
                            <td>{{ $cn->year }}</td>

                            <td>{{ $cn->department->name }}</td>




                              <td>

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

                                
                                <span class="
                                @if($cdiff>0)

                                btn btn-success btn-sm
                                    
                                @elseif($fdiff>0)

                                btn btn-warning btn-sm

                                @else
                                 btn btn-danger btn-sm

                                @endif

                                 ">
                                 {{ $fdiff }} days
                                </span>


                              </td>


                            <td>

                              <a href="{{ route('single-adminarticle', $cn->id) }}" class="btn btn-primary ">View</a>  
                              <a href="{{ route('single-adminarticle',$cn->id) }}" class="btn btn-primary btn-sm">Comment</a>

                              @if($cn->file_status > 2)
                                  <button type="button" class="btn btn-success btn-sm" disabled="">Approved</button>
                              @else
                                  <a href="{{ route('approve-article',$cn->id) }}" class="btn btn-success btn-sm">Approve</a>
                              @endif
                             



        




                             </td>
                          </tr>

                        @endforeach
                        </tbody>



                                    </table>
                                   {{--  {{$cns}} --}}






            <div class="card-footer clearfix">
             
                <button type="submit" class="btn btn-success btn-sm" id="approvebtn" {{-- disabled="" --}}>Approve Selected Contributions</button>

               
                 

           
            </div>
        
          </form>


                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->




@endsection




@section('scripts')

{{-- <script>
var checkBoxes = $('tbody .checkthis');
checkBoxes.change(function () {
    $('#approvebtn').prop('disabled', checkBoxes.filter(':checked').length < 1);
});
$('tbody .checkthis').change();

// Listen for click on toggle checkbox
$('#select-all').click(function(event) {   
    if(this.checked) {
        // Iterate each checkbox
        $('.checkthis').each(function() {
            this.checked = true;                        
        });

        $('#approvebtn').prop('disabled', false);

    } else {
        $('.checkthis').each(function() {
            this.checked = false;                       
        });

        $('#approvebtn').prop('disabled', true);
    }
});

</script> --}}

@endsection