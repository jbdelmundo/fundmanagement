@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Module Permissions</h1>
	</div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
    <select id='active_module_user_selector' class="form-control">
        <?php 
            //get the variables here instead in the controller
            $active_user_id = session('active_user_id',1 ) ;
            $modules = session('modules',$modules) ;
            $users = \App\User::all();
        ?>
        @foreach($users as $user)
            <option value={{$user->id}}   @if($active_user_id == $user->id) selected @endif >
            	{{$user->username}}
        	</option>
        @endforeach
    </select>
    <script>
    	$(document).ready(function(){
    		$('#active_module_user_selector').change(function(){
    			newid = $(this).val();
    			window.location = "{{url('module_permissions')}}"+"/"+newid
    		});
    	});
    </script>
    </div>
</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php	$user = \App\User::find($active_user_id);	?>
			Modules for {{$user->username}}
		</div>
		<div class="panel-body">
			
			<div class="table-responsive">
				{{ Form::open(['url' => 'module_permissions' , 'class' => 'form-horizontal']) }}
				{{ Form::hidden('user_id',$active_user_id)}}
				@foreach($modules as  $module)
					{{Form::checkbox($module->id, $user->id, $module->selected)}}
						{{$module->module}}
					<br>
				@endforeach
				<br>
				{{ Form::submit('Submit',  ['class'=>'btn btn-success'])}}
				{{ Form::close() }}		
			</div>
			
		</div>
	</div>

@endsection