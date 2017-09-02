<?php
	$modules = \App\ModuleUser::where('user_id',\Auth::user()->id)->get()->toArray();
	foreach( $modules as $key => $value){
		$modules[$key] = $value['module_id'];
	}
?>
<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="side-menu">
            <li class="sidebar-search">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
                <!-- /input-group -->
            </li>
            <li>
                <a href="{{url('dashboard')}}"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>
			@if(in_array(1,$modules))
				<li>
					<a href="{{url('collection')}}"><i class="fa fa-table fa-fw"></i> Collection</a>
				</li>
			@endif
			@if(in_array(2,$modules))
				<li>
					<a href="{{url('endorsement')}}"><i class="fa fa-bar-chart-o fa-fw"></i> Endorsement</a>
				</li>
			@endif
			@if(in_array(3,$modules))
				<li>
					<a href="{{url('requests')}}"><i class="fa fa-bar-chart-o fa-fw"></i> Requests</a>
				</li>
			@endif
			@if(in_array(4,$modules))
				<li>
					<a href="{{url('approval')}}"><i class="fa fa-edit fa-fw"></i> Approval</a>
				</li>
			@endif
			@if(in_array(5,$modules))
				<li>
					<a href="{{url('usermanagement')}}"><i class="fa fa-tasks fa-fw"></i> User Management</a>
				</li>
			@endif
			@if(in_array(6,$modules))
				<li>
					<a href="{{url('semestermanagement')}}"><i class="fa fa-tasks fa-fw"></i> Semester Management</a>
				</li>
			@endif
			@if(in_array(7,$modules))
				<li>
					<a href="{{url('puchasehistory')}}"><i class="fa fa-calendar fa-fw"></i> Purchase History</a>
				</li>
			@endif
			@if(in_array(8,$modules))
				<li>
					<a href="{{url('refunds')}}"><i class="fa fa-credit-card fa-fw"></i> Refunds</a>
				</li>
			@endif
			@if(in_array(9,$modules))
				<li>
					<a href="{{url('module_permissions')}}"><i class="fa fa-check-square-o fa-fw"></i> Module Permissions</a>
				</li>
			@endif
			@if(in_array(10,$modules))
				<li>
					<a href="{{url('usagestatisics')}}"><i class="fa fa-bar-chart-o fa-fw"></i> EResource Usage Statistics</a>
				</li>
			@endif
            
        </ul>
        <!-- /#side-menu -->
    </div>
    <!-- /.sidebar-collapse -->
</nav>
            