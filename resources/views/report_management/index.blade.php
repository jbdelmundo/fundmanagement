@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Reports</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="row">
    <div class="col-lg-12">

        @include('layouts._alerts')
        
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Transactions for  {{$department->short_name}}</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @foreach($last_three_sems as $sem)
                            <th style="text-align: right">{{$sem->short_name}}</th>
                        @endforeach                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($sem_details_labels as $label)
                    
                    <tr>
                        <td style="text-align: left">{{strtoupper(str_replace("_"," ",$label))}}</td>
                        @foreach($sem_details as $aysem => $detail)
                        <td style="text-align: right">{{$sem_details[$aysem][$label]  }}</td>
                        @endforeach
                    </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Expense breakdown for  {{$department->short_name}}</h3>
            </div>
            <div class="panel-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>&nbsp;</th>
                        @foreach($last_three_sems as $sem)
                            <th style="text-align: right">{{$sem->short_name}}</th>
                        @endforeach                        
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total_expenses = 0;
                    ?>
                    @foreach($expenses_items as $key => $label)                    
                    <tr>
                        <td style="text-align: left">{{strtoupper(str_replace("_"," ",$label))}}</td>
                        @foreach($expenses as $aysem => $detail)
                        <td style="text-align: right">{{number_format((float)$expenses[$aysem][$key],2)  }}</td>
                        <?php $total_expenses += (float)$expenses[$aysem][$key] ?>
                        @endforeach
                    </tr>
                    @endforeach
                    <tr>
                        <td><strong>TOTAL:</strong></td>
                        <td style="text-align: right"><strong>
                            {{number_format((float)$total_expenses, 2)}}
                        </strong></td>
                    </tr>
                </tbody>
            </table>
            </div>
        </div>
       
        
    </div>
</div>




@endsection