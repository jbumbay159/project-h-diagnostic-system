<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="<?php echo asset('public/quirk/lib/jquery-ui/jquery-ui.css') ?>">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="">
  <!--<link rel="shortcut icon" href="../images/favicon.png" type="image/png">-->

  <title>{{ config('app.name', 'Hyatt Diagnostic System') }}</title>
  <link rel="stylesheet" href="{{ asset('public/quirk/lib/fontawesome/css/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ asset('public/quirk/css/quirk.css') }}">

  <script src="{{ asset('public/quirk/lib/modernizr/modernizr.js') }}"></script>

  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!--[if lt IE 9]>
  <script src="../lib/html5shiv/html5shiv.js"></script>
  <script src="../lib/respond/respond.src.js"></script>
  <![endif]-->
  <style type="text/css">
        .signpanel{
            background-color: rgba(0,0,0,.95);
        }
  </style>
</head>

<body class="signwrapper">
    <div class="sign-overlay"></div>
    <div class="signpanel"></div>
    <div class="panel signin">
        <div class="panel-heading">
            <h1>Hyatt Diagnostic Clinic</h1>
            <h4 class="panel-title">Welcome! Please signin.</h4>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} mb10">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" name="name" placeholder="Enter Username" autofocus>
                    </div>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} nomargin">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    </div>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div><a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success btn-quirk btn-block">Sign In</button>
                </div>
            </form>
        </div>
    </div><!-- panel -->
</body>
</html>


