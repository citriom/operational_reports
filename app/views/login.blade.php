<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Citriom Operational Reports</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <style>
	body { padding-top: 0 }
        .input-group-addon{ color:#2B3E50 }
        .range.day{ background: rgba(0,0,0,0.2) !important; }
        .header { padding-bottom:5px  }
        .line { width:100%; border-bottom:1px solid white; margin-top:15px }
    </style>
</head>
<body>
    <div class="container">
	<div class="header clearfix" style="margin-top:10px">
            <div class="row">
                <div class="col-xs-9">
                    <h3 class="text-muted">Citriom Operational Reports</h3>
                </div>
                <div class="col-xs-2" style="padding:0; padding-top:7px">
                    <img src="http://45.55.253.74/wp-content/uploads/2015/07/logo_400px1-300x75.png" class="img-responsive" style="-webkit-filter: grayscale(100%);">
                </div>
                <div class="col-xs-1 text-right" style="padding:0; padding-top:12px">
                     <a href=""> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        {{ Form::open(['url' => 'login']) }}

            @if(Session::has('error_message'))
		<div class="alert alert-danger">
                {{ Session::get('error_message') }}
		</div>
            @endif

            <h2>Log in</h2>

	<div class="row">
	    <div class="col-sm-6 col-sm-push-3">
		<div class="form-group">
	            {{ Form::label('username', 'Username') }}
		    {{ Form::input('username', 'username', null, ['class' => 'form-control']) }}
		</div>
		<div class="form-group">
	            {{ Form::label('password', 'Password') }}
        	    {{ Form::password('password', ['class'=>'form-control']) }}
		</div>
		<div class="form-group">
	            <label>
        	        {{ Form::checkbox('remember', true) }} Remember me
	            </label>
		</div>
          	<div class="form-group">
	            {{ Form::submit('Log in', ['class' => 'btn btn-primary btn-block']) }}
		</div>
	</div>
    
        {{ Form::close() }}
	<div class="row">
	    <div class="col-sm-12">
		<div class="alert alert-info" style="padding:0">
		    <div class="row">
			<div class="col-sm-6 col-sm-push-3">
			    <a href="gauth"> <img src="img/login.png" class="img-responsive" </a>
			</div>
		    </div>
		</div>
	    </div>
	</div>
    </div>
</body>
</html>
