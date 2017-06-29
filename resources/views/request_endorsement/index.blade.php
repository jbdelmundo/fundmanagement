@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Request Endorsement</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">{{$department->short_name}} for {{ $aysem->getShortName() }} Endorsed </h3>
	
	@include('request_endorsement._request_endorsements',compact('endorsements'))
	</div>	
</div>


<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">{{$department->short_name}} for {{ $aysem->getShortName() }} for endorsement </h3>
	</div>	
</div>

<div class="row">
	<div class="col-lg-12">

		@include('layouts.errors')
		<?php use \App\Requests; ?>

        @include('request_endorsement._requests_book',['heading'=>'Books','items'=>$requests_this_sem[Requests::BOOK ]])
        @include('request_endorsement._requests_book',['heading'=>'E-books','items'=>$requests_this_sem[Requests::EBOOK]])
        @include('request_endorsement._requests_journal',['heading'=>'Journals','items'=>$requests_this_sem[Requests::JOURNAL]])
        @include('request_endorsement._requests_ebook',['heading'=>'Magazines','items'=>$requests_this_sem[Requests::MAGAZINE]])
        @include('request_endorsement._requests_ebook',['heading'=>'Electronic Resources','items'=>$requests_this_sem[Requests::ERESOURCE]])
        @include('request_endorsement._requests_ebook',['heading'=>'Supplies','items'=>$requests_this_sem[Requests::SUPPLIES]])
        @include('request_endorsement._requests_ebook',['heading'=>'Equipment','items'=>$requests_this_sem[Requests::EQUIPMENT]])
        @include('request_endorsement._requests_ebook',['heading'=>'Others','items'=>$requests_this_sem[Requests::OTHER]])


        
	</div>
</div>

@endsection