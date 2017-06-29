
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements  
    </div>

@if(count($endorsements)>0)

	@foreach($endorsements as $type => $request_endorsement)
	<table class="table table-striped table-responsive">
        <thead>
            <tr>
                <th style='width:15%'>{{$type}}</th> <!--check with sir try demo with endorse functionality (back-end)-->               
                <th style='width:10%'>Quantity</th>                
                <th style='width:5%'>Unit price</th>
                <th style='width:10%'>Subtotal</th> 
                <th style='width:5%'>Action</th>
            </tr>
        </thead>
        <tbody>
            @if(count($request_endorsement) >0)
            @foreach($request_endorsement as $request)
           	<tr>
           		<td>
                
              </td>

           		
           	</tr>
           	@endforeach
            @else
           	@endif
           
        </tbody>
    </table>
	@endforeach
		
@else
	<div class="panel-body">
	  	No endorsements.  
    </div>

@endif
</div>