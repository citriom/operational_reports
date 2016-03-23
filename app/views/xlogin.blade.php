<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Login - Citriom Operational Reports</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Citriom">
		<meta name="keywords" content="Citriom">
		<meta name="author" content="Pedro Xavier Escalante - @pedreska">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="favicon.ico">
	</head>
	
	<body>

		<!-- Form area -->
		<div class="admin-form">
			<!-- Widget starts -->
			<div class="widget worange">
				<!-- Widget head -->
				<div class="widget-head">
					<i class="fa fa-lock"></i> Login 
				</div>

				<div class="widget-content">
					<div class="padd">
						@if(Session::has('error_message'))
							<div class="alert alert-danger">
								{{ Session::get('error_message') }}
							</div>
						@endif

						<!-- Login form -->
						{{ Form::open(['url' => 'login', 'class'=>'form-horizontal']) }}
						<!--<form class="form-horizontal">-->
							<!-- Email -->
							<div class="form-group">
								<label class="control-label col-lg-3" for="inputEmail"> Username </label>
								<div class="col-lg-9">
									{{ Form::input('username', 'username', null, ['class' => 'form-control', 'required'=>true]) }}
								</div>
							</div>
							<!-- Password -->
							<div class="form-group">
								<label class="control-label col-lg-3" for="inputPassword">Password</label>
								<div class="col-lg-9">
									{{ Form::password('password', ['class'=>'form-control', 'required'=>true]) }}
								</div>
							</div>
							<!-- Remember me checkbox and sign in button -->
							<div class="form-group">
								<div class="col-lg-9 col-lg-offset-3">
									<div class="checkbox">
										<label>
											{{ Form::checkbox('remember', true) }} Remember me
										</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									{{ Form::submit('Log in', ['class' => 'btn btn-primary btn-block']) }}
								</div>
							</div>
						{{ Form::close() }}
						<div class="form-group">
							<div class="col-sm-8 col-sm-push-2">
								<a href="gauth">
									<img src="img/login.png" class="img-responsive">
								</a>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>  
		</div>
	

		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
	</body>	
</html>
