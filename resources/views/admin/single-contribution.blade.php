   
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

      					<div class="col-xl-4">
        
                                <div class="card-box">
                                    
                                   
                                    
                                         <div class="text-center">
                                         

                                         <img src="https://i0.wp.com/www.winhelponline.com/blog/wp-content/uploads/2017/12/user.png?fit=256%2C256&quality=100&ssl=1"  class="avatar img-circle img-thumbnail" alt="avatar">
                                        

                                        <h4 class="username"><a href="#">{{ $con->student->first_name }} {{ $con->student->first_name }}</a></h4>
                                 </div>


                                 <br>


                                <h5>Article Name:  {{ $con->title }}</h5>                              
                      
                               {{--  <h5>Department:  {{ $con->user->dep->name }}</h5> --}}
                                <h5>Submitted At:  {{ $con->created_at }}</h5>
                                {{-- <h5>Academic Year:  {{ $con->acyear->year }}</h5> --}}
                                <h5>Contribution ID:  {{ $con->id }}</h5>
                                <h5>Last Modified At:  {{ $con->updated_at }}</h5>
                
                                    
                                </div><!-- end card-box-->
        
                                 <!-- end card-box-->
        
                            </div>      					

                            <div class="col-xl-8">
        
                                <div class="card-box">
                                    
                                    <h4 class="header-title">Contribution Files</h4>
                                    
                                    
                                    
                                </div><!-- end card-box-->
        
                                 <!-- end card-box-->
        
                            </div>
      
     
                                <div class="card-box">
                                    <h2 class="m-t-0 header-title d-inline">Basic example</h2>
                                   <button type="button" class="btn btn-lg btn-info float-right"  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button>

{{-- <span class="username"><a href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }} #{{ Auth::user()->id }}</a></span> --}}





                                </div> <!-- end card-box -->
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





                   
@endsection




@section('scripts')



@endsection