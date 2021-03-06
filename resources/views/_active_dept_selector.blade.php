<div class="panel panel-default">
    <div class="panel-body">
    <select id='active_dept_selector' class="form-control">
        <?php 
            //get the variables here instead in the controller
            $active_department_id = session('active_dept_id',1 ) ;
            $departments = \App\Department::all();
        ?>
        @foreach($departments as $d)
            <option value={{$d->id}}   @if($active_department_id == $d->id) selected @endif >
            	{{$d->short_name}}
        	</option>
        @endforeach
    </select>
    <script>
    	$(document).ready(function(){
    		$('#active_dept_selector').change(function(){
    			newid = $(this).val();
    			window.location = "{{url('/switch_active_dept/')}}"+"/"+newid
    		});
    	});
    </script>
    </div>
</div>