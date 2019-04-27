   
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


      
     
                               <div class="card-box col-12">
                                
        
                      <div class="card-body">
                   <form method="POST" action="{{ route('update-admin', $user->id) }}" id="form">
                        @csrf
						
												<div class="col-12">
        
                                <div class="card-box">
                                  
        
                                    <div class="row">
                                        <div class="col-md-6">
                                                    
                                         <label for="Role" class=" col-form-label text-md-right">{{ __('Role') }}</label>
        
                                            <select class="form-control" id="change-user-type">
                                                
                                                <option value='{{ route('post-admin') }}'>Administration</option>
                                                <option value='{{ route('post-manager') }}'>Marketing Manager</option>
                                                <option value='{{ route('post-coordinator') }}'>Marketing Coordinator</option>
                                                <option value='{{ route('post-student')}}'>Student</option>
                                                <option value='{{ route('post-faculty') }}'>Faculty(Guest)</option>
                                            </select>




                                            <label for="last_name" class="col-form-label text-md-right">{{ __('Last Name') }}</label>

                                            <input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{$user->last_name}}" required autofocus>

                                            <label for="phone" class="col-form-label text-md-right">{{ __('Phone') }}</label>

                            
                                         <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{$user->phone}}" required autofocus>

                                         <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>

                            
                                           <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  value="{{$user->password}}">


                                        
                                        <br>



                                         
                                            <button type="submit" class="btn btn-primary">
                                               Uodate  Admin
                                            </button>
                                        

       
                                        </div> <!-- end col -->
        
                                       
                                        <div class="col-md-6">
                                            
                                            <label for="first_name" class="col-form-label text-md-right">{{ __('First Name') }}</label>

                           
                                            <input id="first_name" type="text" class="form-control" name="first_name" value="{{$user->first_name}}" required autofocus>



                                             <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            
                                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{$user->email}}" required>


                                             {{-- <label for="department_id" class="col-form-label text-md-right">{{ __('Department') }}</label> --}}

                            
                                           

                                           {{-- <select class="form-control" id="department_id" name="department_id">
                            <option>-- Select Department --</option>
                            @foreach($dep as $value)
                                <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select> --}}


                            
						                  	<label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

							
							
							
							
        
                                        </div> <!-- end col -->
                                    </div> <!-- end row -->
        
                                </div> <!-- end card-box -->
                            </div>
						
						
						
					
						
						 
						
						</div>
						
						
						
						
						






                
                    </form>


                </div>


                                </div>
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





                   
@endsection





        @section('scripts')

<script type="text/javascript">
  $('#change-user-type').change(function() {
   var target = $(this).val();
   $('#form').attr('action', target);

});
</script>

<script>
for(var els = document.getElementsByClassName("cat-delete"), i = els.length; i--;){
els[i].href = 'javascript:void(0);';
els[i].onclick = (function(el){
return function(){
swal({
title: 'Are you sure?',
text: "You won't be able to revert this!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#3085d6',
cancelButtonColor: '#d33',
confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if (result.value) {
window.location.href = el.getAttribute('data-href');
swal({
title: 'Deleting!',
text: 'Your file is being deleted.',
timer: 2000,
onOpen: () => {
swal.showLoading()
timerInterval = setInterval(() => {
swal.getContent().querySelector('strong')
.textContent = swal.getTimerLeft()
}, 100)
},
onClose: () => {
clearInterval(timerInterval)
}
}

)
}
})

};
})(els[i]);
}
</script>

@endsection