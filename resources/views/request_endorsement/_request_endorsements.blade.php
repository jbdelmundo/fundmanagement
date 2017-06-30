
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements  
    </div>

    <div class="panel-body">
@if(count($endorsements)>0)

	@foreach($endorsements as $type => $request_endorsement)
	<table class="table table-striped table-responsive">
            @if(count($request_endorsement) >0)
				<thead>
					<tr>
						@if($type == 'Q' || $type == 'S' || $type == 'O')
							<th style='width:15%'>Description</th>  
						@else	
							<th style='width:15%'>Title</th>  
						@endif							
						<th style='width:10%'>Quantity</th>                
						<th style='width:5%'>Unit price</th>
						<th style='width:10%'>Subtotal</th> 
						<th style='width:5%'>Remarks</th>
						<th style='width:5%'>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($request_endorsement as $request)
					<tr>
						@if($type == 'Q' || $type == 'S' || $type == 'O')
							<td>{{$request->description}}</td>
						@else
							<td>{{$request->title}}</td>
						@endif
						<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
						<td>{{$request->unit_quote_price}}</td>
						<td>{{$request->total_quote_price}}</td>
						<td>{{$request->remarks}}</td>
						<td><a href='{{ url("endorsement/remove/". $request->request_id)}}'>Remove</a></td>

					</tr>
					@endforeach
				   
				</tbody>
           	@endif
    </table>
	@endforeach
		
</div>
@else
	<div class="panel-body">
	  	No endorsements.  
    </div>

@endif
</div>
