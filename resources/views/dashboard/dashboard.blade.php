
@extends('app')

@section('content')


	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('layouts.department_dropdowns')
@else
    \Auth.user()->department->short_name();
@endif    

<div class="row">
@include('layouts.errors')

	<div class="col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">
              BALANCE
            </div>
            <div class="panel-body">
             <table class="table table-striped">
                <thead>
                    <tr>
                       <td>Beginning Balance: {{$beginning_balance}}</td>
                    </tr>
                    <tr>
                        <td>Current Balance: {{$current_balance}}</td>
                    </tr>
                </thead>
                <tbody>
                    
                    
                </tbody>
            </table>
            </div>
        </div>
    </div>

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
                        <td>{{$transaction['transaction_type']}}</td>
                        <td>{{$transaction['amount']}}</td>
                        <td>{{$transaction['balance']}}</td>
                    </tr>

                    @endforeach     
                </tbody>
                <tr> <td></td><td></td><td></td> <td align="left"> TOTAL BALANCE: {{$total_balance}} </td></tr>
            </table>
            </div>
        </div>
    </div>
</div>










@endsection
