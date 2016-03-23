<html>
<head>
    <title> OpenProject Reports </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css">-->
    <style>
        body { padding-top: 0 }
        .input-group-addon{ color:#2B3E50 }
        .range.day{ background: rgba(0,0,0,0.2) !important; }
        .header { padding-bottom:5px  }
        .line { width:100%; border-bottom:1px solid white; margin-top:15px }
	a {     color: #df691a !important; text-decoration:none !important }
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
                    <img src="http://45.55.253.74/wp-content/uploads/2015/07/logo_400px1-300x75.png" class="img-responsive" style="-webkit-filter: grayscale(100%);">
                </div>
                <div class="col-xs-1 text-right" style="padding-top:12px ">
                     <a href="{{ action('AuthController@logOut') }}"> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
        </div>


        <div class="row">
	    <div class="col-sm-12">	
		<h4> Users </h4>
	    	<table id="users" class="table table-condensed table-bordered table-hovered">
		    <tr>
		        <th> User </th>
		        <th> Login </th>
		        <th> Last Login On</th>
		    </tr>	
		    @foreach( $users as $user)
		    <tr>
		    	<td> {{ HTML::link('/users/'.$user->id,  $user->firstname." ".$user->lastname) }} </a> </td>
			<td> {{ $user->login }} </td>
			<td> <?php if( $user->last_login_on) echo date( "l, M d, Y / h:i:s a",strtotime( $user->last_login_on)) ?> </td>
		    </tr>
		    @endforeach
	    	</table>
	     </div>
        </div>

        <footer class="footer">
            <p>&copy; Citriom, {{ date("Y") }}</p>
        </footer>

    </div>    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>
</html>
