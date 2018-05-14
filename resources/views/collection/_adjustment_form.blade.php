

		<div class="panel panel-info">
			<div class="panel-heading">
		 	<h3>
		  		Adjustments for {{  \App\Aysem::shortName( $current_aysem->aysem ) }}
		  	</h3>
		  	
	  		</div>
		  <div class="panel-body">
		  	<h3>
	  			Previous amount collected from Main Library: {{$last_collection['amount']}}
			</h3>
			{!! Form::open(['url' => 'collection' , 'class' => 'form']) !!}	
				<div class="form-group">
					
					{{Form::label('amount', 'Adjusted amount collected from Main Library:')}} 
					
					<strong><span id='amountcollected'></span></strong>
	    			{{
	    				Form::number('amount',$last_collection['amount'],['class'=>'form-control', 'min'=>0,'required'])
	    			}}

	    		</div>
	    	
	    		<table class="table">
					
						<tr>
							<td></td>
							<th></th>
							<th>Old amount</th>
							<th>New amount</th>
						</tr>
					@foreach($depts_with_percent as $dept)
						<tr>
							<div class="form-group">
								<td>{{ $dept->short_name}}</td>
				    			<td>{{ $dept->percent_allocation }}%</td>
				    			<td id='old-amount-{{$dept->id}}'>xxxx</td>
				    			<td id='amount-{{$dept->id}}'>xxxx</td>
				    		</div>
						</tr>
	    			@endforeach
	    			<tr>
	    				<td>Amount Remaining to be redistributed:</td>
	    				<td id='amount-redistribute'>XXXXX</td>
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
							<th>Undegraduates (Previous)</th>
							<th>Graduates (Previous)</th>
							<th>Undegraduates</th>
							<th>Graduates</th>
							<th>Previous Amount</th>
							<th>New Amount</th>
						</tr>
						@foreach($depts_with_collection as $dept)
							<tr>
								<div class="form-group">
									<td>{{Form::label('amount', $dept->short_name)}}</td>
	                                <td>{{  $last_collection['statistics'][$dept->id]['undergraduate']  }}</td>
	                                <td>{{  $last_collection['statistics'][$dept->id]['graduate']  }}</td>
					    			<td>{{Form::number(
						    				'statistics['.$dept->id.']'.'[undergraduate]',
						    				$last_collection['statistics'][$dept->id]['undergraduate'],
						    				['class'=>'form-control','min'=>0,'required', 
						    					'id'=>'ug-'.$dept->id]
					    				)}}
					    			</td>
					    			<td>{{Form::number(
					    				'statistics['.$dept->id.']'.'[graduate]'
					    				,$last_collection['statistics'][$dept->id]['graduate']
					    				,['class'=>'form-control','min'=>0,'required','id'=>'g-'.$dept->id])}}</td>

					    			
                                	<td>{{  number_format ( $last_collection['allocations'][$dept->id] ,  2 ,  "." ,  "," ) }}</td>
					    			<td id='amount-{{$dept->id}}'>xxx</td>

					    		</div>
							</tr>
		    			@endforeach
					</table>
				</div>
				{{ Form::submit('Adjust collection',['class'=> 'form btn-primary btn']) }}
	    		
			{!! Form::close() !!}
		  </div>

<script type="text/javascript">
	function format_with_comma(nStr)
	{
		nStr = Math.round(nStr * 100) / 100 // trim to two decimal places
	    nStr += '';
	    x = nStr.split('.');
	    x1 = x[0];
	    x2 = x.length > 1 ? '.' + x[1] : '.00';
	    var rgx = /(\d+)(\d{3})/;
	    while (rgx.test(x1)) {
	        x1 = x1.replace(rgx, '$1' + ',' + '$2');
	    }
	    return x1 + x2
	}

	$(document).ready(function(){
		$('input').change(compute_percent_allocation)
		// $('input').keypress(compute_percent_allocation)
		compute_percent_allocation()
	})

	depts_with_percent = {!! json_encode($depts_with_percent) !!}
	depts_with_collection = {!! json_encode($depts_with_collection) !!}


	function compute_percent_allocation(){
		console.log('change')
		amount = $('#amount').val()
		prev_amount = {{$last_collection['amount']}}
		console.log('amount :' + amount)
		format_with_comma(amount)
		
		$('#amountcollected').html(': '+format_with_comma(amount))


		total_allocation_for_dept_percent = 0
		for(ix in depts_with_percent){
			dept = depts_with_percent[ix]

			allocation = amount * (dept['percent_allocation']/100)
			old_allocation = prev_amount * (dept['percent_allocation']/100)
			total_allocation_for_dept_percent += allocation
			selector = '#amount-'+ dept['id']
			old_selector = '#old-amount-'+ dept['id']
			$(selector).html(format_with_comma(allocation))
			$(old_selector).html(format_with_comma(old_allocation))
		}

		//compute amount to redistribute
		amount_to_redistribute = amount - total_allocation_for_dept_percent
		selector = '#amount-redistribute'
		$(selector).html('<strong>' + format_with_comma(amount_to_redistribute) + '</strong>')


		UG_WEIGHT = 1
		G_WEIGHT = 2
		TOTAL_WEIGHT = 0

		//compute weights
		for(ix in depts_with_collection){
			dept = depts_with_collection[ix]
			
			ug_form = parseInt($('#ug-'+dept['id']).val())
			g_form = parseInt($('#g-'+dept['id']).val())
			dept['dept_weight'] = (ug_form * UG_WEIGHT) + (g_form * G_WEIGHT)
			TOTAL_WEIGHT += dept['dept_weight']
		}

		//compute allocations based on weights
		for(ix in depts_with_collection){
			dept = depts_with_collection[ix]
			
			if(TOTAL_WEIGHT == 0){
				TOTAL_WEIGHT=1
			}
			allocation = amount_to_redistribute * (dept['dept_weight'] / TOTAL_WEIGHT)
			
			selector = '#amount-'+ dept['id']
			$(selector).html(format_with_comma(allocation))

		}
	}


	

	
</script>