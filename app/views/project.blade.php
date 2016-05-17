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
    </div>
    <div class="container">
	<div class="col-sm-12">
            <div class="row">
	    	<div class="jumbotron text-left">
  		    <h3> {{ $project->name }} </h3>
  		    <small> {{ $project->summary }} </small>
	    	</div>
	    </div>
	    <div class="row">	    
		<div class="col-sm-5">
		    <div class="row">
		    <h4> Involved Resources </h4>
		    </div>
		</div>
		
		<?php
		if( isset($_POST['datepicker']) )
		{
		    $dates=explode(' - ', $_POST['datepicker']);
		    $startDate=$dates[0];
		    $stopDate=$dates[1];
		    print_r($dates);
		}
		?>

		<div class="col-sm-7 text-right">
			<div class="row">
		    <form action="" method="">
			<div class="form-inline">
		    	<div class="form-group">
                            <div class="input-daterange input-group" id="datepicker" name="datepicker">
                            	<input type="text" class="input-sm form-control" name="start" required/>
                            	<span class="input-group-addon">to</span>
                            	<input type="text" class="input-sm form-control" name="end" required />
                            </div>
                    	</div>
			<button class="btn btn-primary" style="display:inline"> <span class="glyphicon glyphicon-search"></span></button>
			</div>
		    </form>
			</div>
		</div>
		
	        <table class="table table-condensed table-bordered table-hover">
		    <thead>
		        <tr>
			    <th width="40%"> Login </th>
			    <th width="40%"> Resource Name </th>
			    <th width="30%"> Total Hours  </th>
		        </tr>
		    </thead>
		    <tbody>
		    	@foreach( $project->resources as $resource )
		    	<tr>
			    <td> {{ HTML::link('/users/'.$resource->id, $resource->login)  }} </td>
			    <td> {{ $resource->firstname }} {{ $resource->lastname }} </td>
			    <td class="text-right">
			    <?php 
				$hours = 0;
			    	foreach( $project->timeEntries as $timeEntry ){
				    $spent_on = strtotime( $timeEntry->spent_on );
				    if( !isset($startDate) && !isset($stopDate) ){
			    	        if ( $timeEntry->login == $resource->login )
			    	            $hours+=$timeEntry->hours;		
				    }	
				    else{
					$start = strtotime($startDate);
					$stop  = strtotime($stopDate);
					//echo $spent_on."<br>";
				        if (($spent_on >= $start) && ($spent_on <= $stop))
    				        {
 					    //echo "<br>startDate:".date("Y/m/d", $start);
					    //echo "- stopDate:".date("Y/m/d", $stop);
					    //echo "- spent_on:".date("Y/m/d", $spent_on);
					    //echo $timeEntry->login." __ ".$resource->login;
			    	            if ( $timeEntry->login == $resource->login )
			    	                $hours+=$timeEntry->hours;		
			  	        }
				    }
				}
			    ?>
			     {{ $hours }} </td>
		    	</tr>
		    	@endforeach
		    <tbody>
	    	</table>
		<hr>
            </div>

	    <div class="row">	    
		<h4 class="desplegable"> Logged Hours By Resource </h4>
		<div style="max-height:300px; overflow-y:scroll; display:none">
	        <table class="table table-condensed table-bordered table-hover">
		    <thead>
		        <tr>
			    <th width="40%"> Login </th>
			    <th width="30%"> Date </th>
			    <th width="30%"> Hours </th>
		        </tr>
		    </thead>
		    <tbody>
		    	@foreach( $project->timeEntries as $timeEntry )
		    	<tr>
			    <td> {{ $timeEntry->login }} </td>
			    <td> {{ $timeEntry->spent_on}} </td>
			    <td> {{ $timeEntry->hours}} </td>
		    	</tr>
		    	@endforeach
		    <tbody>
	    	</table>
		</div>
		<hr>
            </div>
	</div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div>    
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-datetimepicker.min.js"></script>
    <script>
        $(document).ready( function() {
        $('.input-daterange').datepicker({
            autoclose: true,
            todayHighlight: true
        });
        });
    </script>

</body>
</html>
