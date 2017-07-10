
@extends('app')

@section('content')

<?php ?>
	
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
		

	
	</div>

<div class="panel panel-default">
    <div class="panel-heading">
	
    </div>
@if(count($boks) >0)
	<div class="panel-body">

		<table class="table table-striped table-responsive">
			<thead>
				<tr>
					<th style='width:15%'>Title/Description</th>
					<th style='width:15%'>Subject</th>
					<th style='width:10%'>Total Quote Price</th> 

				</tr>
			</thead>
			<tbody>
				@foreach($boks as $all)
					@if(count($all) >0)
							@if($all->category_id == "B" || $all->category_id == "E" || $all->category_id == "M" || $all->category_id == "J")

											@if($all->total_bid_price == $checker)
											
											<tr>
												<td>{{$all->title}}</td>
												<td>{{$all->subject}}</td>
												<td>{{$all->total_quote_price}}</td>


											</tr>
											@else
											<tr>
												<td>{{$all->title}}</td>
												<td>{{$all->subject}}</td>
												<td>{{$all->total_bid_price}}</td>


											</tr>									
											@endif
								@else
									@if($all->total_bid_price == $checker)
											<tr>
												<td>{{$all->description}}</td>
												<td></td>
												<td>{{$all->total_quote_price}}</td>


											</tr>
											@else
											<tr>
												<td>{{$all->title}}</td>
												<td></td>
												<td>{{$all->total_bid_price}}</td>


											</tr>									
											@endif
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



@endsection