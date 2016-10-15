<div class="row">
	

	<div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Multiple Axes Line Chart Example
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                  <div id="morris-line-chart"></div>
            </div>

            <div class="panel-body">
                  <div id="morris-balance-chart"></div>
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
   
</div>


@section('page_script')
<!-- <script src="{{asset('js/demo/dashboard-demo.js')}}"></script> -->

<script>
    $(function() {

  

    Morris.Line({
        element: 'morris-balance-chart',
        data: [

        @foreach($balance_chart as $period => $val)

        {
            period: '{{intval( $period/10) }} Q{{intval( $period%10) }}',
            balance: {{$val['balance']}},
            allotment: {{$val['income']}},
            expense: {{$val['expenses']}}
        }
        ,

        @endforeach
        
        ],
        xkey: 'period',
        ykeys: ['balance', 'allotment', 'expense'],
        labels: ['balance', 'allotment', 'expense'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

});



</script>


@endsection