
@extends('layouts.master.dashboard')
@section('backend-content')


@section('academic-css')


    <style type="text/css">

        .table th, .table td {

            vertical-align: middle;

        }


    </style>

@endsection



<div class="col-lg-10 ">

  



    <div class="row justify-content-center">




        <div class="card-box col-8">


            <form role="form" method="post" action="{{route('post-studentarticle')}}" enctype="multipart/form-data">

                @csrf

                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Academic Year</label>
                        <select class="form-control" id="role" name="year">
                            @foreach($acys as $acy)
                                <option value="{{$acy->year}}">{{$acy->year}}</option>

                            @endforeach
                            {{--          @foreach($acys as $acy)
            <option value="{{ $acy->id }}" {{ $acy->id == $ay->year ? 'selected="selected"' : '' }}>{{ $acy->year }}</option>

            @endforeach --}}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Article title</label>
                        <input type="text" class="form-control" id="year" name="title" placeholder="2019" value=" {{old('title')}}">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Article doc file</label>
                        <input type="file" class="form-control" id="opening-date" name="file_name" placeholder="DD/MM" value="{{old('doc')}}" >
                    </div>

                    <div class="form-group">
                        <label for="exampleInputPassword1">Article photo</label>
                        <input type="file" class="form-control" id="closing-date" name="file[]" placeholder="DD/MM" multiple="" value="{{old('files')}}">
                    </div>

                     <div class="form-group">
                        <label> <input  type="checkbox" id="checkme" /> Agree to Terms and Conditions </label>



                       
  {{-- <input type="submit" name="sendNewSms" class="inputButton" disabled="disabled" id="sendNewSms" value=" Send " /> --}}
                        

                        
                    </div>

                      






                    {{-- <a href="{{ route('articles') }}" class="btn btn-secondary" >Back</a> --}}
                    <a href="{{ route('studentarticles') }}"class="btn btn-secondary" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</a>
                    <button type="submit" class="btn  btn-success inputButton " disabled="disabled" id="sendNewSms"><i class="fas fa-plus"></i> Add {{$title}}</button>
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


    <script>


         var checker = document.getElementById('checkme');
         var sendbtn = document.getElementById('sendNewSms');
         // when unchecked or checked, run the function
         checker.onchange = function(){
        if(this.checked){
            sendbtn.disabled = false;
        } else {
            sendbtn.disabled = true;
        }

        }
        



    </script>

@endsection