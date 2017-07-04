
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')
@else
    \Auth::user()->department->short_name()
@endif


<div class="panel-body">
<<<<<<< HEAD
    <h4>Beginning balance:  ₱{{$beginning_balance}}</h4> 
    <h4>Current Balance:  ₱{{$current_balance}}</h4>
=======
    <h4>Beginning balance:{{$beginning_balance}}</h4> 
    <h4>Current Balance: {{$current_balance}}</h4>
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
</div>
<div class="row">
@include('layouts.errors')

	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
				Transactions  
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
                        <td>{{$transaction['transaction_type_id']}}</td>
                        <td>{{$transaction['amount']}}</td>
                        <td>{{$transaction['balance']}}</td>
                    </tr>
                    @endforeach
                </tbody> 
            </table>
		    </div>
	    </div>
    </div>
</div>










@endsection
