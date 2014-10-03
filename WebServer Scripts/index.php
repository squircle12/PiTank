<?php
 require('./websvc/config.php');
 include('./websvc/dbclass.php');
 
 
if(isset($_POST['Period'])) {
     $timePeriod = $_POST['Period'];
} else {
	$timePeriod = 30;
}
$oilPrice = returnOilRefuelPrice(1);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Oil Tank Monitor By Leigh Davies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="assets/css/bootstrap.css" media="screen">
    <link rel="stylesheet" href="assets/css/main.css">
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
    <script type="text/javascript">

    var jsonData = $.ajax({
			url: "websvc/oiltankstats.php?period=<?php echo $timePeriod; ?>",
			dataType:"json",
			async: false
			}).responseText;

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {

      // Create our data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      var options = {smoothLine: true,
		  'height':500
        };
      // Instantiate and draw our chart, passing in some options.
      // Do not forget to check your div ID
      var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
    </script>    
  </head>
  <body>
    <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="#" class="navbar-brand">Oil Tank Monitor</a>
        </div>
      </div>
    </div>

    <div class="container">    
      <div class="page-header">
        <div class="row">
          <div class="col-lg-6">		  	  
		  </div>
          </div>
          <div class="col-lg-6">
        </div>
      </div>
      
	  <div class="main" id="content">
	  	<div class="col-lg-4">

	  	  	<h3 style="text-align:center">Last Reading</h3>
			  <table class="table table-striped table-hover">
				  <tr class="">
					  <th>Time</th>
					  <th>Litres</th>
					  <th>Litres Consumed Today</th>
					  <th>Today&apos;s Cost</th>
					  <th>Tank Temp</th>
					  <th>Indoor Temp</th>
					  </tr>
					<?php $recentReading = returnMostRecentTankQty(1); ?>
						<tr class="">
							<td><?php echo $recentReading[0]["TimeStamp"]; ?></td>
							<td><?php echo $recentReading[0]["TankQty"]; ?> L</td>
							<td><?php echo $recentReading[0]["Consumed"]; ?> L</td>
							<td>£<?php echo round($recentReading[0]["Consumed"] * $oilPrice,2); ?></td>
							<td><?php echo $recentReading[0]["TankTemp"]; ?>&deg;C</td>
							<td><?php echo $recentReading[0]["RoomTemp"]; ?>&deg;C</td>
						</tr>
			  </table>
	  	</div>
	  	<div class="col-lg-4">


			  <div style="width:400px; margin-right:auto; margin-left:auto; text-align:center; vertical-align: bottom; horizontal-align:bottom;">
			  
	  	   	 <form method="POST" >
	  	   	   <label for="Time Period"> Period : </label>
	  	   	   <select id="cmbPeriod" name="Period" onchange='this.form.submit()'>
	  	   	      <option value="1" <?php if ($timePeriod == 1)  {print "selected";}?> >1 Day</option>
	  	     	  <option value="3" <?php if ($timePeriod == 3)  {print "selected";}?> >3 Days</option>
	  	   	      <option value="5" <?php if ($timePeriod == 5)  {print "selected";}?> >5 Days</option>
	  	   	      <option value="7" <?php if ($timePeriod == 7)  {print "selected";}?> >7 Days</option>
	  	   	      <option value="30" <?php if ($timePeriod == 30) {print "selected";}?> >30 Days (Default)</option>
	  	   	   </select>

	  	   	 <noscript><input type="submit" name="search" value="Search"/></noscript>
	  	    </form>
		</div>
	  	</div>
	  	<div class="col-lg-4">
  	  	  	<h3 style="text-align:center">Over the Period</h3>
			  <table class="table table-striped table-hover">
				  <tr class="">
					  <th>Start Litres</th>
					  <th>End Litres</th>
					  <th>Litres Consumed</th>
					  <th>Cost</th>
				  </tr>
					<?php $recentReading = returnTankQtyOverPeriod(1, $timePeriod); ?>
						<tr class="">
							<td><?php echo $recentReading[0]["StartQty"]; ?></td>
							<td><?php echo $recentReading[0]["EndQty"]; ?> L</td>
							<td><?php echo $recentReading[0]["Consumed"]; ?> L</td>
							<td>£<?php echo round($recentReading[0]["Consumed"] * $oilPrice,2); ?></td>
						</tr>
			  </table>
	  	</div>	  	
	  </div>
	 </div>

	 <div class="container">
	  <div id="chart_div" style="width:100%"></div>
	 </div>
	 
	 <div class="container">
      <footer>
        <div class="row">
          <div class="col-lg-12">
            <p>Made by <a href="https://www.samculley.co.uk" rel="nofollow">Leigh Davies</a>.  Contact him <a href="mailto:leigh.davies@me.com">Here</a>.</p>
          </div>
        </div>
      </footer>
    </div>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  </body>
</html>
