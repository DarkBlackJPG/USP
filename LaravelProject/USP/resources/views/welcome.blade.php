<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SHM-AUTO</title>

        <!-- Favicon -->
        <link rel="icon" href="{{asset('img/logo_white.png')}}" type="image/gif" sizes="16x16">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

        <!-- Styles -->
        <style>
            html, body {
                background-color: #292b2c;
                color: #f0ad4e;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #fff;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body class="bg-dark">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}" style="color: darkorange;!important;">Home</a>
                    @else
                        <a href="{{ route('login') }}" style="color: darkorange;!important;">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" style="color: darkorange;!important;">Register</a>
                        @endif
                    @endauth
                    <hr>
                </div>
            @endif

            <div class="content">
                @if($success = Session::get('success_logout'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Uspeh!',
                            text: 'Uspešno ste se izlogovali!'
                        })
                    </script>
                @endif
                <div class="title m-b-md">
                    SHM - AUTO
                </div>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">

                        <div class="item active">
                            @auth
                                <a href="">
                            @endauth
                            <img src="img/irrigation_sprinkle.jpg" alt="irrigation system" style="width:100%; height: 300px;">
                            @auth
                                </a>
                            @endauth
                            <div class="font-weight-bold text-center">
                                <h4 style="color: darkorange;">Sistem za navodnjavanje</h4>
                            </div>
                        </div>

                        <div class="item">
                            <img src="img/drone_in_field.jpg" alt="drone" style="width:100%; height: 300px;">
                            <div class="font-weight-bold text-center">
                                <h4 style="color: darkorange;">Sistem za nadzor polja</h4>
                            </div>
                        </div>

                        <div class="item">
                            <img src="img/sensor_field.jpg" alt="sensor" style="width:100%; height: 300px; ">
                            <div class="font-weight-bold text-center">
                                <h4 style="color: darkorange;">Senzori za analizu uslova</h4>
                            </div>
                        </div>

                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
        <footer style="position: fixed; bottom: 2px; right: 4px;">
            <a href="{{ url('/home') }}">
                <img src="/img/logo.png" alt="SHM-AUTO_logo" class="float-right img-fluid">
            </a>
        </footer>
    </body>
</html>
