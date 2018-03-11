<header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>A</b>LT</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Stock</b>TAKING</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <?php
                            $user_id = \Illuminate\Support\Facades\Auth::user()->id;
                            $users = \App\User::find($user_id);
                            $role = \App\Libraries\Utilities::getRole($user_id);
                            $count = count($users->unreadNotifications);
                            $photo = \App\Libraries\Utilities::getUserPhoto($user_id);
                            $date_added = date('d-m-Y', strtotime($users->created_at));
                        ?>
                        <span class="label label-danger">{{$count}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        @if($count > 0)
                        <li class="header">You have {{$count}}
                            <?php $value = ($count > 1)? 'notifications': 'notification'; ?>
                            {{$value}}
                        </li>
                        <li>
                            <!-- loop through all notifications for authenticated user -->
                            <ul class="menu">
                                @foreach($users->unreadNotifications as $notification)
                                    <?php
                                    $data = $notification->data;
                                    $request_id = $data['request_id'];
                                    $date = $data['notifyDate']['date'];
                                    $item = $data['item_name'];
                                    $notifyDate = date('d-m-Y', strtotime($date));
                                    $notify_id = $notification->id;

                                    ?>
                                    @if($notification->type == 'App\Notifications\notifySupervisorOfRequests')
                                        <!--Get the necessary data -->

                                        <li onclick="markAsReadFxn('<?php echo $notify_id; ?>')">
                                            <a href="{{url('/requests/request/'.$request_id)}}">
                                                <i class="fa fa-pencil text-aqua"></i> A new request to alter the stock of <br> {{$item}}.
                                                <em><small>{{$notifyDate}}</small></em>
                                            </a>
                                        </li>
                                    @elseif($notification->type == 'App\Notifications\notifyStoreKeeperOfRequestStatus')
                                            <li onclick="markAsReadFxn('<?php echo $notify_id; ?>')">
                                                <a href="{{url('/requests/request/'.$request_id)}}" >
                                                    <i class="fa fa-pencil text-aqua"></i> Request status has changed for  <br> {{$item}}.
                                                    <em><small>{{$notifyDate}}</small></em>
                                                </a>
                                            </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                        @endif
                        {{--
                        <li class="footer"><a href="#">View all</a></li>
                        --}}
                    </ul>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{asset('uploads/users/'.$photo)}}" class="user-image" alt="User Image">
                        <span class="hidden-xs">{{ucfirst($users->name)}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{asset('uploads/users/'.$photo)}}" class="img-circle" alt="User Image">

                            <p>
                                {{ucfirst($users->name)}} - {{$role}}
                                <small>User since {{$date_added}}</small>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!--
                        <li class="user-body">
                            <div class="row">
                                <div class="col-xs-4 text-center">
                                    <a href="#">Followers</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Sales</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Friends</a>
                                </div>
                            </div>
                        </li>
                        -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a  href="#" class="btn btn-default btn-flat" data-toggle="modal" data-target="#user_id">Edit Password</a>

                            </div>
                            <div class="pull-right">
                                <a href="{{url('logout')}}" class="btn btn-default btn-flat">Logout</a>
                            </div>
                        </li>

                    </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<div class="modal fade" id="user_id" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">[Change Password]</h4>
            </div>
            <form class="" method="post" action="{{url('users/change-password')}}">
                {{csrf_field()}}
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{$user_id}}">
                    <p>
                        <label>New Password</label>
                        <input type="password" name="password1" required  placeholder="Enter Password" class="form-control">

                    </p>
                    <p>
                        <label>Repeat New Password</label>
                        <input type="password" name="password2" required placeholder="Repeat New Password" class="form-control">
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>