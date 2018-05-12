

		<div class="panel panel-default">
			<div class="panel-heading">
		 	<h3>
		  		@if($is_first_collection)
		  			New Collection
	  			@else
	  				Adjustments
	  			@endif
		  		 for {{  \App\Aysem::shortName( $current_aysem->aysem ) }}
	  			
	  		<h3></div>
		  <div class="panel-body">
			{!! Form::open(['url' => 'collection' , 'class' => 'form']) !!}	
				<div class="form-group">
					{{Form::label('amount', 'Collected amount from Main Library')}} 
					<strong><span id='amountcollected'></span></strong>
	    			{{
	    				Form::number('amount',null,['class'=>'form-control', 'min'=>0,'required',
	    			'onchange'=> 'return pre_compute(this.value)'])
	    			}}

	    		</div>
	    	
	    		<table class="table">
					
					@foreach($depts_with_percent as $dept)
						<tr>
							<div class="form-group">
								<td>{{ $dept->short_name}}</td>
				    			<td>{{ $dept->percent_allocation }}%</td>
				    			<td id='amount-{{$dept->id}}'>xxxx</td>
				    		</div>
						</tr>
	    			@endforeach
	    			<tr>
	    				<td>Amount Remaining to be redistributed:</td>
	    				<td>XXXXX</td>
	    			</tr>
				</table>
			</div>
		</div>
		<div class="panel panel-default">
	    	<div class="panel-body">
	    		<div class="form-group">
		    		<table class="table">
						<tr>
							<th>Department/Institute</th>
							<th>Undegraduates</th>
							<th>Graduates</th>
							<th>Amount</th>
						</tr>
						@foreach($depts_with_collection as $dept)
							<tr>
								<div class="form-group">
									<td>{{Form::label('amount', $dept->short_name)}}</td>
					    			<td>{{Form::number('statistics['.$dept->id.']'.'[undergraduate]'	,0,['class'=>'form-control','min'=>0,'required'])}}</td>
					    			<td>{{Form::number('statistics['.$dept->id.']'.'[graduate]'			,0,['class'=>'form-control','min'=>0,'required'])}}</td>
					    			<td id='amount-{{$dept->id}}'>xxx</td>
					    		</div>
							</tr>
		    			@endforeach
					</table>
				</div>
				{{ Form::submit('Create collection',['class'=> 'form btn-primary btn']) }}
	    		
			{!! Form::close() !!}
		  </div>

<script type="text/javascript">
	function pre_compute(nStr)
	{
	    nStr += '';
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    $('#amountcollected').html(': '+x1 + x2)

	    //Show 
	}

	function compute_percent_allocation(){
		
	}
</script>