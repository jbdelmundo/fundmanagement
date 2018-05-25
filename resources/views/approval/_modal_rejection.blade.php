<?php use \App\Requests; ?>
<!-- MODAL FOR REJECTION -->
<div id="reject-modal-{{$request->request_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Reject Request</h4>
      </div>
      <div class="modal-body">
        <p>Enter reason for rejection for 
            @if(in_array($request->category_id, [
                        Requests::BOOK, Requests::EBOOK,Requests::MAGAZINE,
                        Requests::JOURNAL, Requests::ERESOURCE] ))                                              
                {{$request->title}}                          
            @else                                            
                {{$request->description}}
            @endif
        </p>
        {{ Form::text('reject_reason',null, 
        ['class'=>'form-control','id'=>'reject_reason_'.$request->request_id,'required']) }}
      </div>
      <div class="modal-footer">
        {{ Form::button('Reject',  
            [   'class'=>'btn btn-danger reject_btn',
                'id'=>'btn_reject_'.$request->request_id,
                'value'=>  $request->request_id  ,
                'data-dismiss'=>"modal"                                    
        ]
        )}}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>