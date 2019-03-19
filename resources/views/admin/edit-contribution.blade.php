   
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
                                
        
      

       <form role="form" method="post" action="{{route('update-stdcontribution', $cn->id)}}" enctype="multipart/form-data">

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
                                                      <input type="text" class="form-control" id="year" name="title" placeholder="2019" value="{{$cn->title}}" >
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">contribution doc file</label>
                                                      <input type="file" class="form-control" id="opening-date" name="doc" placeholder="DD/MM" value="{{$cn->file_name}}">
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Contribution photo</label>
                                                      <input type="file" class="form-control" id="closing-date" name="file[]" placeholder="DD/MM" multiple="">
                                                    </div>


                                                  


                                                   {{--  <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</button> --}}
                                                    <a href="{{ route('contributions') }}"class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</a>
                                          <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Update {{$title}}</button>
                                                    </div>
                                                 
                                              
                                              </div>
                                              <!-- /.card -->
                                        </div>
                                        
                                         </form>


                                </div>
         
     
 

 


    </div><!--/row-->


    </div><!--/row-->





                   
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