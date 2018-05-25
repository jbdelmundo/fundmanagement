
<div class="panel panel-warning">
    <div class="panel-heading">
        Rejected items for purchase 
    </div>

    <div class="panel-body">
@if(count($rejects)>0)


    <?php 
        $types = [  'B'=>'BOOK', 
                    'E'=>'E-BOOK',
                    'M'=>'MAGAZINE',
                    'J'=>'JOURNAL',
                    'R'=>'E-RESOURCE',
                    'Q'=>'EQUIPMENT',
                    'S'=>'SUPPLIES',
                    'O'=>'OTHER'];
        $total_expense = 0;
    ?>

    <table class="table table-responsive table-hover">
        <thead>
            <tr >
                <th>Title</th>      
                <th >Type</th>                              
                <th >Reject Reason</th>                
                <th >Action</th>
            </tr>
        </thead>
        <tbody>
    @foreach($rejects as $type => $request_endorsement)    

            @if(count($request_endorsement) >0)
                
                
                    @foreach($request_endorsement as $request)
                    <tr>
                        @if($type == 'Q' || $type == 'S' || $type == 'O')
                            <td>{{$request->description}}</td>
                        @else
                            <td>{{$request->title}}</td>
                        @endif
                        <td align="left">{{ $types[$type]}}</td>
                        <td>{{$request->reject_reason}}</td>
                       
                        
                        <td><a href='{{ url("endorsement/remove/". $request->request_id)}}'>Remove</a></td>

                    </tr>
                    @endforeach
                   
                
            @endif
    @endforeach
            

        </tbody>
    </table>
        
</div>
@else
    <div class="panel-body">
        No endorsements.  
    </div>

@endif
</div>
