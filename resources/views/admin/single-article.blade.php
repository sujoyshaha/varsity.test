
@extends('layouts.master.dashboard')
@section('backend-content')


@section('academic-css')


    <style type="text/css">

        .table th, .table td {

            vertical-align: middle;

        }
.allh5 h5{

    line-height: 24px;
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

                <div class="allh5">

                <h5>Article Name:  {{ $con->title }}</h5>

                <h5>Department:  {{ $con->department->name }}</h5>
                <h5>Submitted At:  {{ $con->created_at }}</h5>
                {{-- <h5>Submitted By:  {{ $con->student->first_name }} {{ $con->student->first_name }}</h5> --}}
                <h5>Academic Year:  {{ $con->ayear->year }}</h5>
                <h5>Contribution ID:  {{ $con->id }}</h5>
                <h5>Last Modified At:  {{ $con->updated_at }}</h5>


                </div>
            </div><!-- end card-box-->

            <!-- end card-box-->

        </div>

        <div class="col-xl-8">

            <div class="card-box">

                <h4 class="header-title">Article Photos</h4>


                @foreach($artimgs as $ai)
                    @if($ai->photo)

                    <a href="{{asset('upload/' .$ai->photo)}}">
                        <img src="{{asset('upload/' .$ai->photo)}}" class="avatar  img-thumbnail" alt="avatar" style="width: 30%;margin-right: 10px;"> </a>
                    @else
                        <img src="{{asset('assets/images/no-image.png')}}" class="avatar  img-thumbnail" alt="avatar">
                    @endif
                @endforeach



            </div><!-- end card-box-->

            <!-- end card-box-->




                       <div class="card-box">

                <h4 class="header-title">Article Files </h4>

            <a href="{{ asset('upload/'.$con->file_name) }}"> <img src="{{asset('assets/images/document-management-big.png')}}" class="avatar  img-thumbnail" alt="avatar" style="width: 30%;margin-right: 10px;"> </a>


                

            </div><!-- end card-box-->




                              
                        <h2 class="text-center">Comments</h2>
                        
                        <div class="card">


                            @foreach($comments as $com)
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                                        <p class="text-secondary text-center">15 Minutes Ago</p>
                                    </div>
                                    <div class="col-md-10">
                                        <p>
                                           

                                                @if ($com->user_role == 1)

                                                <strong>{{Auth::guard()->user()->first_name}}</strong>

                                                @elseif ($com->user_role == 3)

                                                <strong>{{Auth::guard()->user('student')->first_name}}</strong>


                                                @endif




                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>

                                       </p>
                                       <div class="clearfix"></div>
                                        <p>{{ $com->comment }}</p>
                                     
                                    </div>
                                </div>
                            
                            </div>

                            @endforeach

                  {{--           <div class="card-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <img src="https://image.ibb.co/jw55Ex/def_face.jpg" class="img img-rounded img-fluid"/>
                                        <p class="text-secondary text-center">15 Minutes Ago</p>
                                    </div>
                                    <div class="col-md-10">
                                        <p>
                                            <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>Maniruzzaman Akash</strong></a>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                            <span class="float-right"><i class="text-warning fa fa-star"></i></span>

                                       </p>
                                       <div class="clearfix"></div>
                                        <p>Lorem Ipsum is simply dummy text of the pr make  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                     
                                    </div>
                                </div>
                            
                            </div>
 --}}

                    @if(Auth::guard('admin')->check())


                          <div class="tab-pane" id="add-comment">
                    <form action="{{ route('post-comment', $con->id) }}" method="post" class="form-horizontal" id="commentForm" role="form"> 
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                              <textarea class="form-control" name="comment" id="addComment" rows="5"></textarea>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Summit comment</button>
                            </div>
                        </div>            
                    </form>
                </div>

                @elseif(Auth::guard('coordinator')->check())
                                   
                          <div class="tab-pane" id="add-comment">
                    <form action="{{ route('post-cord-comment', $con->id) }}" method="post" class="form-horizontal" id="commentForm" role="form"> 
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                              <textarea class="form-control" name="comment" id="addComment" rows="5"></textarea>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Summit comment</button>
                            </div>
                        </div>            
                    </form>
                </div>


                  @elseif(Auth::guard('student')->check())

                                 <div class="tab-pane" id="add-comment">
                    <form action="{{ route('post-studentcomment', $con->id) }}" method="post" class="form-horizontal" id="commentForm" role="form"> 
                        @csrf
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-12">
                              <textarea class="form-control" name="comment" id="addComment" rows="5"></textarea>
                            </div>
                        </div>
                    
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">                    
                                <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Summit comment</button>
                            </div>
                        </div>            
                    </form>
                </div>



                    @endif

                        </div>

        </div>

    

        <!-- end card-box-->

    </div>


    






    </div><!--/row-->


</div><!--/row-->






@endsection




@section('scripts')



@endsection