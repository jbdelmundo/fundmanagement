<?php use \App\Requests; ?>
<!-- MODAL FOR REJECTION -->
<div id="approve-modal-{{$request->request_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirm Purchase</h4>
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">
        <h4><strong>CAUTION</strong></h4> Once approved, this you need to undergo <strong> refund process </strong> to undo this action.
    </div>
        <p>Confirm purchase for
          <h3>            
            @if(in_array($request->category_id, [
                        Requests::BOOK, Requests::EBOOK,Requests::MAGAZINE,
                        Requests::JOURNAL, Requests::ERESOURCE] ))                                              
                {{$request->title}}                          
            @else                                            
                {{$request->description}}
            @endif
          </h3>
        </p>
        <p>Remarks:{{$request->remarks}}</p>
        <p>Recommended by:{{$request->recommendedby}}</p>
        <p>Total Price: <strong>{{$request->total_quote_price}}</strong></p>
       
      </div>
      <div class="modal-footer">
       {{ Form::open(['url' => 'approval' , 'class' => 'form-horizontal']) }} 
        {{ Form::hidden('request_id',$request->request_id)}}
        {{ Form::submit('Purchase for '.$request->total_quote_price,  ['class'=>'btn btn-success', 'id'=>'btn_approve_'.$request->id])}}
      {{ Form::close() }}
      </div>
    </div>

  </div>
</div>