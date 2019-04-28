   <!-- ========== Left Sidebar Start ========== -->
            <div class="left-side-menu">

                <div class="slimscroll-menu">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <ul class="metismenu" id="side-menu">

                            <li class="menu-title">Navigation</li>

                        

                            @if(Auth::guard('admin')->check())

                            <li>
                                <a href="{{route('dashboard')}}">
                                    <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span>
                                </a>
                            </li> 
                             <li>
                                <a href="{{route('user-profile')}}">
                                    <i class="mdi mdi-account-circle"></i> <span> Profile </span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript: void(0);"><i class=" mdi mdi-calendar-clock"></i><span> Academic Years </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">

                            <li>
                                <a href="{{route('academic-years')}}">
                                    <i class="mdi mdi-calendar-clock"></i> <span> Academic Years List </span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('add-academic-year')}}">
                                    <i class="mdi mdi-calendar-clock"></i> <span> Add Academic Year </span>
                                </a>
                            </li>


                        </ul>
                        </li>

                            <li>
                                <a href="javascript: void(0);"><i class=" mdi mdi-account-group"></i><span> Departments </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">

                                    <li> <a href="{{route('departments')}}"><i class=" mdi mdi-account-group"></i> <span> Department List </span></a></li>

                                    <li><a href="{{route('add-department')}}"><i class=" mdi mdi-account-group"></i> <span> Add Department </span></a> </li>

                            
                            
                            </ul>

                            </li>


                             <li>
                                <a href="{{route('admin-articles')}}">
                                    <i class=" mdi mdi-book-open-page-variant"></i> <span> Articles </span>
                                </a>
                            </li>       


                            <li>
                                <a href="javascript: void(0);"><i class="  mdi mdi-chart-line"></i><span> Reports </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">

                                    <li>
                                        <a href="{{route('number-of-articles')}}">
                                        <i class="  mdi mdi-chart-line"></i> <span> Number Of Articles </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{route('percentage-of-articles')}}">
                                        <i class="  mdi mdi-chart-line"></i> <span> Percentage Of Articles </span>
                                        </a>
                                    </li>


                                    
                            
                            
                            </ul>

                            </li>




                           
                            

                           <li>
                                <a href="javascript: void(0);"><i class="mdi mdi-account-multiple"></i><span> Users </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                <a href="{{route('add-user')}}">
                                    <i class="mdi mdi-account-multiple-plus"></i> <span> Add user </span>
                                </a>
                                    </li>

                                <li>
                                    <a href="{{route('alladmin')}}">
                                    <i class=" mdi mdi-account-multiple"></i> <span> All Admin</span>
                                    </a>
                                </li>                                

                                <li>
                                    <a href="{{route('allmanager')}}">
                                    <i class=" mdi mdi-account-multiple"></i> <span> All Managers</span>
                                    </a>
                                </li>
                                 <li>
                                    <a href="{{route('allcoordinator')}}">
                                    <i class=" mdi mdi-account-multiple"></i> <span> All Coordinator</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('allstudent')}}">
                                    <i class=" mdi mdi-account-multiple"></i> <span> All Student</span>
                                    </a>
                                </li>

                                <li>
                                    <a href="{{route('allfaculty')}}">
                                    <i class=" mdi mdi-account-multiple"></i> <span> All Faculty</span>
                                    </a>
                                </li>


                                </ul>
                            </li>


                            @elseif(Auth::guard('student')->check())

                             <li>
                                <a href="{{route('student-dashboard')}}">
                                    <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span>
                                </a>
                            </li>                             

                            <li>
                                <a href="{{route('student-profile')}}">
                                    <i class=" mdi mdi-account-circle"></i> <span> Profile </span>
                                </a>
                            </li>

                            

                            <li>
                                <a href="javascript: void(0);"><i class=" mdi mdi-book-open-page-variant"></i><span> Articles </span> <span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li><a href="{{route('studentarticles')}}">
                                    <i class=" mdi mdi-book-open-page-variant"></i> <span> Articles List </span>
                                </a></li> 

                                <li><a href="{{route('add-studentarticle')}}">
                                    <i class="mdi mdi-book-open-page-variant"></i> <span>Add Articles</span>
                                </a></li>
                                     
                                </ul>
                            </li>

                            @elseif(Auth::guard('faculty')->check())


                            <li>
                                <a href="{{route('faculty-dashboard')}}">
                                    <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span>
                                </a>
                            </li>



                            <li>
                                <a href="{{route('faculty-profile')}}">
                                    <i class="mdi mdi-account-circle"></i> <span> Profile </span>
                                </a>
                            </li>

                             <li>
                                <a href="{{route('facu-articles')}}">
                                    <i class="mdi mdi-book-open-page-variant"></i> <span> Articles </span>
                                </a>
                            </li>

                            @elseif(Auth::guard('coordinator')->check())
                              <li>
                                <a href="{{route('cord-dashboard')}}">
                                    <i class="mdi mdi-calendar-check"></i> <span> Dashoboard </span>
                                </a>
                            </li>                          

                             <li>
                                <a href="{{route('coordinator-profile')}}">
                                    <i class="mdi mdi-account-circle"></i> <span> Profile </span>
                                </a>
                            </li>

                             <li>
                                <a href="{{route('cord-articles')}}">
                                    <i class="mdi mdi-book-open-page-variant"></i> <span> Articles </span>
                                </a>
                            </li>          




                            @elseif(Auth::guard('manager')->check())



                            <li>
                                <a href="{{route('manager-dashboard')}}">
                                    <i class="mdi mdi-view-dashboard"></i> <span> Dashboard </span>
                                </a>
                            </li>



                             <li>
                                <a href="{{route('manager-profile')}}">
                                    <i class="mdi mdi-account-circle"></i> <span> Profile </span>
                                </a>
                            </li>

                             <li>
                                <a href="{{route('manager-articles')}}">
                                    <i class="mdi mdi-book-open-page-variant"></i> <span> Articles </span>
                                </a>
                            </li>

                            @endif



                        </ul>

                    </div>
                    <!-- Sidebar -->

                    <div class="clearfix"></div>

                </div>
                <!-- Sidebar -left -->

            </div>
            <!-- Left Sidebar End -->