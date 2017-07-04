@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Endorsement for Approval of {{$department->short_name}}</h1>
	</div>
</div>
@if(\Auth::user()->isLibrarian())
		@include('_active_dept_selector',['active_department_id'=>$department->id])
        @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])
@endif
<div class="panel panel-default">
    <div class="panel-heading">
	  	Purchases for Book, E-Books, Journals, Magazines  
    </div>
@if(((count($purchased['B']))+(count($purchased['E']))+(count($purchased['M']))+(count($purchased['J'])))>0)
<div class="panel-body">

	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Title</th>
				<th style='width:10%'>Quantity</th>
				<th style='width:10%'>Total Quote Price</th> 
				<th style='width:5%'>Total Refund</th>
				<th style='width:5%'>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($purchased as $type => $purchase)
				@if(count($purchase) >0)
					@if($type == 'B' || $type == 'E' || $type == 'M' || $type == 'J')
						@foreach($purchase as $request)
							<tr>
								<td>{{$request->title}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
									{{ Form::open(['url' => 'refunds' , 'class' => 'form-horizontal']) }} 
								<td>{{ Form::number('refund',1,['class'=>'form-control', 'min'=>'1']) }}</td>
								<td>
										{{ Form::hidden('request_id',$request->request_id)}}
										{{ Form::submit('Refund',  ['class'=>'btn btn-success', 'id'=>'btn_refund_'.$request->id])}}
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
	No Purchases
</div>
@endif
</div>	
<div class="panel panel-default">
    <div class="panel-heading">
	  	Purhases for Supplies, Equipments, Others  
    </div>

@if(((count($purchased['Q']))+(count($purchased['S']))+(count($purchased['O'])))>0)
<div class="panel-body">
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Description</th>
				<th style='width:10%'>Quantity</th>
				<th style='width:10%'>Total Quote Price</th> 
				<th style='width:5%'>Total Refund</th>
				<th style='width:5%'>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($purchased as $type => $purchase)
				@if(count($purchase) >0)
					@if($type == 'Q' || $type == 'S' || $type == 'O')
						@foreach($purchase as $request)
							<tr>
								<td>{{$request->description}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
									{{ Form::open(['url' => 'refunds' , 'class' => 'form-horizontal']) }} 
								<td>{{ Form::number('refund',1,['class'=>'form-control', 'min'=>'1']) }}</td>
								<td>
										{{ Form::hidden('request_id',$request->request_id)}}
										{{ Form::submit('Refund',  ['class'=>'btn btn-success', 'id'=>'btn_refund_'.$request->id])}}
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
	No Purhases
</div>

@endif
</div>
@endsection