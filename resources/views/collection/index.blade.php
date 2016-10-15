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

		@include('layouts.errors')

		@if(count($collections)>0)
			<ul class="list-group">
			@foreach($collections as $collection)
			    <li class="list-group-item">
			  		<a href="{{url('collection',$collection)}}"> {{ \App\Aysem::shortName($collection)}} </a>
			    </li>
			  @endforeach
			</ul>

		@else
			No collections found yet.
		@endif

		

		@include('collection._collection_form', compact('active_aysem_str'))
		</div>
		
	</div>
</div>
@endsection