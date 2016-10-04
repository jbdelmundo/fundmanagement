
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Library Book Fund Management System</title>



    <!-- CSS FILES ARE LOCATED IN public DIRECTORY-->

    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="{{asset('css/modern-business.css')}}" rel="stylesheet">
    <link href="{{asset('font-awesome/css/font-awesome.min.css')}} " rel="stylesheet">
    
     <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="{{asset('css/plugins/morris/morris-0.4.3.min.css')}}" ) rel="stylesheet">
    <link href="{{asset('css/plugins/timeline/timeline.css')}}" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="{{asset('css/sb-admin.css')}}" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Tables -->
    <link href="{{asset('css/plugins/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet">


</head>

<body>

    <div id="wrapper">

            @include('layouts.topnav')
            @include('layouts.sidenav')
        <div id="page-wrapper">
           @yield('content')



        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <script src="{{asset('js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>

    <!-- Page-Level Plugin Scripts - Dashboard -->
    <script src="{{asset('js/plugins/morris/raphael-2.1.0.min.js')}}"></script>
    <script src="{{asset('js/plugins/morris/morris.js')}}"></script>

    <!-- SB Admin Scripts - Include with every page -->
    <script src="{{asset('js/sb-admin.js')}}"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    <script src="{{asset('js/demo/dashboard-demo.js')}}"></script>
    
    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="{{asset('js/plugins/dataTables/jquery.dataTables.js')}}"></script>
    <script src="{{asset('js/plugins/dataTables/dataTables.bootstrap.js')}}"></script>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });

    $(document).ready(function() {
        alert('dayum');
    });
    </script>
</body>

</html>
