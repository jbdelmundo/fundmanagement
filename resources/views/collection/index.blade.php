@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Collections</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
	<div class="col-lg-12">

		@include('layouts._alerts')

		

		@if(!$is_first_collection)
			<div class="alert alert-warning" role="alert">
				You already have collection data for this semester, if you wish to make
			adjustments, select the semester you want to edit
			</div>

			@if(count($collections)>0)
				<ul class="list-group">
				@foreach($collections as $collection)
				    <li class="list-group-item">
				  		<a href="{{url('collection',$collection)}}"> {{ \App\Aysem::shortName($collection)}} </a>
				    </li>
				  @endforeach
				</ul>

			@endif
		@else
			@include('collection._collection_form', compact('active_aysem_str'))
		@endif
		@include('collection._collection_form', compact('active_aysem_str'))
		

		
		</div>
		
	</div>
</div>
@endsection