<div class="panel panel-default">
    <div class="panel-body">
    <select id='active_sem_selector' class="form-control">

        <?php 
            //get the variables here instead in the controller
            $active_aysem = session('active_aysem',\App\Aysem::current()->aysem ) ;
            $aysems = \App\Aysem::all();
        ?>

        @foreach($aysems as $aysem)
            <option value={{$aysem->aysem}}   @if($active_aysem == $aysem->aysem) selected @endif >
            	{{\App\Aysem::shortName($aysem->aysem)}}
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