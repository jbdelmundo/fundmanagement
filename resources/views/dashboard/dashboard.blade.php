
@extends('app')

@section('content')
	
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard of {{$department->short_name}}</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
@include('layouts.errors')
	<div class="col-lg-12">
		<div class="panel panel-default">
		    <div class="panel-heading">
			  Balance history  
		    </div>
		    <div class="panel-body">
			 <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Sem</th>
                        <th>Income</th>
                        <th>Expenses</th>
                        <!-- <th>Type</th> -->
                        <th>Balance</th>
                       
                    </tr>
                </thead>
                <tbody>
                    @foreach($balance_history as  $history)
                    <tr>

                        <td>{{\App\Aysem::abbrev($history->aysem)}}</td>
                        <td>{{$history->transaction_type_id=='C'? number_format( $history->amount ,  2 ,  "." ,  "," ) : ''}}</td>
                        <td>{{$history->transaction_type_id=='P'? number_format( $history->amount  ,  2 ,  "." ,  "," ): ''}}</td>
                        
                       <!--  <td>{{$history->transaction_type_id}}</td> -->
                        <td>{{ number_format( $history->balance ,  2 ,  "." ,  "," )}}</td>
                        
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
			</div>
		</div>
	</div>
</div>

@include('dashboard._balance_history_chart')


@endsection
