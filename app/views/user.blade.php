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
                     <a href="{{ action('AuthController@logOut') }}"> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
        </div>

	<div class="col-sm-12">
            <div class="row jumbotron text-left">	
		<div class="col-sm-9">
  		    <h3>{{ $user->firstname }} {{ $user->lastname }}</h3>
  		    <small> {{ $user->login }}
		    <div class="labels">
			<h5> Role </h5>
		    @if ( $user->admin )
			<span class="label label-success">Admin</span>
		    @else
			<span class="label label-info">User</span>
	            @endif
		    </div>
		    <div class="labels">
			<h5> Projects </h5>
			<span class="label label-danger allprojects" style="margin-right:10px"> All Projects </span>
		    @foreach( $user->projects as $project )
			<span title="Click to show all the Log Times from {{$project->name }}"class="label label-primary project" data-projectid="{{ $project->id }}" style="margin-right:10px"> {{ $project->name }} </span>
		    @endforeach
		    </div>
		    </small>
		</div>
		<div class="col-sm-3">
		    <img src="http://www.gravatar.com/avatar/{{ md5(strtolower(trim($user->login))) }}?s=200" class="img-responsive img-thumbnail">
	    	</div>
	    </div>

	    <div class="row">	    
		<h4> Log Times </h4>
		<div style="max-height:300px; overflow-y:scroll">
	   	    <table id="logtimes" class="table table-condensed table-bordered table-hover">
		    	<thead>
		    	    <tr>
				<th width="10%"> Project </th>
			    	<th width="15%" class="text-center"> Work Package </th>
			    	<th> Comments </th>
			    	<th width="30%"> Spent on </th>
			    	<th width="10%" class="text-center"> Hours </th>
		    	    </tr>
		    	</thead>
		    	<tbody>
		    	    @foreach( $user->timeEntries as $time )
		  	    <tr data-projectid="{{ $time->project_id }}">
			    	<td> {{ $time->project_name }} </td>
			    	<td class="text-center"> {{ $time->work_package_id }} </td>
			    	<td> {{ $time->comments }} </td>
			    	<td> {{ date("l, M d, Y", strtotime($time->spent_on) ) }} </td>
			    	<td class="text-center"> {{ $time->hours }} </td>
		    	    </tr>
		    	    @endforeach
		    	<tbody>
	   	    </table>
		</div>
            </div>
	</div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div>    
    <script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script>
    $(document).ready( function() {

                $(".allprojects").click(function(){
                        $("#logtimes tbody tr").each( function(){
                                $(this).removeClass("hide");
                        });
                });

                $(".label.project").click(function(){
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
