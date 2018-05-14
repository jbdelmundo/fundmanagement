@extends('app')

@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Collections</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">

        @include('layouts._alerts')

        @if(count($aysem_collections)>0)
            <ul class="list-group">
           
            @foreach($aysem_collections as $coll)
                <li class="list-group-item">
                    <a href="{{url('collection',$coll)}}"> {{ \App\Aysem::where('aysem',$coll)->first()->short_name}} </a>
                    
                </li>
              @endforeach
            </ul>

        @else
            No collections found yet.
        @endif
        <div class="alert alert-info">
          If you wish to make changes in the collection, click 
          <strong onclick="show_form()"><a>here</a></strong>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">Collection For {{ \App\Aysem::shortName($aysem->aysem)}} </h3>
    </div>
    
    <!-- /.col-lg-12 -->
</div>





<div class="row" id='collection_history'>

    <?php $first_panel = True?>
@foreach($collections as $collection_id => $collection)

    <div class="col-lg-12">
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
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
@endforeach
</div>
<div class="row " id='adj_form'>
    <div class="col-lg-12">
        
         @include('collection._adjustment_form', compact('active_aysem_str','last_collection'))

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
    $('#adj_form').hide();

    });
    function show_form(){
        $('#adj_form').show();
        $('#collection_history').hide();
    }
    
</script>

@endsection