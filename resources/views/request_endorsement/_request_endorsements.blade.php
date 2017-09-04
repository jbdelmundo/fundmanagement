
<div class="panel panel-primary">
    <div class="panel-heading">
	  	Endorsed items for purchase 
    </div>

    <div class="panel-body">
@if(count($endorsements)>0)


	<?php 
		$types = [	'B'=>'BOOK', 
					'E'=>'E-BOOK',
					'M'=>'MAGAZINE',
					'J'=>'JOURNAL',
					'R'=>'E-RESOURCE',
					'Q'=>'EQUIPMENT',
					'S'=>'SUPPLIES',
					'O'=>'OTHER'];
		$total_expense = 0;
	?>

	<table class="table table-responsive table-hover">
		<thead>
			<tr >
				<th>Title</th>  	
				<th >Type</th>								
				<th >Remarks</th>
				<th >Quantity</th>                
				<th >Unit price</th>
				<th>Subtotal</th> 
				@if($aysem->aysem == \App\Aysem::current()->aysem )
				<th >Action</th>
				@endif
			</tr>
		</thead>
		<tbody>
	@foreach($endorsements as $type => $request_endorsement)	

            @if(count($request_endorsement) >0)
				
				
					@foreach($request_endorsement as $request)
					<tr>
						@if($type == 'Q' || $type == 'S' || $type == 'O')
							<td>{{$request->description}}</td>
						@else
							<td>{{$request->title}}</td>
						@endif
						<td align="left">{{ $types[$type]}}</td>
						<td>{{$request->remarks}}</td>
						<td align="center">{{$request->total_quote_price/$request->unit_quote_price}}</td>
						<td align="right ">{{$request->unit_quote_price}}</td>
						<td align="right">{{$request->total_quote_price}}</td>
						<?php $total_expense += $request->total_quote_price ;?>
						@if($aysem->aysem == \App\Aysem::current()->aysem )
						<td><a href='{{ url("endorsement/remove/". $request->request_id)}}'>Remove</a></td>
						@endif

					</tr>
					@endforeach
				   
				
           	@endif
	@endforeach
			<tr>
			<td align="right" colspan="5" style='font-weight:bold'>TOTAL</td>
			<td align="right" style='font-weight:bold'>{{ number_format( $total_expense ,  2 ,  "." ,  "," ) }}</td>
			<td colspan="1"></td>
			</tr>

		</tbody>
    </table>
		
</div>
@else
	<div class="panel-body">
	  	No endorsements.  
    </div>

@endif
</div>
