@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Refunds</h1>
		<h3 class="page-header">Refunds of {{$department->short_name}} for {{ $aysem->getShortName() }}  </h3>
	</div>
</div>
@if(\Auth::user()->isLibrarian())
		@include('_active_dept_selector',['active_department_id'=>$department->id])
@endif
        @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])

@if(count($refunded)>0)
	<div class="panel panel-primary">
		<div class="panel-heading">
		  Refunded Requests
		</div>
		<div class="panel-body">
			
			<div class="table-responsive">
			
				<table class="table table-striped">
					@if(count($refunded['B'])+count($refunded['E'])+count($refunded['M'])+count($refunded['J'])+count($refunded['R'])+count($refunded['Q'])+count($refunded['S'])+count($refunded['O']) == 0)
						No Refunds
					@else
						<thead>
							<tr>
								<th>Title/Description</th>
								<th>Quantity</th>
								<th>Total Quote Price</th>
								<th>Total Bid Price</th>
							   
							 
							</tr>
						</thead>
						<tbody>
							@foreach($refunded as  $items)
							<?php $items = $items->toArray();?>
								@foreach($items as  $item)
								<tr>
									@if($item->category_id == 'Q' || $item->category_id == 'S' ||$item->category_id == 'O')
										<td>{{$item->description}}</td>
									@else
										<td>{{$item->title}}</td>
									@endif
									<td>{{$item->total_quote_price/$item->unit_quote_price}}</td>
									<td>{{$item->total_quote_price}}</td>
									<td>{{$item->total_bid_price}}</td>                
								</tr>
								@endforeach
							@endforeach
						</tbody>
					@endif
				</table>
				
			</div>
			
		</div>
	</div>
@endif
<hr>
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
