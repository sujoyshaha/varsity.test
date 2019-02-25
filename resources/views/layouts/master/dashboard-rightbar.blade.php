           <!-- Right Sidebar -->
            <div class="right-bar">
                <div class="rightbar-title">
                    <a href="javascript:void(0);" class="right-bar-toggle float-right">
                        <i class="dripicons-cross noti-icon"></i>
                    </a>
                    <h5 class="m-0">Settings</h5>
                </div>
                <div class="slimscroll-menu">
                    <!-- User box -->
                    <div class="user-box">
                        <div class="user-img">
                            <img 

                            

                              <img 

                             @if(Auth::user()->photo)


                        src="{{asset('upload/' .Auth::user()->photo)}}"

                        {{--    @if(Auth::user()->photo)
                                src="{{asset('upload/' .Auth::user()->photo)}}" 
                                --}}        
                        @else

                        src="{{asset('images/no-image.png')}}"
                        @endif

                        alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">


                            <a href="" class="user-edit"><i class="mdi mdi-pencil"></i></a>
                        </div>
                        
                        <h5><a href="#">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</a> </h5>
                        <p class="text-muted mb-0"><small>

                           {{--  @if($user->role ->1) --}}

                                Superadmin

                         {{--    @else  --}}

                            

 {{-- @endif --}}
                    </small></p>
                    </div>

                   {{--  <!-- Settings -->
                    <hr class="mt-0" />
                    <h5 class="pl-3">Basic Settings</h5>
                    <hr class="mb-0" />

                    <div class="p-3">
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="checkbox1" type="checkbox" checked>
                            <label for="checkbox1">
                                Notifications
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="checkbox2" type="checkbox" checked>
                            <label for="checkbox2">
                                API Access
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="checkbox3" type="checkbox">
                            <label for="checkbox3">
                                Auto Updates
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-2">
                            <input id="checkbox4" type="checkbox" checked>
                            <label for="checkbox4">
                                Online Status
                            </label>
                        </div>
                        <div class="checkbox checkbox-primary mb-0">
                            <input id="checkbox5" type="checkbox" checked>
                            <label for="checkbox5">
                                Auto Payout
                            </label>
                        </div>
                    </div>
 --}}

                   {{--  <!-- Timeline -->
                    <hr class="mt-0" />
                    <h5 class="pl-3 pr-3">Messages <span class="float-right badge badge-pill badge-danger">25</span></h5>
                    <hr class="mb-0" />
                    <div class="p-3">
                        <div class="inbox-widget">
                            <a href="#">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/avatar-1.jpg" class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Chadengle</p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                    <p class="inbox-item-date">13:40 PM</p>
                                </div>
                            </a>
                            <a href="#">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Tomaslau</p>
                                    <p class="inbox-item-text">I've finished it! See you so...</p>
                                    <p class="inbox-item-date">13:34 PM</p>
                                </div>
                            </a>
                            <a href="#">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/avatar-3.jpg" class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Stillnotdavid</p>
                                    <p class="inbox-item-text">This theme is awesome!</p>
                                    <p class="inbox-item-date">13:17 PM</p>
                                </div>
                            </a>
                            <a href="#">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/avatar-4.jpg" class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Kurafire</p>
                                    <p class="inbox-item-text">Nice to meet you</p>
                                    <p class="inbox-item-date">12:20 PM</p>
                                </div>
                            </a>
                            <a href="#">
                                <div class="inbox-item">
                                    <div class="inbox-item-img"><img src="assets/images/users/avatar-5.jpg" class="rounded-circle" alt=""></div>
                                    <p class="inbox-item-author">Shahedk</p>
                                    <p class="inbox-item-text">Hey! there I'm available...</p>
                                    <p class="inbox-item-date">10:15 AM</p>
                                </div>
                            </a>
                        </div> <!-- end inbox-widget -->
                    </div> <!-- end .p-3--> --}}
                </div> <!-- end slimscroll-menu-->
            </div>
            <!-- /Right-bar -->