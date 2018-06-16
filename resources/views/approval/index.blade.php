@extends('app')
<?php use \App\Requests; ?>
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Endorsement for Approval of {{$department->short_name}}</h1>
	</div>
</div>
@if(\Auth::user()->isLibrarian())
    @include('_active_dept_selector')
@endif

<div class="row">

	<div class="col-lg-12">
	@include('layouts._alerts')
		<div class="alert alert-info" role="alert">
		<h3 >Current Balance: {{ number_format( (float)$department->last_account_transaction()->balance,2,'.',',')  }}</h3>
	  		<h4>
	        Upon approval of the request, the amount will be deducted to your current balance.</h4>
	    </div>
	</div>
</div>

  
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements for Book, E-Books, Journals, Magazines  
    </div>
@if( 	count($endorsements['B'])+
		count($endorsements['E'])+
		count($endorsements['M'])+
		count($endorsements['J'])+
		count($endorsements['R'])+
		count($endorsements['Q'])+
		count($endorsements['S'])+
		count($endorsements['O']) > 0)
<div class="panel-body">

	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Title</th>
				<th style='width:10%'>Quantity</th>                
				<th style='width:5%'>Unit price</th>
				<th style='width:10%'>Subtotal</th> 				
				<th style='width:5%' colspan=2>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($endorsements as $type => $request_endorsement)
				@if(count($request_endorsement) >0)
					@if($type == 'B' || $type == 'E' || $type == 'M' || $type == 'J' ||$type == 'R')
						@foreach($request_endorsement as $request)
							<tr id='row_{{$request->request_id}}'>
								<td>{{$request->title}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
								<td>
									{{ Form::button('Approve',  
					                    [   'class'=>'btn btn-success',
					                        'id'=>'btn_pre_reject_'.$request->request_id,
					                        'data-toggle'=>'modal',
					                        'data-target'=>"#approve-modal-".$request->request_id
					                ]
					                )}}
					                @include('approval._modal_confirmation',['request'=>$request])
								</td>
								<td>
									{{ Form::button('Reject',  
					                    [   'class'=>'btn btn-danger',
					                        'id'=>'btn_pre_reject_'.$request->request_id,
					                        'data-toggle'=>'modal',
					                        'data-target'=>"#reject-modal-".$request->request_id
					                ]
					                )}}
								</td>

								 @include('approval._modal_rejection',['request'=>$request])
							</tr>
						@endforeach
					@endif
				@endif
			@endforeach
		</tbody>
    </table>
	
</div>	
@else
<div class="panel-body">
	No Endorsements
</div>
@endif
</div>	
<div class="panel panel-default">
    <div class="panel-heading">
	  	Endorsements for Supplies, Equipments, Others  
    </div>

@if(((count($endorsements['Q']))+(count($endorsements['S']))+(count($endorsements['O'])))>0)
<div class="panel-body">
	<table class="table table-striped table-responsive">
		<thead>
			<tr>
				<th style='width:15%'>Description</th>
				<th style='width:10%'>Quantity</th>                
				<th style='width:5%'>Unit price</th>
				<th style='width:10%'>Subtotal</th> 
				<th style='width:5%' colspan=2>Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach($endorsements as $type => $request_endorsement)
				@if(count($request_endorsement) >0)
					@if($type == 'Q' || $type == 'S' || $type == 'O')
						@foreach($request_endorsement as $request)
							<tr id='row_{{$request->request_id}}'>
								<td>{{$request->description}}</td>
								<td>{{$request->total_quote_price/$request->unit_quote_price}}</td>
								<td>{{$request->unit_quote_price}}</td>
								<td>{{$request->total_quote_price}}</td>
								<td>
									{{ Form::button('Approve',  
					                    [   'class'=>'btn btn-success',
					                        'id'=>'btn_approve_'.$request->request_id,
					                        'data-toggle'=>'modal',
					                        'data-target'=>"#approve-modal-".$request->request_id
					                ]
					                )}}
								</td>
					                @include('approval._modal_confirmation',['request'=>$request])
								<td>
									{{ Form::button('Reject',  
					                    [   'class'=>'btn btn-danger',
					                        'id'=>'btn_pre_reject_'.$request->request_id,
					                        'data-toggle'=>'modal',
					                        'data-target'=>"#reject-modal-".$request->request_id
					                ]
					                )}}
								</td>
								 
								 @include('approval._modal_rejection',['request'=>$request])
							</tr>
						@endforeach
					@endif
				@endif
			@endforeach
		</tbody>
    </table>
		
</div>	

@else
<div class="panel-body">
	No Endorsements
</div>
@endif
</div>

        @include('approval._approval_rejects',compact('rejects'))
        @include('approval._approval_approved',compact('approved'))

<script type="text/javascript">
	$(document).ready(function(){

		$('.reject_btn').click(function(e){
            request_id = $(this).val()
            reject_reason = $('#reject_reason_'+ request_id).val()
            
            console.log(request_id)

            if(reject_reason.trim() == ''){
                alert('Reason is required');
                return
            }
            console.log('reason:'+reject_reason)

            $.ajax({
                type: "POST",
                url: "{{ action('ApprovalController@reject') }}",
                data: {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'reject_reason': reject_reason                    
                } , // serializes the form's elements.
                success: function(data)
                {
                    //disable and rename buttons
                    $('#btn_pre_reject_' + request_id).addClass('disabled')
                    $('#btn_pre_reject_' + request_id).html('Rejected')
                    console.log($('#btn_pre_reject_' + request_id))
                    
                    //Get html and swap cells
                    pre_reject_btn = $('#btn_pre_reject_' + request_id).parent().html()
                    remove_link = "<a href=" + '{{ url("approval/remove/")}}' +'/'+request_id+" >Remove</a>"

                    left_cell = $('#btn_approve_' + request_id).parent()
                    right_cell = $('#btn_pre_reject_' + request_id).parent()
                    
                    left_cell.html(pre_reject_btn)
                    right_cell.html(remove_link)

                    $('#row_' + request_id).addClass('danger')
                    // alert(data); // show response from the php script.
                }
            });
        })

		$(document).keydown(function(event) { 
		      if (event.keyCode == 27) { 
		        $('.modal').modal('hide');
		      }
		    });

	})
</script>
@endsection