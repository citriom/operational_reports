<!DOCTYPE html>
<html lang="en">
	
	<head>
	
		<meta charset="utf-8">
		<title> Citriom Operational Reports </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link href="css/bootstrap.min.css" 		rel="stylesheet">
		<link href="css/jquery-ui.css" 			rel="stylesheet"> 
		<link href="css/jquery.gritter.css" 	rel="stylesheet" >
		<link href="css/font-awesome.min.css" 	rel="stylesheet">		
		<link href="css/style.css" 				rel="stylesheet">
		<link href="css/widgets.css" 			rel="stylesheet">   

		<link rel="shortcut icon" 	href="favicon.ico">

	</head>
	
	<body>

		<div class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
			<div class="container">
				<div class="navbar-header">
					<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="index" class="navbar-brand"><span class="bold">Citriom Operational Reports</span></a>
				</div>
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">     
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">            
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
								<img src="img/user.jpg" alt="" class="nav-user-pic img-responsive" /> Admin <b class="caret"></b>  
							</a>
							<ul class="dropdown-menu">
							<li><a href="settings"><i class="fa fa-cogs"></i> Settings</a></li>
							<li><a href="logout"><i class="fa fa-power-off"></i> Logout</a></li>
							</ul>
						</li>
					</ul>
				</nav>
			</div>
		</div>

		<div class="content">
			<div class="sidebar">
				<div class="sidebar-dropdown"><a href="#">Navigation</a></div>
				<div class="sidebar-inner">
					<div class="sidebar-widget">
					</div>
					<ul class="navi">
						<li class="nblue"><a href="xindex">
							<i class="fa fa-desktop"></i> Dashboard </a>
						</li>
						<li class="nblue"><a href="xusers">
							<i class="fa fa-users"></i> Users </a>
						</li>
						<li class="nblue current"><a href="xprojects">
							<i class="fa fa-cube"></i> Projects </a>
						</li>
						<li class="nblue"><a href="xgooglecal">
							<i class="fa fa-calendar"></i> Google Calendar </a>
						</li>
						<li class="nblue"><a href="xcal">
							<i class="fa fa-calendar"></i> Custom Calendar </a>
						</li>
					</ul>
				</div>
			</div>

			<div class="mainbar">
				<div class="matter">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="widget wblue">
									<div class="widget-head">
										<div class="pull-left"> Projects </div>
										<div class="widget-icons pull-right">
											<!--
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
											-->
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content medias">
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
													  <th></th>
													  <th>Name</th>
													  <th>Summary</th>
													  <th>Created</th>
													  <th> Status </th>
													</tr>
												</thead>
												<tbody>
												@foreach( $projects as $project )
												    <tr>
													<td></td>
													<td><a href="#"> {{ $project->name }} </a></td>
													<td>{{ $project->summary }}</td>
													<td> {{ date("l, M. d, Y", strtotime($project->created_on)) }}      </td>
													@if( $project->status == 1)
											                    <td> On </td>
													@else
													    <td> Off </td>
													@endif
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
									</div>
									<div class="widget-foot">
									</div>
								</div>                
							</div>
						</div>
					</div>
				</div>
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->

		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script> 

		<script src="js/jquery.gritter.min.js"></script>
		<script src="js/respond.min.js"></script>
		<script src="js/html5shiv.js"></script>
		<script src="js/custom.js"></script>
		<script type="text/javascript">
		

		$(function () {
			
			

		});
		
		</script>

	</body>
</html>
