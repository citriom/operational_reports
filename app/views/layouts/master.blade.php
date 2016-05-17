<!DOCTYPE html> <html lang="en">	
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
		<link id="bsdp-css" href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
		<link rel="shortcut icon" 	href="favicon.ico">
		<style>
	        .multiselect-container.dropdown-menu { width:100%; }
	        .multiselect-container.dropdown-menu li, .multiselect-container.dropdown-menu a { height: 24px }
	        .multiselect-container.dropdown-menu label { margin-top: 0; margin-bottom:0 }
		</style>
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
					<a href="http://canopus.citriom.com/frontend/public" class="navbar-brand">Citriom Operational Reports</a>
				</div>
				<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation">     
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">            
							<?php
                                                                $log=Session::get('user');
                                                                $user=User::where('email', $log['username'])->first();
                                                        ?>
                                                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                                                <img src="http://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->email))) }}?s=200" alt="" class="nav-user-pic img-responsive" />
                                                                {{$user->first_name}} {{$user->last_name}} <b class="caret"></b>
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
						<li class="nblue">
							<a href="{{ url('/') }}"> <i class="fa fa-desktop"></i> Dashboard </a>
						</li>
						<li class="nblue">
							<a href="{{ url('/xusers') }}"> <i class="fa fa-users"></i> Users </a>
						</li>
						<li class="nblue">
							<a href="{{ url('/xprojects') }}"> <i class="fa fa-cube"></i> Projects </a>
						</li>
						<li class="nblue">
							<a href="{{ url('/xgooglecal') }}"> <i class="fa fa-calendar"></i> Google Calendar </a>
						</li>
						<li class="nblue">
							<a href="{{ url('/xcal') }}"> <i class="fa fa-calendar"></i> Custom Calendar </a>
						</li>
					</ul>
				</div>
			</div>
			<div class="mainbar">
				<div class="matter">
					
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script> 
		<script src="js/jquery.gritter.min.js"></script>
		<script src="js/respond.min.js"></script>
		<script src="js/html5shiv.js"></script>
		<script src="js/custom.js"></script>
		<script src="js/bootstrap-datetimepicker.min.js"></script>
		<script src="js/bootstrap-multiselect.js"></script>
		<script type="text/javascript">
		$(function () {
	    	$('.input-daterange').datepicker({
                autoclose: true,
                todayHighlight: true
            });

            $('#user_id').multiselect({
                maxHeight:200,
                checkboxName: 'users[]',
                buttonClass: 'btn btn-success btn-sm',
                buttonWidth: '100%',
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Select User(s)';
                    }
                    else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                   }
                }
            });

		
	    	$('#project_id').multiselect({
                maxHeight:200,
                checkboxName: 'projects[]',
                buttonClass: 'btn btn-success btn-sm',
                buttonWidth: '100%',
                buttonText: function(options, select) {
                    if (options.length === 0) {
                        return 'Select Project(s)';
                    }
                    else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + '';
                   }
                }
            });

		$('#hoursproject_id').multiselect({
            maxHeight:200,
            checkboxName: 'hoursprojects[]',
            buttonClass: 'btn btn-success btn-sm',
            buttonWidth: '100%',
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return 'Select Project(s)';
                }
                else {
                 var labels = [];
                 options.each(function() {
                     if ($(this).attr('label') !== undefined) {
                         labels.push($(this).attr('label'));
                     }
                     else {
                         labels.push($(this).html());
                     }
                 });
                 return labels.join(', ') + '';
               }
            }
        });

	});
		
	</script>

	</body>
</html>
