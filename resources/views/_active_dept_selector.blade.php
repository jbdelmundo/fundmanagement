<?php
   // dd($departments);
?>

<div class="panel panel-default">
    <div class="panel-body">
    <select id='active_sem_selector' class="form-control">
        @foreach($departments as $d)
            <option value={{$d->id}}   @if($active_department_id == $d->id) selected @endif >
            	{{$d->short_name}}
        	</option>
        @endforeach
    </select>
    <script>
    	$(document).ready(function(){
    		$('#active_sem_selector').change(function(){
    			newid = $(this).val();
    			window.location = "{{url('/switch_active_dept/')}}"+"/"+newid
    		});
    	});
    </script>
    </div>
</div>