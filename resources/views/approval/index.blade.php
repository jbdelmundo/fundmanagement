@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Endorsement for Approval of {{$department->short_name}}</h1>
	</div>
</div>
@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')
@endif
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements for Book, E-Books, Journals, Magazines  
    </div>
@if(((count($endorsements['B']))+(count($endorsements['E']))+(count($endorsements['M']))+(count($endorsements['J'])))>0)
<div class="panel-body">

	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Title</th>
				<th style='width:10%'>Quantity</th>                
				<th style='width:5%'>Unit price</th>
				<th style='width:10%'>Subtotal</th> 
				<th style='width:5%'>Remarks</th>
				<th style='width:5%'>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($endorsements as $type => $request_endorsement)
				@if(count($request_endorsement) >0)
					@if($type == 'B' || $type == 'E' || $type == 'M' || $type == 'J')
						@foreach($request_endorsement as $request)
							<tr>
								<td>{{$request->title}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
								<td>{{$request->remarks}}</td>
								<td>
									{{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal']) }} 
										{{ Form::hidden('request_id',$request->request_id)}}
										{{ Form::submit('Approve',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$request->id])}}
									{{ Form::close() }}
								</td>

							</tr>
						@endforeach
					@endif
				@endif
			@endforeach
		</tbody>
    </table>
	
</div>	
@else
<div class="panel-body">
	No Endorsements
</div>
@endif
</div>	
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements for Supplies, Equipments, Others  
    </div>

@if(((count($endorsements['Q']))+(count($endorsements['S']))+(count($endorsements['O'])))>0)
<div class="panel-body">
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Description</th>
				<th style='width:10%'>Quantity</th>                
				<th style='width:5%'>Unit price</th>
				<th style='width:10%'>Subtotal</th> 
				<th style='width:5%'>Remarks</th>
				<th style='width:5%'>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($endorsements as $type => $request_endorsement)
				@if(count($request_endorsement) >0)
					@if($type == 'Q' || $type == 'S' || $type == 'O')
						@foreach($request_endorsement as $request)
							<tr>
								<td>{{$request->description}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
								<td>{{$request->remarks}}</td>
								<td>
									{{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal']) }} 
										{{ Form::hidden('request_id',$request->request_id)}}
										{{ Form::submit('Approve',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$request->id])}}
									{{ Form::close() }}
								</td>

							</tr>
						@endforeach
					@endif
				@endif
			@endforeach
		</tbody>
    </table>
		
</div>	

@else
<div class="panel-body">
	No Endorsements
</div>

@endif
</div>
@endsection