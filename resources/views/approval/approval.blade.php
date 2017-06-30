
@extends('app')

@section('content')



<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Endorsements for Approval of {{$department->short_name}}</h1>
	</div>
</div>

@if(\Auth::user()->isLibrarian())
    @include('layouts.department_dropdowns')
@else
    \Auth.user()->department->short_name();
@endif    

<div class="row">
@include('layouts.errors')

    <div class="panel-body">    
     Beginning Balance: {{$beginning_balance}}
     <hr>
     Current Balance: {{$current_balance}}
     <hr>
 </div>
 
 
 
 <div class="row">
 
 @include('layouts.errors')
   <div class="col-lg-12">
       <div class="panel panel-default">
           <div class="panel-heading">
               Books, E-books, Journals, and Magazines  
           </div>
           <div class="panel-body">
           <table class="table table-striped table-responsive">
                 <thead>
                     <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Unit Quote Price</th>
                        <th>Total</th>
                        <th>Action</th>
                     </tr>
                 </thead>
                 <tbody>
                 
                     @foreach($endorsements as $key => $endorsement)
                     @if($key=='B' || $key=='E' || $key=='M')

                   <tr>
                     {{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal', 'method' => 'POST']) }} 
                     <div class='form-group'>
                         {{ Form::hidden('request_id',$endorsement['request_id'])}}
                         <td>{{$endorsement['title']}}</td>
                         <td>{{$key}}</td>
                         <td>{{$endorsement['qty']}}</td>
                         <td>{{$endorsement['unit_quote_price']}}</td>
                         <td>{{$endorsement['unit_quote_price']*$endorsement['qty']}}</td>
                         <td>
                             {{ Form::submit('Approve',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$endorsement['request_id']])}}
                         </td>
                     </div>
                     </tr>
                     @endif 
                     @endforeach
                    
                 </tbody> 
             </table>
           </div>
       </div>
     </div>
 
     <div class="col-lg-12">
   </div>
 
 </div>

    <div class="col-lg-12.5">
        <div class="panel panel-default">
            <div class="panel-heading">
                Others, Equipment, Supplies  
            </div>
            <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Type</th>
                        <th>Unit Quote Price</th>
                        <th>Total</th>
                        <th>Action</th>                       
                    </tr>
                </thead>
                <tbody>
                    
                    @foreach($endorsements as $key => $endorsement)
                    <tr>
                    @if($key=='Q' || $key=='S' || $key=='O')
                     {{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal', 'method' => 'POST']) }}    
                     {{ Form::hidden('request_id',$endorsement['request_id'])}}
                        <td>{{$endorsement['description']}}</td>
                        <td>{{$key}}</td>
                        <td>{{$endorsement['qty']}}</td>
                        <td>{{$endorsement['unit_quote_price']}}</td>
                        <td>{{$endorsement['qty'] * $endorsement['unit_quote_price']}}</td>
                        <td>
                            {{ Form::submit('Approve',  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$endorsement['request_id']])}} 
                        </td>
                    </tr>
                    @endif
                    @endforeach     
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>










@endsection
