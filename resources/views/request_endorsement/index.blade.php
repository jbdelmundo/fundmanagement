@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Request Endorsement</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
@if(\Auth::user()->isLibrarian())  
<div class="row">
    <div class="col-lg-12">
		@include('_active_dept_selector',['active_department_id'=>$department->id])
        @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])
    </div>  
</div>
@endif
@include('layouts._alerts')


		<?php use \App\Requests; ?>

@if($aysem->aysem == \App\Aysem::current()->aysem )
<div class="row">
    
	<div class="col-lg-12">
		<h3 class="page-header">{{$department->short_name}} for {{ $aysem->getShortName() }} for endorsement </h3>
	</div>	
</div>

<div class="row">
	<div class="col-lg-12">
        @include('request_endorsement._requests_book',
                ['requests_this_sem'=>$requests_this_sem])
	</div>
    <div class="col-lg-12">
         <div class="alert alert-info alert-refresh-to-reflect" role="alert" style="display: none;">
            Refresh the page to update the other tables.
        </div>
        @include('request_endorsement._request_endorsements',compact('endorsements'))
    </div>
    <div class="col-lg-12">
        <div class="alert alert-info alert-refresh-to-reflect" role="alert" style="display: none;">
            Refresh the page to update the other tables.
        </div>
        @include('request_endorsement._request_rejects',compact('rejects'))
     </div>
</div>
@endif

@endsection