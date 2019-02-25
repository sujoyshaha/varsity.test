   
@extends('layouts.master.dashboard')
@section('backend-content')

     

         


      
            <!-- Page Content Start -->
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">

                        <!-- Page title box -->
                        <div class="page-title-box">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Greeva</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                            <h4 class="page-title">Dashboard</h4>
                        </div>
                        <!-- End page title box -->


               


                        <div class="">

    <div class="row">
        <div class="col-sm-3"><!--left col-->

          
      <div class="text-center">
        <img 

            @if($user->photo)


        src="{{asset('upload/' .$user->photo)}}"

{{--    @if(Auth::user()->photo)
        src="{{asset('upload/' .Auth::user()->photo)}}" 
        --}}        
        @else

        src="{{asset('images/no-image.png')}}"
        @endif

         class="avatar img-circle img-thumbnail" alt="avatar">
        <h6 style="text-transform: uppercase;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h6>
        
      </div></hr><br>

               
       
               
      
          
        </div><!--/col-3-->
        <div class="col-sm-9">

                <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#view" data-toggle="tab" aria-expanded="false" class="nav-link active show">View</a>
                        </li>
                        <li class="nav-item"><a href="#update" data-toggle="tab" aria-expanded="true" class="nav-link">Update</a></li>
                        <li class="nav-item"><a href="#change-pass" data-toggle="tab" aria-expanded="false" class="nav-link ">Change Password</a></li>
                </ul>


                <div class="tab-content">
                        <div class="tab-pane active show" id="view">

                                         <form class="form" action="##" method="post" id="registrationForm">
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="first_name"><h4>First name</h4></label>
                                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" value="{{ $user->first_name }} ">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                        <label for="last_name"><h4>Last name</h4></label>
                                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" value="{{ Auth::user()->last_name }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="email"><h4>Email</h4></label>
                                          <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com" value="{{ Auth::user()->email }}">
                                      </div>
                                  </div>
                                           
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="phone"><h4>Phone</h4></label>
                                          <input type="text" class="form-control" name="phone" id="phone" placeholder="enter phone" value="{{ Auth::user()->phone }}">
                                      </div>
                                  </div>
                      
                                
                                  
                            </form>
                                            
                        </div>



                        <div class="tab-pane" id="update">

                            <!-- ==================================VALIDATION ERRORS================================== -->
@if($errors->any())
@foreach ($errors->all() as $error)
<div class="form-group">

<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
{!! $error !!}
</div>
</div>
@endforeach
@endif
<!-- ==================================VALIDATION MESSAGES================================== -->

                            <form class="form" action="{{route('update-user')}}" method="post" id="registrationForm" enctype="multipart/form-data">

                                @csrf

                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="first_name"><h4>First Name</h4></label>
                                          <input type="text" class="form-control" name="first_name" id="first_name" placeholder="first name" value="{{ Auth::user()->first_name }} ">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                        <label for="last_name"><h4>Last Name</h4></label>
                                          <input type="text" class="form-control" name="last_name" id="last_name" placeholder="last name" value="{{ Auth::user()->last_name }}">
                                      </div>
                                  </div>
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="email"><h4>Email</h4></label>
                                          <input type="email" class="form-control" name="email" id="email" placeholder="you@email.com" value="{{ Auth::user()->email }}">
                                      </div>
                                  </div>
                                           
                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="phone"><h4>Phone</h4></label>
                                          <input type="text" class="form-control" name="phone" id="phone" placeholder="enter phone" value="{{ Auth::user()->phone }}">
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                          <label for="phone"><h4>Photo</h4></label>
                                           <input type="file" name="photo" class="form-control">
                                      </div>
                                  </div>
                                 
                      
                                
                                  <div class="form-group">
                                       <div class="col-xs-12">
                                            <br>
                                            <button class=" cat-delete btn btn-lg btn-success" type="submit"><i class=" mdi mdi-checkbox-marked-circle"></i> Update</button>
                                            {{-- <button class="btn btn-lg" type="reset"><i class="dripicons-clockwise"></i> Reset</button> --}}
                                        </div>
                                  </div>
                            </form>
                            
                        </div>



                        <div class="tab-pane" id="change-pass">




                             <form method="POST" action="{{route('post-pass')}}">
                                 @csrf
                                      
                                                      <!-- ==================================VALIDATION ERRORS================================== -->
@if($errors->any())
@foreach ($errors->all() as $error)
<div class="form-group">

<div class="alert alert-danger alert-dismissable">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
{!! $error !!}
</div>
</div>
@endforeach
@endif
<!-- ==================================VALIDATION MESSAGES================================== -->
                      
                                  <div class="form-group">


                                 {{--    <div class="col-xs-6">
                                          <label for="password"><h4>Old Password</h4></label>
                                          <input type="password" class="form-control" name="password" id="password" placeholder="password" title="enter your password.">
                                    </div>
 --}}

                                   {{--  <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Old Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control{{ $errors->has('passwordold') ? ' is-invalid' : '' }}" name="passwordold" required>

                                            @if ($errors->has('passwordold'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('passwordold') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}


                                    <div class="col-xs-6">
                                      <label for="password"><h5>{{ __('Old Password') }}</h5></label>
                                      <input id="password" type="password" class="form-control{{ $errors->has('passwordold') ? ' is-invalid' : '' }}" name="passwordold" required>

                                            @if ($errors->has('passwordold'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('passwordold') }}</strong>
                                                </span>
                                            @endif
                                  </div>
                                    {{-- <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                            @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}
                              
                                    <div class="col-xs-6">
                                      <label for="password"><h5>{{ __('New Password') }}</h5></label>
                                      <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                      @if ($errors->has('password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                  </div>
                                   {{--  <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>



                                        <div class="col-md-6">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                        </div>
                                    </div> --}}

                                    <div class="col-xs-6">
                                      <label for="password-confirm"><h5>{{ __('Confirm New Password') }}</h5></label>
                                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                  </div>

                                      
                                  {{-- <div class="col-xs-6">
                                      <label for="password"><h4>Password</h4></label>
                                      <input type="password" class="form-control" name="password" id="password" placeholder="password" title="enter your password.">
                                  </div> --}}
                                  
                           {{--        <div class="form-group">
                                      
                                      <div class="col-xs-6">
                                        <label for="password2"><h4>Verify</h4></label>
                                          <input type="password" class="form-control" name="password2" id="password2" placeholder="password2" title="enter your password2.">
                                      </div>
                                  </div> --}}
                                  <div class="form-group">
                                       <div class="col-xs-12">
                                            <br>
                                            <button class="btn btn-lg btn-success" type="submit"><i class="cat-delete mdi mdi-checkbox-marked-circle"></i> Update password</button>
                                            {{-- <button class="btn btn-lg" type="reset"><i class="dripicons-clockwise"></i> Reset</button> --}}
                                        </div>
                                  </div>
                            </form>
                                           
                        </div>
                    </div>
           

                 
              
              
              
             
             
          
          

        </div><!--/col-9-->
    </div><!--/row-->
                    </div>
                </div>
            </div>
            <!-- End Page Content-->




 

        </div>
        <!-- End #wrapper -->

        @endsection




        @section('scripts')

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