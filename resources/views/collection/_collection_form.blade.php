

		<div class="panel panel-default">
		  <div class="panel-heading"><h3>
		  		@if($is_first_collection)
		  			New Collection
	  			@else
	  				Adjustments
	  			@endif
		  		 for {{  \App\Aysem::shortName( $current_aysem->aysem ) }}
	  			
	  		<h3></div>
		  <div class="panel-body">
			{!! Form::open(['url' => 'collection' , 'class' => 'form-horizonta']) !!}
				

				<div class="form-group">
					{{Form::label('amount', 'Collected amount from Main Library')}} <strong><span id='amountcollected'></span></strong>
	    			{{Form::number('amount',null,['class'=>'form-control', 'min'=>0,'required',
	    			'onchange'=> 'return addCommas(this.value)'
	    			])}}

	    		</div>

	    		
	    		<table class="table">
					<tr>
						<th>Department</th>
						<th>Undegraduates</th>
						<th>Graduates</th>
					</tr>
					@foreach($depts_with_collection as $dept)
						<tr>
							<div class="form-group">
								<td>{{Form::label('amount', $dept->short_name)}}</td>
				    			<td>{{Form::number('statistics['.$dept->id.']'.'[undergraduate]'	,0,['class'=>'form-control','min'=>0,'required'])}}</td>
				    			<td>{{Form::number('statistics['.$dept->id.']'.'[graduate]'			,0,['class'=>'form-control','min'=>0,'required'])}}</td>
				    		</div>
						</tr>
	    			@endforeach
				</table>
				{{ Form::submit('Create collection',['class'=> 'form btn-primary btn']) }}
	    		
			{!! Form::close() !!}
		  </div>

<script type="text/javascript">
	function addCommas(nStr)
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

}
</script>