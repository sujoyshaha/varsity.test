   
@extends('layouts.master.dashboard')
@section('backend-content')

     

         


      



               


                   

    <div class="row">



      
      
      <div class="col-lg-6">
                                <div class="card-box">

                                    <h4 class="m-t-0 header-title d-inline">Basic example</h4>

                                  {{--  <button type="button" class="btn btn-lg btn-info float-right"  data-toggle="modal" data-target="#myModal"> <i class="  mdi mdi-plus-circle

"></i> <span>Add</span> </button> --}}


                                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
  Launch demo modal
</button>

{{-- 
<button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#myModal">Standard Modal</button> --}}





        
                                    <table class="table mb-0">
                                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Year</th>
                                <th>Opening Date</th>
                                <th>Closing Date</th>
                                <th>Final Date</th>
                                <th>Progress</th>
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
                            <td>
                              <div class="progress progress-xs">
                                <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                              </div>
                            </td>
                            <td><span class="badge bg-danger">55 days</span></td>

                            <td>{{ $ay->final_date }}</td>
                          </tr>

                        @endforeach
                        </tbody>
                                    </table>
                                </div> <!-- end card-box -->
          </div>
     
    {{--  <div class="col-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title">Input Types</h4>
                                    <p class="text-muted m-b-30 font-14">
                                        Most common form control, text-based input fields. Includes support for all HTML5 types: <code>text</code>, <code>password</code>, <code>datetime</code>, <code>datetime-local</code>, <code>date</code>, <code>month</code>, <code>time</code>, <code>week</code>, <code>number</code>, <code>email</code>, <code>url</code>, <code>search</code>, <code>tel</code>, and <code>color</code>.
                                    </p>
        
                                    <form class="form-horizontal">
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Text</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="Some text value...">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label" for="example-email">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Password</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" value="password">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Placeholder</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="placeholder">
                                            </div>
                                        </div>
                                      
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Readonly</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" readonly="" value="Readonly value">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Disabled</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" disabled="" value="Disabled value">
                                            </div>
                                        </div>
        
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Static control</label>
                                            <div class="col-sm-10">
                                                <input type="text" readonly="" class="form-control-plaintext" value="email@example.com">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Helping text</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" placeholder="Helping text">
                                                <span class="help-block"><small>A block of help text that breaks onto a new line and may extend beyond one line.</small></span>
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Input Select</label>
                                            <div class="col-sm-10">
                                                <select class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                                <h6>Multiple select</h6>
                                                <select multiple="" class="form-control">
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                </select>
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Default file input</label>
                                            <div class="col-sm-10">
                                                <input type="file" class="form-control">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Date</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="date" name="date">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Month</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="month" name="month">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Time</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="time" name="time">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Week</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="week" name="week">
                                            </div>
                                        </div>
        
                                        <div class="form-group row">
                                            <label class="col-sm-2 col-form-label">Number</label>
                                            <div class="col-sm-10">
                                                <input class="form-control" type="number" name="number">
                                            </div>
                                        </div>
        
                                    </form>
        
                                </div> <!-- end card-box -->
      
      </div>
 --}}


 {{$ays}}


    </div><!--/row--><!-- Button trigger modal -->




<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form role="form" method="post" action="{{route('post-academic-year')}}">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Academic Year</label>
                            <input type="text" class="form-control" id="year" name="year" placeholder="2019">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Opening Date</label>
                            <input type="date" class="form-control" id="opening-date" name="opening_date" placeholder="DD/MM">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Closing Date</label>
                            <input type="date" class="form-control" id="closing-date" name="closing_date" placeholder="DD/MM">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Final Date</label>
                            <input type="date" class="form-control" id="final-date" name="final_date" placeholder="DD/MM">
                        </div>

                       <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="far fa-times-circle"></i> Cancle</button>
                     <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Add {{$title}}</button>

                    </div>

            </div>
            <!-- /.card -->
        </div>
     
        </form>
    </div>
   
</div>
</div>
</div>





                   
@endsection




@section('scripts')



@endsection