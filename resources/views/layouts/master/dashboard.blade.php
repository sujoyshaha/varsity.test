<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Magazine</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <!-- <link rel="shortcut icon" href="assets/images/favicon.ico">-->

        <!-- jvectormap -->
        {{-- <link href="{{ asset('assets/libs/jqvmap/jqvmap.min.css') }}" rel="stylesheet" /> --}}

           <!-- Sweet Alert css -->
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        

        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>





        <!-- Icons css -->
        <link href="{{ asset('assets/libs/@mdi/font/css/materialdesignicons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/dripicons/webfont/webfont.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/simple-line-icons/css/simple-line-icons.css') }}" rel="stylesheet" type="text/css" />

        <!-- App css -->
        <!-- build:css -->
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet"  type="text/css" />

        @yield('academic-css')

        <!-- endbuild -->

    </head>




    <body>
        @include('layouts.master.dashboard-header')
        @include('layouts.master.dashboard-sidebar')


        <!-- Page Content Start -->
            <div class="content-page">
                <div class="content">
                    <div class="container-fluid">


                        <div class="row">
    <div class="col-lg-12">

        <!--  ==================================SESSION MESSAGES==================================  -->
        @if (session()->has('message'))
            <div class="alert alert-{!! session()->get('type')  !!} alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                {!! session()->get('message')  !!}
            </div>
        @endif
    <!--  ==================================SESSION MESSAGES==================================  -->


    <!--  ==================================VALIDATION ERRORS==================================  -->
        @if($errors->any())
            @foreach ($errors->all() as $error)

                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    {!!  $error !!}
                </div>

        @endforeach
     @endif
    <!--  ==================================SESSION MESSAGES==================================  -->

  </div></div>

                        <!-- Page title box -->
                        <div class="page-title-box">
                            <ol class="breadcrumb float-right">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Greeva</a></li>
                                <li class="breadcrumb-item active">{{$title}}</li>
                            </ol>
                            <h4 class="page-title">{{$title}}</h4>
                        </div>
                        <!-- End page title box -->

        @yield('backend-content')

    <!-- end row -->            

                    </div>
                </div>
            </div>
            <!-- End Page Content-->


   



        </div>
        <!-- End #wrapper -->


        @include('layouts.master.dashboard-footer')
        @include('layouts.master.dashboard-rightbar')


        <!-- jQuery  -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>


              <!-- Datatable js -->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


        <!-- Key Tables -->
        <script src="{{ asset('assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>

        <!-- Selection table -->
        <script src="{{ asset('assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- KNOB JS -->
        <script src="{{ asset('assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>
        <!-- Chart JS -->
        <script src="{{ asset('assets/libs/chart.js/Chart.bundle.min.js') }}"></script>

        <!-- Jvector map -->
       {{--  <script src="{{ asset('assets/libs/jqvmap/jquery.vmap.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('assets/libs/jqvmap/maps/jquery.vmap.usa.js') }}"></script> --}}


         <!-- sparkline chart-->
        <script src="{{ asset('assets/libs/Sparkline/jquery.sparkline.min.js') }}"></script>
        {{-- <script src="{{ asset('assets/js/jquery.charts-sparkline.js') }}"></script> --}}

         <script src="{{ asset('assets/libs/flot/jquery.flot.pie.js') }}"></script>
  

        <!-- Dashboard Init JS -->
        {{-- <script src="{{ asset('assets/js/jquery.dashboard.js') }}"></script> --}}

        <!-- App js -->
        <script src="{{ asset('assets/js/jquery.core.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.app.js') }}"></script>

           <!-- Sweet Alert Js  -->
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.sweet-alert.init.js') }}"></script>


           <script>
            @if (session()->has('message'))
                swal({
                title: "{!! session()->get('title')  !!}",
                text: "{!! session()->get('message')  !!}",
                type: "{!! session()->get('type')  !!}",
                confirmButtonText: "OK"
            });
                {{ Session::forget('message')}}
            @endif



        </script>

        @yield('scripts')


        @yield('datatable-files')







{{-- 
        <script>
            $(document).ready(function() {
                // Default Datatable
                $('#datatable').DataTable({
                    "pageLength": 5,
                    "searching": false,
                    "lengthChange": false
                });
            } );
        </script> --}}

      <script type="text/javascript">
            $(document).ready(function() {

                // // Default Datatable
                // $('#datatable').DataTable({
                //     keys: true
                // });

                // //Buttons examples
                // var table = $('#datatable-buttons').DataTable({
                //     lengthChange: false,
                //     buttons: ['copy', 'print']
                // });

                // Multi Selection Datatable
                $('#selection-datatable').DataTable({
                    select: {
                        style: 'multi'
                    }
                });

                // table.buttons().container()
                //         .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
            } );

        </script>


        
     

    </body>
</html>