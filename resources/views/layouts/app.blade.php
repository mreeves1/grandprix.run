<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Grandprix.run</title>
        {!! Html::style('components/bootstrap/css/bootstrap.css') !!}
        {!! Html::style('components/bootstrap/css/bootstrap-theme.css') !!}
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">GrandPrix.run</a>
                </div>
                <div id="navbar" class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::path() == '/' ? 'active' : '' }}"><a href="/">Home</a></li>
                        <li class="{{ Request::path() == 'records' ? 'active' : '' }}"><a href="/records">Records</a></li>
                        <li class="{{ Request::path() == 'clubs' ? 'active' : '' }}"><a href="/clubs">Clubs</a></li>
                        <li class="{{ Request::path() == 'runners' ? 'active' : '' }}"><a href="/runners">Runners</a></li>
                    </ul>
                </div><!--/.nav-collapse -->
            </div>
        </nav>
        <div class="container-fluid" style="margin-top:50px;">

            <div class="page-header">
                <h1>{{ $title }}</h1>
            </div>

            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    @yield('content')
                </div>
                <div class="col-md-1"></div>
            </div>

        </div>

        <!-- TODO: Minify things later -->
        <script type="text/javascript" src="{{ $jquery_url = App::environment('production') ? URL::asset('components/jquery/jquery.min.js') : URL::asset('components/jquery/jquery.js') }}"></script>
        {!! Html::script('components/bootstrap/js/bootstrap.js') !!}

    </body>
</html>
