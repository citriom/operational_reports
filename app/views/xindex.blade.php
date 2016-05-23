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
		<link id="bsdp-css" href="css/bootstrap-dp.css" rel="stylesheet">

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
					{{ HTML::link('/', "Citriom Operational Reports", ['class'=>'navbar-brand']) }}
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
						<li class="nblue"><a href="/">
							<i class="fa fa-desktop"></i> Dashboard </a>
						</li>
						<li class="nblue"><a href="xusers">
							<i class="fa fa-users"></i> Users </a>
						</li>
						<li class="nblue"><a href="xprojects">
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
							<div class="col-sm-6">
								<div class="widget wblue">
									<div class="widget-head">
										<div class="pull-left"> Users Reports </div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
								  		</div>
								  		<div class="clearfix"></div>
									</div>          
									<div class="widget-content">
										<div class="padd">

		{{ Form::open(array('url' => 'hoursuser')) }}
                    <div class="form-group">
                        <select id="user_id" class="form-control input-sm" multiple="multiple" required>
                            <!--<option value="" selected disabled>Select a User...</option>-->
<?php
	session_start();
	if(!isset($_SESSION['users'])) $_SESSION['users'] = [];
?>
                            @foreach( $users as $user)
                            <option value="{{ $user->id }}" <?php if( in_array($user->id, $_SESSION['users'])) echo "selected";?>> {{ $user->firstname}} {{ $user->lastname }}</option>
                            @endforeach
                        </select>
<?php
	$_SESSION['users']=[];
?>
                    </div>
                    <div class="form-group">
                        <select id="project_id"  class="form-control input-sm" multiple="multiple">
                            <!--<option value="" selected>Select a Project (optional)...</option>-->
                            @foreach( $projects as $project)
                            <option value="{{ $project->id }}"> {{ $project->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="input-daterange input-group" id="datepicker" style="margin-top:10px">
                            <input type="text" class="input-sm form-control" name="start" required/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="end" required />
                        </div>
                    </div>
                    <button class="btn btn-success btn-sm"> Generate Report </button>
                {{ Form::close() }}

										</div>
									</div>
									<div class="widget-foot"></div>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="widget wblue">
									<div class="widget-head">
										<div class="pull-left"> Projects Reports </div>
									  	<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
									  	</div>
									  	<div class="clearfix"></div>
									</div>             
									<div class="widget-content">
									  	<div class="padd">
		{{ Form::open(array('url' => 'hoursproject')) }}
                    <div class="form-group">
                        <select id="hoursproject_id"  class="form-control input-sm" multiple="multiple" required>
                            <!--<option value="" selected>Select a Project (optional)...</option>-->
                            @foreach( $projects as $project)
                            <option value="{{ $project->id }}"> {{ $project->name}} </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="input-daterange input-group" id="datepicker">
					    <input type="text" class="input-sm form-control" name="start" />
					    <span class="input-group-addon">to</span>
					    <input type="text" class="input-sm form-control" name="end" />
					</div>
                    <button class="btn btn-success btn-sm"> Generate Report </button>
                {{ Form::close() }}										
									  	</div>
									</div>
									<div class="widget-foot"></div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">         
								<div class="widget wblue">
									<div class="widget-head">
								  		<div class="pull-left">Last Logged Hours</div>
								  		<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
								  		</div>
								  		<div class="clearfix"></div>
									</div>
									<div class="widget-content">
								  		<div class="padd">
											<ul class="chats">
											@foreach( $last->timeEntries as $timeEntry )
									  			<li class="by-me">
													<div class="avatar pull-left">
										  				<img src="http://www.gravatar.com/avatar/{{ md5(strtolower(trim($timeEntry->user->login))) }}?s=200" class="img-responsive">
													</div>
													<div class="chat-content">
										  				<div class="chat-meta"> {{ $timeEntry->user->firstname}} {{$timeEntry->user->lastname}} <span class="pull-right">{{$timeEntry->spent_on}}</span></div>
										  				{{ $timeEntry->comments }}
										  				<div class="clearfix"></div>
													</div>
									  			</li> 
											@endforeach
											</ul>
								  		</div>
									</div>
									<div class="widget-foot"></div>
							  	</div>
							</div>
							<div class="col-md-6">
							  <div class="widget wblue">
								<!-- Widget title -->
								<div class="widget-head">
								  <div class="pull-left">Projects</div>
								  <div class="widget-icons pull-right">
									<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
									<a href="#" class="wclose"><i class="fa fa-times"></i></a>
								  </div>

								  <div class="clearfix"></div>
								</div>

								<div class="widget-content">
								  <!-- Widget content -->
								  <!-- Task list starts -->
								  <ul class="project">
								  @foreach( $projects as $project )
									<li>
									  <p class="clearfix">
										<!-- Name -->
										<span class="p-heading">{{ $project->name }}</span>
									  </p>

									  <p class="p-meta">
										<!-- Due date & % Completed -->
										<span>Created: {{ date("Y-m-d", strtotime($project->created_on)) }}</span> 
									  </p>
									</li>
								  @endforeach
								  </ul>
								  <div class="clearfix"></div>  


								</div>
								<div class="widget-foot">

								</div>
							  </div>
							</div>
							
							
						</div>
						  
					</div>
				</div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->

		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<script src="js/jquery.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery-ui.min.js"></script> 

		<script src="js/bootstrap-dp.js"></script>
		<script src="js/jquery.gritter.min.js"></script>
		<script src="js/respond.min.js"></script>
		<script src="js/html5shiv.js"></script>
		<script src="js/custom.js"></script>
		<script src="js/bootstrap-multiselect.js"></script>
		<script type="text/javascript">

		$(function () {
	

	    $('.input-daterange').datepicker({
                autoclose: true,
                todayHighlight: true
            });

            $('#user_id').multiselect({
		includeSelectAllOption: true,
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
