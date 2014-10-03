<?php 
 require('./config.php');
 include('./dbclass.php');
 
//    "label": "Europe (EU27)",
//    "data": [[1999, 3.0], [2000, 3.9], [2001, 2.0], [2002, 1.2]]
// {"label": "Europe (EU27)","data": [[1999, 3.0], [2000, 3.9], [2001, 2.0], [2002, 1.2]]}
// {"label": "Europe (EU27)","data":"[[1999, 3.0], [2000, 3.9], [2001, 2.0], [2002, 1.2]]"}
// {"label": "Europe (EU27)","data":[{"1999":3},{"2000":3.9},{"2001":2},{"2002":1.2}]}
 if(isset($_GET['period'])){
     $timePeriod = $_GET['period']; // make value
} else {
	$timePeriod = 30;
}
$results = returnLastPeriodTankQtys(1,$timePeriod);

//print_r ($results);
echo json_encode( $results, true );

?>