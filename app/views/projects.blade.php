<html>
<head>
    <title> OpenProject Reports </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
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
                     <a href=""> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
        </div>


        <div class="row" style="margin-bottom:20px">
            <div class="col-lg-6">
                <h4>Projects</h4>
            </div>
	    <div class="col-lg-6 text-right">

	    </div>
	</div>
        <div class="row">	
	  <div class="col-sm-12">
	    <table class="table table-condensed">
		<tr>
		    <th> Name </th>
		    <th> Summary </th>
		    <th> Creation </th>
		    <th> Status </th>
		</tr>
	@foreach( $projects as $project)
		<tr>
		    <td> {{ HTML::link('/projects/'.$project->id, $project->name) }} </td>
		    <td> {{ $project->summary }} 	</td>
		    <td> {{ date("l, M. d, Y", strtotime($project->created_on)) }} 	</td>
		    @if( $project->status == 1)
		    <td> On 				</td>
		    @else
		    <td> Off 				</td>
		    @endif
		</tr>
	@endforeach
	    </table>
	  </div>
        </div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div>    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
