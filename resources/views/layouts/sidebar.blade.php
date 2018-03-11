<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        {{--
        <div class="user-panel">
            <div class="pull-left image">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        --}}
        <!-- search form -->
        {{--
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        --}}
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>
            <li class="">
                <a href="{{url('/home')}}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-wrench"></i>
                    <span>Settings</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('settings/category')}}"><i class="fa fa-exchange"></i>Item Categories</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pie-chart"></i>
                    <span>Items</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('items')}}"><i class="fa fa-eye"></i> All Items</a></li>
                    <li><a href="{{url('items/add')}}"><i class="fa fa-plus-square"></i> New Item</a></li>
                </ul>
            </li>
            <!-- Stocks -->
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Requests</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('requests')}}"><i class="fa fa-eye"></i>All Requests</a></li>
                    <li><a href="{{url('requests/new')}}"><i class="fa fa-plus-square"></i>New Request</a></li>

                </ul>
            </li>
            <!-- Items -->
            <li class="">
                <a href="{{url('stocks')}}">
                    <i class="fa fa-dashboard"></i> <span>Stocks</span>
                </a>
            </li>
            <!-- Users -->
            <li class="">
                <a href="{{url('users')}}">
                    <i class="fa fa-users"></i> <span>Users</span>
                </a>
            </li>
            <li class="">
                <a href="{{url('logout')}}">
                    <i class="fa fa-sign-out"></i> <span>Logout</span>
                </a>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>