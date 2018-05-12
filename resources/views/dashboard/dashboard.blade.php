
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')

@endif
    @include('_active_sem_selector',['active_aysem'=>$aysem->aysem])

<div class="panel-body">
    
    <h4>Current Balance: {{ number_format( $current_balance ,  2 ,  "." ,  "," ) }}</h4>
</div>

<div class="row">
@include('layouts._alerts')

	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
				Transactions for  {{ $aysem->shortName()}}
		    </div>
		    <div class="panel-body">
		    <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>

				    @foreach($transactions as $key => $transaction)
                    <tr>
                        <td>{{$transaction['created_at']}}</td>
                        <td>{{$types[$transaction['transaction_type_id']]}}</td>
                        <td>{{  number_format ( $transaction->amount ,  2 ,  "." ,  "," )  }}</td>
                        <td>{{  number_format ( $transaction->balance ,  2 ,  "." ,  "," )  }}</td>
                    </tr>
                    @endforeach
                </tbody> 
            </table>
		    </div>
	    </div>
    </div>
</div>




    
@include('requests._request_per_category')
       




@endsection