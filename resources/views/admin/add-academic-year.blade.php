   
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

                   

    <div class="row justify-content-center">

      
      
     
                               <div class="card-box col-8">
                                
        
      <form role="form" method="post" action="{{route('post-academic-year')}}">

                                                  @csrf
                                                  <div class="card-body">
                                                    <div class="form-group">
                                                      <label for="exampleInputEmail1">Academic Year</label>
                                                      <input type="text" class="form-control" id="year" name="year" placeholder="2019" >
                                                    </div>
                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Opening Date</label>
                                                      <input type="date" class="form-control" id="opening_date" name="opening_date" placeholder="DD/MM" >

                                                      
                                                    </div>

                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Closing Date</label>
                                                      <input type="date" class="form-control" id="closing-date" name="closing_date" placeholder="DD/MM" >
                                                    </div>


                                                    <div class="form-group">
                                                      <label for="exampleInputPassword1">Final Date</label>
                                                      <input type="date" class="form-control" id="final-date" name="final_date" placeholder="DD/MM" >
                                                    </div>


                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</button>
                                          <button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Add {{$title}}</button>
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
{{-- <script type="text/javascript" src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> --}}
<script>


 var dt= new Date();
   var yyyy = dt.getFullYear().toString();
   var mm = (dt.getMonth()+1).toString(); // getMonth() is zero-based
   var dd  = dt.getDate().toString();
   var min = yyyy +'-'+ (mm[1]?mm:"0"+mm[0]) +'-'+ (dd[1]?dd:"0"+dd[0]); // padding

$('#opening_date, #closing-date, #final-date').prop('min',min);

</script>

{{-- <script>


 var dtt= new Date();
   var yyyyy = dtt.getFullYear().toString();
   var mmm = (dtt.getMonth()+1).toString(); // getMonth() is zero-based
   var ddd  = dtt.getDate().toString();
   var minn = yyyyy +'-'+ (mmm[1]?mmm:"0"+mmm[0]) +'-'+ (ddd[1]?ddd:"0"+ddd[0]); // padding

$('#closing_date').prop('minn',minn);

</script> --}}



@endsection