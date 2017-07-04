<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fund Management SYstems</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/modern-business.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <style>
    body {
        padding-top: 50px;
       /* body padding for fixed top nav */
      }
    </style>
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- You'll want to use a responsive image option so this logo looks good on devices - I recommend using something like retina.js (do a quick Google search for it and you'll find it) -->
                <a class="navbar-brand" href="{{url('')}}">Library Fund Management System</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <form class="navbar-form navbar-right" role="form" method='post' action="{{ url('/login') }}">
                
                        {{ csrf_field() }}
                <div class="form-group">
                  <input id="username" type="text" class="form-control" placeholder="Username" name="username" value="{{ old('username') }}" required autofocus>
                </div>
                <div class="form-group">
                 
                  <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>

                </div>
                
                <button type="submit" class="btn btn-success">Sign in</button>
              </form>
        </div>
        <!-- /.container -->
    </nav>

    <div id="myCarousel" class="carousel slide">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <div class="fill" style="background-image:url('{{asset("img/melchor.jpg")}}');"></div>
                <div class="carousel-caption">
                   <!-- <h1>Library Fund Management System</h1>-->
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('{{asset("img/melchor2.jpg")}}');"></div>
               
                <div class="carousel-caption">
                   <!-- <h1>Online Monitoring</h1>-->
                </div>
            </div>
            <div class="item">
                <div class="fill" style="background-image:url('{{asset("img/melchor3.jpg")}}');"></div>
               
                <div class="carousel-caption">
                  <!--  <h1>Built-in Accounting System-->
                    </h1>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#myCarousel" data-slide="prev">
            <span class="icon-prev"></span>
        </a>
        <a class="right carousel-control" href="#myCarousel" data-slide="next">
            <span class="icon-next"></span>
        </a>
    </div>

    <div class="section">

        <div class="container">

            <div class="row">
                <div class="col-lg-4 col-md-4">
                    <h3><i class="fa fa-check-circle"></i> Library Fund Management System</h3>
                    <p>Coordinate the efforts of people to accomplish goals and objectives using available resources efficiently and effectively.</p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h3><i class="fa fa-check-circle"></i> Transaction Management</h3>
                    <p>The practice of managing information technology (IT) from a business transaction perspective</p>
                </div>
                <div class="col-lg-4 col-md-4">
                    <h3><i class="fa fa-check-circle"></i> Built-in Accounting System</h3>
                    <p>Accounting, or accountancy, is the measurement, processing and communication of financial information about economic entities.</p>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.section -->

    <div class="section-colored text-center">

        <div class="container">

            <div class="row">
                <div class="col-lg-12">
                    <h2>Library Fund Management System: Computerized System For Library Aquisitions</h2>
                    <p>A complete website featuring various tools for your library fund management.</p>
                    <hr>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->

    </div>
    <!-- /.section-colored -->

   

    <div class="container">

        <hr>

        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>UP College of Engineering Library &copy; 2013</p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->

    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/modern-business.js"></script>

</body>

</html>
