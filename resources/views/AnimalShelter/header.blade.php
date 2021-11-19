
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <div class="logo">
                    <img src="/images/flogo.png" alt="Furescue">
                    </div>

                    <!-- Topbar Search -->
                    <!-- <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form> -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->
                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-bell fa-fw"></i>
                                <!-- Counter - Alerts -->
                                @if($shelter->unreadNotifications->count())
                                    <span class="badge badge-danger badge-counter">{{$shelter->unreadNotifications->count()}}</span>
                                @endif
                            </a>
                            <!-- Dropdown - Alerts -->
                            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="alertsDropdown">
                                <h6 class="dropdown-header">
                                   Notifications
                                </h6>
                                @foreach($shelter->unreadNotifications as $notification)
                                    <a style="background-color:#d9dadb" class="dropdown-item d-flex align-items-center" href="{{route('marksingleread',$shelter->email)}}">
                                        <div class="mr-3" style="position:flex">
                                            <div class="icon-circle bg-primary">
                                            <i class="fas fa-exclamation-circle text-white"></i> 
                                            </div>
                                        </div>
                                        <div>
                                            <span style="font-weight:bold">{{$notification->data[0]}}</span>{{$notification->data[1]}} 
                                            <div class="small text-gray-700">
                                                <span>{{$notification->created_at}}</span>
                                            </div>
                                        </div>     
                                    </a>
                                @endforeach
                                @foreach($shelter->readNotifications as $notification)
                                    <a class="dropdown-item d-flex align-items-center" disabled>
                                        <div class="mr-3" style="position:flex">
                                            <div class="icon-circle bg-primary">
                                            <i class="fas fa-exclamation-circle text-white"></i>
                                            </div>
                                        </div>
                                        <div>
                                        <span style="font-weight:bold">{{$notification->data[0]}}</span>{{$notification->data[1]}}          
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
                                        <a  class="dropdown-item text-center medium text-gray-700" href="{{ route('markread',$shelter->email)}}">Mark all as read</a>
                                    </div>    
                                    <div style="text-align:center">
                                        <a style="padding-right:8px" href="{{ route('delete',$shelter->email)}}"><i class="fas fa-trash-alt">&#xE872;Clear</i></a> 
                                    </div>
                                @endif
                            </div>
                        </li>

                       
                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $LoggedUserInfo['shelter_name']}}</span>
                                <img class="img-profile rounded-circle"
                                    src="{{asset('uploads/animal-shelter/profile/'.$shelter->profile)}}">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{url('Profile/'.$shelter->id)}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
