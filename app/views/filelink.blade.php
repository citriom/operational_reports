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
	
	<div class="row">
	    <div class="col-sm-12">
		<h4> Google Drive file link </h4>
		<a href="{{ $link }}" class="btn btn-success" target="_blank"> File Link </a>
		<br><br>
	    </div>
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
	});
    </script>
</body>
</html>
