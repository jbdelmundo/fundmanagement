

		<div class="panel panel-default">
		  <div class="panel-heading"><h3>New Collection for {{  \App\Aysem::shortName( $current_aysem->aysem ) }}<h3></div>
		  <div class="panel-body">
			{!! Form::open(['url' => 'requests' , 'class' => 'form-horizonta']) !!}
				

				<div class="form-group">
					{{Form::label('amount', 'Collected amount from Main Library')}}
	    			{{Form::number('amount',null,['class'=>'form-control'])}}
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
				    			<td>{{Form::number('statistics['.$dept->id.']'.'[undergraduate]'	,0,['class'=>'form-control'])}}</td>
				    			<td>{{Form::number('statistics['.$dept->id.']'.'[graduate]'			,0,['class'=>'form-control'])}}</td>
				    		</div>
						</tr>
	    			@endforeach
				</table>
				{{ Form::submit('Create collection',['class'=> 'form btn-primary btn']) }}
	    		
			{!! Form::close() !!}
		  </div>