<div class="panel panel-default">
    <div class="panel-body">
    <select id='active_sem_selector' class="form-control">
        @foreach($aysems as $aysem)
            <option value={{$aysem->aysem}}   @if($active_sem_id == $aysem->aysem) selected @endif >
            	{{\App\Aysem::short_name($aysem)}}
        	</option>
        @endforeach
    </select>
    <script>
    	$(document).ready(function(){
    		$('#active_sem_selector').change(function(){
    			newid = $(this).val();
    			window.location = "{{url('/switch_active_aysem/')}}"+"/"+newid
    		});
    	});
    </script>
    </div>
</div>