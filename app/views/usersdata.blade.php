<html>
<head>
    <title> OpenProject Reports </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <link id="bsdp-css" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
    <style>
	h5.project, .allprojects{
	    cursor: pointer;
	    cursor: hand;
	}
	a:hover{
	    font-weight:200;
	    text-decoration:none;
	}
    </style>
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted"> {{ HTML::link('/', 'Citriom Operational Reports') }} </h3>
        </div>
	
	<table class="table">
	@foreach( $usersdata as $userdata )
	<tr> 
	    <td> <b> {{ $userdata['firstname'] }} {{ $userdata['lastname'] }} ({{$userdata['login']}}) </b> </td>
	    <td> Total Hours: <b> {{ $userdata['hours'] }} </b> </td>
	</tr>
	@endforeach
	</table>
	
<?php /*
	<table class="table table-bordered table-condensed table-striped">
	    <tr> 
		<th> <h4 class="allprojects" title="Click to show all the Log Times"> Project </h4></th> 
		<th><h4> Hours </h4> </th> 
		<th class="text-right"><h4> </h4> </th> 
	    </tr>
	    @foreach( $projects as $project)
		<tr> 
		    <td> <h5 class="project" data-projectid="{{ $project->id }}" title="Click to show all the Log Times from {{$project->name}}">{{ $project->name }}</h5> </td> 
		    <?php
		    $hours_by_project = 0;
		    foreach( $timeEntries as $timeEntry)
		        if( $timeEntry->project_id == $project->id )
		    	    $hours_by_project+=$timeEntry->hours;
		    ?>
		    <td> <h5 class="project" data-projectid="{{ $project->id }}" title="Click to show all the Log Times from {{$project->name}}"><b>{{ $hours_by_project }}</b></h5> </td>
		    <td class="text-right">
			<button type="button" data-project_id="{{ $project->id }}" class="btn btn-primary emailform"> <span class="glyphicon glyphicon-envelope"></span> </button>
			<a href="file?user_id={{ $user->id }}&project_id={{ $project->id }}&start={{strtotime($start)}}&end={{strtotime($end)}}" class="btn btn-info"> <span class="glyphicon glyphicon-print"></span> </a> 
		    </td>
		</tr>
	    @endforeach
	</table>

	<div class="col-sm-12" id="emaildiv" style="margin:15px 0; border-top:1px solid gray; border-bottom:1px solid gray; display:none">
	    <h4> Send Report to Email </h4>
	    <form id="formemail" action="" method="get">
		<input class="hide" id="user_id" name="user_id" value="{{ $user->id  }}">
		<input class="hide" id="start" name="start" value="{{ $start }}">
		<input class="hide" id="end" name="end" value="{{ $end }}">
		<input class="hide" id="project_id" name="project_id" value="">
		<div class="row">
		    <div class="col-sm-4">
			<div class="form-group">
			    <label> Email </label>
			    <input class="form-control input-sm" id="email" name="email" required>
			</div>
			<div class="form-group">
			    <button id="sendbutton" class="btn btn-success btn-sm"> Send Report </button>
			</div>
		    </div>
		</div>
	    </form>
	</div>

	<div>
	<h5> <b>Entire Log Times</b> </h5>
	<table id="logtimes" class="table table-bordered table-condensed table-striped">
	    <thead>
	    	<tr> <th width="15%">Project</th> <th width="25%"> Date </th> <th width="50%"> Description </th> <th width="10%" class="text-center"> Hours </td> </tr>
	    </thead>
	    <tbody>
	    @foreach( $timeEntries as $timeEntry)
		<tr data-projectid="{{ $timeEntry->project_id }}"> <td> {{ $timeEntry->project->name}} </td> 
		<td> {{ date("l, M. d, Y", strtotime($timeEntry->spent_on) ) }}</td> 
		<td> {{ $timeEntry->comments }} </td>
		<td class="text-center"> {{ $timeEntry->hours }} </td></tr>
	    @endforeach
	    </tbody>
	</table>
	</div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>
*/ ?>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script>
	$(document).ready( function() {

		$(".allprojects").click(function(){
			$("#logtimes tbody tr").each( function(){
				$(this).removeClass("hide");				
			});		
		});

		$("h5.project").click(function(){
			var projectid=$(this).data("projectid");
			$("#logtimes tbody tr").each( function(){
				$(this).removeClass("hide");				
			});
			$("#logtimes tbody tr").each( function(){
				if( $(this).data("projectid")!= projectid ){
					$(this).addClass("hide");
				}
			});
		});		
		$(".emailform").click( function(){
			var project_id = $(this).data("project_id");
			$("#emaildiv").slideDown();
			$("form #email").focus();
			$("form #project_id").val(project_id);
		});
		$("form").submit( function(e){
			e.preventDefault();
			$("#sendbutton").attr("disabled", true);
			user_id = $("form #user_id").val();
			project_id = $("form #project_id").val();
			start = $("form #start").val();
			end = $("form #end").val();
			email = $("form #email").val();

			$.ajax({
			    url: "mailer",
			    data: { user_id: user_id, project_id:project_id, start:start, end:end, email:email },
			    success: function(result){
				result=JSON.parse(result);
console.log(result);
				if( result == "true" ){
				    $("form #email").val('');
				    $("#formemail").append("<div id='emailalert' class='alert alert-info'> Email Sent </div>");
				    $("#emailalert").delay(5000).slideUp();
				    $("#sendbutton").attr("disabled", false);
				}
			    }
			});
		});
	});
    </script>
</body>
</html>
