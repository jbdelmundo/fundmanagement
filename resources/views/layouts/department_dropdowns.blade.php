<div class="row">
<div class="col-lg-12">
        <div class="panel panel-default">
            
            <div class="panel-body">
            	

            	{!! Form::open(['class'=>'form-inline']) !!}
            	{!! Form::label('Select a department' ) !!}
            	
            	<?php 
            		$departments = [];
            		foreach (\App\Department::all() as $key => $dept) {
            			$departments[$dept->id] = $dept->short_name;
            		}

            	 ?>
    			{!! Form::select('department_id', $departments,['class'=>'form-control' ]) !!}
    			{!! Form::submit('Change', ['class'=>'btn' ]) !!}
    			{!! Form::close() !!}
        	</div>
    	</div>
</div>
</div>