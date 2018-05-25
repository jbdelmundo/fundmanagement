<div class="panel panel-default">
            <div class="panel-heading " data-toggle="collapse" data-target="#panel-{{$collection_id}}">
                ( {{ date_format($collection['created_at'],"M d, Y - H:iA") }} )
                Amount collected: {{ number_format ( $collection['amount'] ,  2 ,  "." ,  "," )  }}

            </div>
            <!-- /.panel-heading -->
            @if($first_panel)
                <div id='panel-{{$collection_id}}'class="panel-body">
                <?php $first_panel = False ?>
            @else
                <div id='panel-{{$collection_id}}'class="panel-body collapse">
                    <div class="alert alert-warning">This is an old record.</div>
            @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Department</th>
                                <th>Undergraduates</th>
                                <th>Graduates</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($departments as $dept)
                            <tr>
                                <td>{{$dept->short_name}}</td>
                                <td>{{  ($dept->is_percent_based)? '---' : $collection['statistics'][$dept->id]['undergraduate']  }}</td>
                                <td>{{  ($dept->is_percent_based)? '---' : $collection['statistics'][$dept->id]['graduate']  }}</td>
                                <td>{{  number_format ( $collection['allocations'][$dept->id] ,  2 ,  "." ,  "," ) }}</td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div><!-- /.table-responsive -->
                
                </div><!-- /.panel-body -->
            
        </div>