<?php use \App\Requests; ?>


<div class="panel panel-primary">
<div class="panel-heading">
  REQUESTS
</div>

<div class="panel-body"> 
@if(count($requests_this_sem['B'])+
    count($requests_this_sem['E'])+
    count($requests_this_sem['M'])+
    count($requests_this_sem['J'])+
    count($requests_this_sem['R'])+
    count($requests_this_sem['Q'])+
    count($requests_this_sem['S'])+
    count($requests_this_sem['O']) > 0)
    <table class="table table-striped table-responsive">
        <thead>
            <tr>
            
              <!--   <th style='width:15%'>Title</th>
                <th style='width:10%'>Author</th>
                <th style='width:10%'>Subject</th>
                <th style='width:10%'>Qty</th>
                <th style='width:10%'>Section</th> 
                <th style='width:20%'>Unit price</th>
                <th style='width:10%'>Remarks</th> 
                <th style='width:10%' colspan="2" center>Action</th> --> 
                <th >&nbsp</th>
                <th >Title</th>
                <th >Author/ <br> Publisher</th>
                <th >Subject</th>
                <th style='width:10%'>Qty</th>
                <th >Section</th> 
                <th >Unit price</th>
                <th >Remarks</th> 
                <th colspan="2" center>Action</th>                     
                
            </tr>
        </thead>
        <tbody>
    <div id="subject_required" class="modal fade" role="dialog">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                Subject is required                        
                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
              </div>
          </div>
   </div>
   <?php 
        $icons = [
            'B'=>'fa fa-book',   //book,
            'E'=>'fa fa-file', //ebook,journal magazine
            'M'=>'fa fa-file',
            'J'=>'fa fa-file',
            'R'=>'fa fa-cloud-download',  //eresource 
            'Q'=>'fa fa-cogs',
            'S'=>'fa fa-cogs',
            'O'=>'fa fa-cogs'
        ];
        $tooltip = [
            'B'=>'BOOK',   //book,
            'E'=>'E-BOOK', //ebook,journal magazine
            'M'=>'MAGAZINE',
            'J'=>'E-JOURNAL',
            'R'=>'ELECTRONIC-RESOURCE',  //eresource 
            'Q'=>'EQUIPMENT',
            'S'=>'SUPPLIES',
            'O'=>'OTHERS'
        ];
    ?>
    @foreach($requests_this_sem as $category => $items)
    @if(count($items)>0)
      
        

        @foreach($items as  $item)
            
           <tr id='row_{{$item->request_id}}'>
                <td><i class="{{$icons[$category]}}" data-toggle="tooltip" data-placement="top" title="{{$tooltip[$category]}}"></i>
                <input type='hidden' id='category_{{$item->request_id}}' value="{{$category}}"></input>
                </td>

                
                @if(in_array($category, [
                            Requests::BOOK, Requests::EBOOK,Requests::MAGAZINE,
                            Requests::JOURNAL, Requests::ERESOURCE] ))                                              
                    <td>{{$item->title}} </td>                               
                @else                                            
                    <td colspan="2">{{$item->description}}</td>
                @endif

                @if(in_array($category, [Requests::BOOK, Requests::EBOOK]))
                    <td>{{$item->author}}</td>
                @elseif(in_array($category, [Requests::MAGAZINE, Requests::JOURNAL,Requests::ERESOURCE])) 
                    <td>{{$item->publisher}}</td>
                @endif

                @if(in_array($category, [Requests::BOOK, Requests::EBOOK, Requests::MAGAZINE]))
                    <td>{{ Form::text('subject',null, 
                            ['class'=>'form-control',
                            'id'=>'subject_'.$item->request_id,
                            'required'
                        ]) }}
                    </td>
                @else
                    <td></td>
                @endif

                @if(in_array($category, [Requests::BOOK,Requests::EQUIPMENT,Requests::SUPPLIES,Requests::OTHER ]))
                    <td>{{ Form::number('quantity',1,
                            ['class'=>'form-control', 
                            'min'=>'1',
                            'id'=>'quantity_'.$item->request_id,
                            'required'
                        ]) }}
                    </td>
                @else
                    <td></td>   
                @endif

                @if(in_array($category, [Requests::BOOK]))
                    <td>{{ Form::select('is_reserved', ['0' => 'Circulation', '1' => 'Reserved'], 0, 
                            ['class'=>'form-control', 'id'=>'is_reserved_'.$item->request_id ])   }}
                    </td>
                @else
                    <td></td>
                @endif
                <td>{{$item->unit_quote_price}}</td>
                <td>
                    @if(!is_null($item->remarks) && trim($item->remarks.$item->recommendedby) != '')                    
                    <i data-toggle="modal" data-target='#remarks-modal-{{$item->request_id}}' class="fa fa-comment-o fa-fw">View</i>
                    @endif
                    
                    <div id="remarks-modal-{{$item->request_id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Remarks</h4>
                          </div>
                          <div class="modal-body">
                            <p>{{$item->remarks}}</p>
                            @if(trim($item->recommendedby) != '')
                                <p>Recommended by: {{$item->recommendedby}}</p>
                            @endif                       
                          </div>
                          <div class="modal-footer">                        
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>

                      </div>
                    </div>
                </td>
                <td>{{ Form::button('Endorse',  
                    [   'class'=>'btn btn-success approve_btn ',
                        'id'=>'btn_approve_'.$item->request_id,
                        'value'=>$item->request_id
                    ])}}
                </td>
                <td>{{ Form::button('Reject',  
                    [   'class'=>'btn btn-danger',
                        'id'=>'btn_pre_reject_'.$item->request_id,
                        'data-toggle'=>'modal',
                        'data-target'=>"#reject-modal-".$item->request_id
                ]
                )}}
                </td>
                

                <div id="reject-modal-{{$item->request_id}}" class="modal fade" role="dialog">
                  <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Reject Request</h4>
                      </div>
                      <div class="modal-body">
                        <p>Enter reason for rejection for 
                            @if(in_array($category, [
                                        Requests::BOOK, Requests::EBOOK,Requests::MAGAZINE,
                                        Requests::JOURNAL, Requests::ERESOURCE] ))                                              
                                {{$item->title}}                          
                            @else                                            
                                {{$item->description}}
                            @endif
                        </p>
                        {{ Form::text('reject_reason',null, 
                        ['class'=>'form-control','id'=>'reject_reason_'.$item->request_id,'required']) }}
                      </div>
                      <div class="modal-footer">
                        {{ Form::button('Reject',  
                            [   'class'=>'btn btn-danger reject_btn',
                                'id'=>'btn_reject_'.$item->request_id,
                                'value'=>  $item->request_id  ,
                                'data-dismiss'=>"modal"                                    
                        ]
                        )}}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>

                  </div>
                </div>

            </tr>
            
        @endforeach 
            
            
            
     @endif
    @endforeach
        </tbody>
    </table>
