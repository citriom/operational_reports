<html>
<head>
    <title> OpenProject Reports </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <link id="bsdp-css" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">OpenProject Reports</h3>
        </div>
	
	<h5> Project: <b> {{ $project->name}}</b> </h5>
	<h5> Total Hours: <b> {{ $hours }} </b> </h5>

	<table class="table table-bordered table-condensed table-striped">
	    <tr> <th> Date </th> <th> Resources </td> </tr>
	    @foreach( $resources as $resource)
		<tr> <td> {{ $resource->firstname }} {{ $resource->lastname }} </td> 
		     <td> 
			 <?php 
			    $hours=0;
			    foreach( $timeEntries as $timeEntry){
				if( $timeEntry->user_id==$resource->id)
				    $hours+=$timeEntry->hours;
			    }
			    echo $hours;
   			?>
		     </td>
		</tr>
	    @endforeach
	</table>

	<hr>
	<h4 class="toggle"> Entire Log Times </h4>
	<div style="display:none; max-height:300px; overflow-y:scroll">
	<table class="table table-bordered table-condensed table-striped">
	    <tr> <th> Date </th> <th> Hours </td> </tr>
	    @foreach( $timeEntries as $timeEntry)
		<tr> <td> {{ $timeEntry->spent_on}}</td> <td> {{ $timeEntry->hours }} </td></tr>
	    @endforeach
	</table>
	</div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div> <!-- /container -->

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script>
	$(document).ready( function() {
	    $(".toggle").click( function(){
		$(this).next().slideToggle();
	    });
	});
    </script>
</body>
</html>
