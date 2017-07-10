
@extends('app')

@section('content')

<?php ?>
	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Purchase History of {{$department->short_name}}</h1>
	</div>
	<!-- /.col-lg-12 -->

@if(\Auth::user()->isLibrarian())
		@include('_active_dept_selector',['active_department_id'=>$department->id])
        @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])
@endif
    
	<div class="row">
			<div class="col-md-6 text-right">
				{!! Form::open(['method'=>'GET', 'class'=>'navbar-form navbar-left', 'role' => 'search']) !!}
				<div class="input-group custom-search-form">
					{!! Form::text('subject', Request::get('subject'), ['class' => 'form-control', 'placeholder' => 'Search Subject of Books']) !!}
					<span class="input-group-btn">
					<button type="submit" class="btn btn-default-sm">
						<i class="fa fa-search">SEARCH</i>
					</button>
					</span>
				</div>
				{!! Form::close() !!}
		</div>	
		
		<div class="col-md-6 text-right">

		</div>
	
	</div>

<div class="panel panel-default">
    <div class="panel-heading">
	  		Purhases for Books, EBooks, Magazines of {{$department->short_name}} in AYSEM {{$aysem->short_name}}
    </div>
@if(((count($purchased['B']))+(count($purchased['E']))+(count($purchased['M']))+(count($purchased['J'])))>0)


<div class="panel-body">

	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Title</th>
				<th style='width:15%'>Subject</th>
				<th style='width:10%'>Total Quote Price</th> 

			</tr>
		</thead>
		<tbody>
			@foreach($purchased as $type => $purchase)
				@if(count($purchase) >0)
						@if($type == 'B' || $type == 'E' || $type == 'M' || $type == 'J')
							@foreach($try as $subject)
								@foreach($purchase as $request)
									@if($request->request_id == $subject->request_id)
										@if($subject->total_bid_price == $checker)
										
										<tr>
											<td>{{$request->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_quote_price}}</td>


										</tr>
										@else
										<tr>
											<td>{{$request->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_bid_price}}</td>


										</tr>									
										@endif
									@endif
								@endforeach
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
	  	Purhases for Supplies, Equipments, Others of {{$department->short_name}} in AYSEM {{$aysem->short_name}}
    </div>

@if(((count($purchased['Q']))+(count($purchased['S']))+(count($purchased['O'])))>0)
<div class="panel-body">
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Description</th>
				<th style='width:15%'>Subject</th>
				<th style='width:10%'>Total Quote Price</th> 

			</tr>
		</thead>
		<tbody>

			@foreach($purchased as $type => $purchase)
				@if(count($purchase) >0)
					@if($type == 'Q' || $type == 'S' || $type == 'O')
						@foreach($purchase as $request)
							@if($subject->total_bid_price == $checker)
									<tr>
										<td>{{$request->description}}</td>
										<td></td>
										<td>{{$request->total_quote_price}}</td>


								</tr>
							@else
									<tr>
										<td>{{$request->description}}</td>
										<td></td>
										<td>{{$request->total_bid_price}}</td>


								</tr>
							@endif
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