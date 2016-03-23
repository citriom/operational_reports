<html>
<head>
    <title> Operational Reports - Citriom </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css">
    <link rel="stylesheet" href="https://bootswatch.com/superhero/bootstrap.min.css"">
    <!--<link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/dataTables.bootstrap.min.css">-->
    <link id="bsdp-css" href="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/css/datepicker3.css" rel="stylesheet">
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
                    <h3 class="text-muted"> <a href="http://canopus.citriom.com/frontend/public">Citriom Operational Reports</a> </h3>
                </div>
                <div class="col-xs-2" style="padding:0; padding-top:7px">
                    <img src="http://45.55.253.74/wp-content/uploads/2015/07/logo_400px1-300x75.png" class="img-responsive" style="-webkit-filter: grayscale(100%);">
                </div>
                <div class="col-xs-1 text-right" style="padding-top:12px ">
                     <a href="http://canopus.citriom.com/frontend/public/logout"> <span class="glyphicon glyphicon-log-out"></span> </a>
                </div>
            </div>
        </div>


        <div class="row">
	    <div class="col-sm-6">
		<h4> <b> Create a new Event </b> </h4>
		<form method="post">
		    <div class="form-group">
			<label> Summary </label>
			<input class="form-control input-sm" id="summary" name="summary" required>
		    </div>
		    <div class="form-group">
			<label> Description </label>
			<input class="form-control input-sm" id="description" name="description" required>
		    </div>
		    <div class="form-group">
			<label> Date </label>
                        <div class="input-daterange input-group" id="datepicker" >
                            <input type="text" class="input-sm form-control" name="start" required/>
                            <span class="input-group-addon">to</span>
                            <input type="text" class="input-sm form-control" name="end" required />
                        </div>
		    </div>
		    <button class="btn btn-primary btn-sm"> Add Event to Calendar </button>
		</form>
	    </div>
	    <div class="col-sm-12">	
		<h4> <b> Events </b> </h4>
	    	<table id="users" class="table table-condensed table-bordered table-hovered">
		    <tr>
		        <th> Summary </th>
			<th> Description </th>
		        <th> Start Date </th>
		        <th> End Date </th>
			<th> Created </th>
			<th> </th>
		    </tr>	
		    <?php
			foreach( $results as $result){
			    $start = array_values($result['modelData']['start'])[0];
			    $end = array_values($result['modelData']['end'])[0];
		    ?>
		    <tr>
		        <td> <?= $result['summary'] ?> </td>
		        <td> <?= $result['description'] ?> </td>
		        <td> <?= date("Y-m-d", strtotime($start)) ?> </td>
		        <td> <?= date("Y-m-d", strtotime($end)) ?> </td>
			<td> <?= date("Y-m-d", strtotime($result['created'])) ?> </td>
			<td> <a href="<?=$result['htmlLink']?>" target="_blank"> <button class="btn btn-success btn-sm" > Link </button> </a> </td>
		    </tr>
		    <?php
			}
		    ?>
		</table>
	    </div>
	</div>

        <footer class="footer">
            <p>&copy; Citriom, 2015</p>
        </footer>

    </div>    
    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="http://eternicode.github.io/bootstrap-datepicker/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
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
