<?php use \App\Requests; ?>

<div id="item-modal-{{$request->request_id}}" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Purchased Item</h4>
      </div>
      <div class="modal-body">
        
        
          <h3>            
            @if(in_array($request->category_id, [
                        Requests::BOOK, Requests::EBOOK,Requests::MAGAZINE,
                        Requests::JOURNAL, Requests::ERESOURCE] ))                                              
                {{$request->title}}                          
            @else                                            
                {{$request->description}}
            @endif
          </h3>
        

        <p>Remarks:{{$request->remarks}}</p>
        <p>Recommended by:{{$request->recommendedby}}</p>

        <p>Quantity: <strong>{{$request->total_quote_price/$request->unit_quote_price}}</strong></p>
        <p>Unit Price: <strong>{{$request->unit_quote_price}}</strong></p>
        <p>Total Price: <strong>{{$request->total_quote_price}}</strong></p>
        @if($request->total_bid_price > 0)
        <p>Refund: <strong>{{$request->total_quote_price - $request->total_bid_price}}</strong></p>
        @endif
       
      </div>
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>