@else
    Nothing to endorse
@endif
</div><!-- panel body -->
</div><!-- panel -->
            

<script type="text/javascript">
    $(document).ready(function(){
        is_reserved_choices = ['Circulation','Reserved','']

        $('.approve_btn').click(function(e){
            request_id = $(this).val()
            category = $('#category_' + request_id).val()

            console.log('req:'+request_id)
            console.log('cat:'+category)
            
            subject = ''
            quantity = ''
            is_reserved = 2     // the 2nd index is blank in is_reserved_choices
            // only in books
            if(category == 'B'){
                subject = $('#subject_' + request_id).val()
                quantity = $('#quantity_' + request_id).val()            
                is_reserved = $('#is_reserved_' + request_id).val()

                if(subject.trim() == ''){
                    // alert('Subject is required');
                    $('#subject_required').modal('show')
                    close_modal_delay(2000)
                    return
                }
                data_to_send = {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'subject': subject,
                    'quantity':quantity,
                    'is_reserved':is_reserved
                }
            }else if(category == 'E' || category == 'M' ){
                subject = $('#subject_' + request_id).val()
                if(subject.trim() == ''){
                    alert('Subject is required');
                    return
                }
                data_to_send = {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'subject': subject,
                    'quantity':1
                }
            }else if(category == 'R' || category == 'J' ){
                data_to_send = {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'quantity':1
                }

            }else if (category == 'Q' || category == 'S' || category == 'O' ){
                quantity = $('#quantity_' + request_id).val()
                data_to_send = {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'quantity':quantity
                }
            }
            
            $.ajax({
                type: "POST",
                url: "{{ action('RequestEndorsementController@create') }}",
                data: data_to_send , // serializes the form's elements.
                success: function(data)
                {
                    //update row to values and remove buttons
                    $('#subject_' + request_id).parent().html(subject)
                    $('#quantity_' + request_id).parent().html(quantity)
                    $('#is_reserved_' + request_id).parent().html(is_reserved_choices[is_reserved])

                    $('#btn_approve_' + request_id).addClass('disabled')
                    $('#btn_approve_' + request_id).html('Endorsed')
                    
                    remove_link = "<a href=" + '{{ url("endorsement/remove/")}}' +'/'+request_id+" >Remove</a>"
                    $('#btn_pre_reject_' + request_id).parent().html(remove_link)
                    // alert(data); // show response from the php script.
                    $('#row_' + request_id).addClass('success')

                    $('.alert-refresh-to-reflect').fadeIn()

                }
            });



        })

        $('.reject_btn').click(function(e){
            request_id = $(this).val()
            reject_reason = $('#reject_reason_'+ request_id).val()
            subject = $('#subject_' + request_id).val()
            quantity = $('#quantity_' + request_id).val()            
            is_reserved = $('#is_reserved_' + request_id).val()
            console.log(request_id)

            if(reject_reason.trim() == ''){
                alert('Reason is required');
                return
            }
            console.log('reason:'+reject_reason)

            $.ajax({
                type: "POST",
                url: "{{ action('RequestEndorsementController@reject') }}",
                data: {
                    '_token':"{{ csrf_token() }}",
                    'request_id':request_id,
                    'reject_reason': reject_reason                    
                } , // serializes the form's elements.
                success: function(data)
                {
                    $('#subject_' + request_id).attr('disabled','disabled')
                    $('#quantity_' + request_id).attr('disabled','disabled')
                    $('#is_reserved_' + request_id).attr('disabled','disabled')

                    
                    //disable and rename buttons
                    $('#btn_pre_reject_' + request_id).addClass('disabled')
                    $('#btn_pre_reject_' + request_id).html('Rejected')
                    
                    //Get html and swap cells
                    pre_reject_btn = $('#btn_pre_reject_' + request_id).parent().html()
                    remove_link = "<a href=" + '{{ url("endorsement/remove/")}}' +'/'+request_id+" >Remove</a>"

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

        function close_modal_delay(delay){
            window.setTimeout(function(){
                 $('.modal').modal('hide');
              }, delay)
        }
    })
</script>
<style>
/*for centering the modal vertically*/
.modal {
  text-align: center;
  padding: 0!important;
}

.modal:before {
  content: '';
  display: inline-block;
  height: 100%;
  vertical-align: middle;
  margin-right: -4px; /* Adjusts for spacing */
}

.modal-dialog {
  display: inline-block;
  text-align: left;
  vertical-align: middle;
}
</style>