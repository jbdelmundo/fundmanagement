
@extends('app')

@section('content')

<?php ?>
	
	
@if(\Auth::user()->isLibrarian())
		@include('_active_dept_selector')
@endif
<div class="row">
	<div class="col-lg-12">
		
	</div>
	<!-- /.col-lg-12 -->

    
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
						{{ Form::open([  'method'=>'GET', 'url'=>'purchasehistory' , 'class' => 'btn btn-default-sm']) }} 
										{{ Form::submit('BACK',  ['class'=>'btn btn-success'])}}
					{{ Form::close() }}
		</div>
	</div>



<div class="panel panel-default">
    <div class="panel-heading">
	  		Purhases for Books, EBooks of {{$department->short_name}} 
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
						@if($type == 'B' || $type == 'E' )
							@foreach($try as $subject)
								@foreach($bookz as $book)
								@foreach($purchase as $request)
									@if($request->id == $subject->request_id)
										@if($request->id == $book->request_id)
										@if($subject->total_bid_price == $checker)
										
										<tr>
											<td>{{$book->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_quote_price}}</td>


										</tr>
										@else
										<tr>
											<td>{{$book->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_bid_price}}</td>


										</tr>									
										@endif
										@endif
									@endif
								@endforeach
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
	  		Purhases for Journals, Magazines of {{$department->short_name}} 
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
						@if($type == 'M' || $type == 'J' )
							@foreach($try as $subject)
								@foreach($magz as $book)
								@foreach($purchase as $request)
									@if($request->id == $subject->request_id)
										@if($request->id == $book->request_id)
										@if($subject->total_bid_price == $checker)
										
										<tr>
											<td>{{$book->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_quote_price}}</td>


										</tr>
										@else
										<tr>
											<td>{{$book->title}}</td>
											<td>{{$subject->subject}}</td>
											<td>{{$subject->total_bid_price}}</td>


										</tr>									
										@endif
										@endif
									@endif
								@endforeach
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
	  	Purhases for Supplies, Equipments, Others of {{$department->short_name}} 
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
								@foreach($otherz as $book)
						@foreach($purchase as $request)
						@if($request->id == $book->request_id)
								@if(is_null($search) || $search == "")
							@if($request->total_bid_price == $checker)
									<tr>
										<td>{{$book->description}}</td>
										<td></td>
										<td>{{$request->total_quote_price}}</td>


								</tr>
							@else
									<tr>
										<td>{{$book->description}}</td>
										<td></td>
										<td>{{$request->total_bid_price}}</td>


								</tr>
							@endif
							@else
									<tr></tr>
									<tr></tr>
									<tr></tr>
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
	No Purhases
</div>

@endif
</div>


@endsection