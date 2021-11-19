                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <div class="logo">
                    <img src="/images/flogo.png" alt="Furescue">
                    </div>  
                    <!-- Topbar Search -->
                   
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->     
                                @if($admin->unreadNotifications->count())
                                    <span class="badge badge-danger badge-counter">{{$admin->unreadNotifications->count()}}</span>
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                    Notifications
                                </h6>
                                @foreach($admin->unreadNotifications as $notification)
                                    <a style="background-color:#d9dadb" class="dropdown-item d-flex align-items-center" href="{{route('marksingleread','admin@gmail.com')}}">
                                        <div class="mr-3" style="position:flex">
                                            <div class="icon-circle bg-primary">
                                            <i class="fas fa-exclamation-circle text-white"></i> 
                                            </div>
                                        </div>
                                        <div>
                                            <span style="font-weight:bold">{{$notification->data[0]}} {{$notification->data[1]}}
                                            <div class="small text-gray-700">
                                                <span>{{$notification->created_at}}</span>
                                            </div>
                                        </div>     
                                    </a>
                                @endforeach
                                @foreach($admin->readNotifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center" disabled>
                                        <div class="mr-3" style="position:flex">
                                            <div class="icon-circle bg-primary">
                                            <i class="fas fa-exclamation-circle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                        <span style="font-weight:bold">{{$notification->data[0]}}</span> {{$notification->data[1]}}            
                                            <div class="small text-gray-500">
                                                <span>{{$notification->created_at}}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                                @if(empty($notification))
                                    <div>
                                        <label style="padding:10px">You don't have any notifications at this moment</label>
                                    </div>
                                @else
                                    <div>
                                        <a  class="dropdown-item text-center medium text-gray-700" href="{{ route('markread','admin@gmail.com')}}">Mark all as read</a>
                                    </div>    
                                    <div style="text-align:center">
                                        <a style="padding-right:8px" href="{{ route('delete','admin@gmail.com')}}"><i class="fas fa-trash-alt">&#xE872;Clear</i></a> 
                                    </div>
                                @endif
                            </div>
                        </li>

                        
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                <img class="img-profile rounded-circle"
                                    src="{{asset('img/undraw_profile_2.svg')}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
