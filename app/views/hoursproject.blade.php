<html>
<head>
    <title> OpenProject Reports </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <link id="bsdp-css" href="css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <style>
        h2{ margin:0 }
        .jumbotron h3{ margin:0 }
        .labels{ margin-top:10px }
        .label.label-info { margin-right:5px }
        body { padding-top: 0 }
        .input-group-addon{ color:#2B3E50 }
        .range.day{ background: rgba(0,0,0,0.2) !important; }
        .header { padding-bottom:5px  }
        .line { width:100%; border-bottom:1px solid white; margin-top:15px }
        a {     color: #df691a !important; text-decoration:none !important }
        .label { cursor:pointer }

    </style>
</head>
<body>
    <div class="container">
        <div class="header clearfix" style="margin-top:10px">
            <div class="row">
                <div class="col-xs-9">
                    <h3 class="text-muted"> {{ HTML::link('/', 'Citriom Operational Reports') }} </h3>
                </div>
                <div class="col-xs-2" style="padding:0; padding-top:7px">
                    <img src="http://45.55.253.74/wp-content/uploads/2015/07/logo_400px1-300x75.png" class="img-responsive"  style="-webkit-filter: grayscale(100%);">
                </div>
                <div class="col-xs-1 text-right" style="padding-top:12px ">
                     <a href="{{ action('AuthController@logOut') }}"> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
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
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script>
	$(document).ready( function() {
	    $(".toggle").click( function(){
		$(this).next().slideToggle();
	    });
	});
    </script>
</body>
</html>
