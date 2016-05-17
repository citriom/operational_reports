<?php

	$users_list=array();
	foreach($users as $user)
		array_push( $users_list, [$user->id, $user->firstname]);

?>
<html>
<head>
    <title> Operational Reports - Citriom </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">-->
    <link id="bsdp-css" href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <style>
	body { padding-top: 0 }
        .input-group-addon{ color:#2B3E50 }
	.range.day{ background: rgba(0,0,0,0.2) !important; }
	.header { padding-bottom:5px  }
	.line { width:100%; border-bottom:1px solid white; margin-top:15px }
	.btn a{ color:#FFF !important }
	.multiselect-container.dropdown-menu { width:100%; }
	.multiselect-container.dropdown-menu li, .multiselect-container.dropdown-menu a { height: 24px }
	.multiselect-container.dropdown-menu label { margin-top: 0; margin-bottom:0 }
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
	            <img src="http://45.55.253.74/wp-content/uploads/2015/07/logo_400px1-300x75.png" class="img-responsive" style="-webkit-filter: grayscale(100%); filter: grayscale(100%);">
	        </div>
		<div class="col-xs-1 text-right" style="padding-top:12px ">
		     <a href="logout"> <span class="glyphicon glyphicon-log-out"></span> </a>
		</div>
	    </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
                <h4>Users</h4>
		{{ HTML::link('/users', 'Users List', ['class'=>'btn btn-success btn-sm']) }}
            </div>
            <div class="col-xs-12">
                <h4>Projects</h4>
		{{ HTML::link('/projects', 'Projects List', ['class'=>'btn btn-success btn-sm']) }}
            </div>
	    <div class="col-sm-12">
		<h4> Calendar Events </h4>
		<div class="form-group">
		    <a href="{{ url('/events'); }}" class="btn btn-success btn-sm"> Events </a>
		</div>
	    </div>
        </div>
	
	<div class="line"></div>

	<div class="row">
	    <div class="col-sm-6">
		{{ Form::open(array('url' => 'hoursuser')) }}
		    <h4>Hours by User</h4>
		    <div class="form-group">
			<select id="user_id" class="form-control input-sm" multiple="multiple" required>
			    <!--<option value="" selected disabled>Select a User...</option>-->
			    @foreach( $users as $user)
			    <option value="{{ $user->id }}"> {{ $user->firstname}} {{ $user->lastname }}</option>
			    @endforeach
			</select>
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

	    <div class="col-sm-6">
		{{ Form::open(array('url' => 'hoursproject')) }}
		    <h4>Hours by Project</h4>
		    <div class="form-group">
			<select name="project_id" id="project_id"  class="form-control input-sm" required>
			    <option value="" disabled selected>Select a Project...</option>
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

	<div class="line"></div>
	
        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script src="js/bootstrap-multiselect.js"></script>
    <script>
	$(document).ready( function() {
	
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

	});
    </script>
</body>
</html>
