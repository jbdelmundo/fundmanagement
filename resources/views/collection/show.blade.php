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

        @include('layouts.errors')

        @if(count($collections)>0)
            <ul class="list-group">
            @foreach($collections as $coll)
                <li class="list-group-item">
                    <a href="{{url('collection',$coll)}}"> {{ \App\Aysem::shortName($coll)}} </a>
                </li>
              @endforeach
            </ul>

        @else
            No collections found yet.
        @endif
         
    </div>
</div>
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header">Collection For {{ \App\Aysem::shortName($aysem->aysem)}} </h3>
	</div>
	<!-- /.col-lg-12 -->
</div>




<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            Amount collected: {{ number_format ( $collection->amount ,  2 ,  "." ,  "," )  }}
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
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
                            <td>{{  !is_null($dept->percent_allocation)? '---' : $statistics[$dept->id]['undergraduate']  }}</td>
                            <td>{{  !is_null($dept->percent_allocation)? '---' : $statistics[$dept->id]['graduate']  }}</td>
                            <td>{{  number_format ( $allocations[$dept->id] ,  2 ,  "." ,  "," ) }}</td>
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

@endsection