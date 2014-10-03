<?php    
function logOilMeasurement($tankID, $measuredDepth, $tankQty,$tankTemp,$roomTemp){

        require_once ('class.db.php');
        $database = new DB();
        
		$logRequest = array(
				'TankID' => $tankID,
				'MeasuredDepth' => $measuredDepth,
				'TankQty' =>$tankQty,
				'TankTemp' =>$tankTemp,
				'RoomTemp' =>$roomTemp,
				);
			$add_query = $database->insert( 'OilLog', $logRequest );
}

function returnLastPeriodTankQtys($tankID, $Period){
	require_once ('class.db.php');
	$database = new DB();
	
	$query = "SELECT ROUND(RoomTemp,2) as roomtemp, ROUND(TankTemp,2) as temp, ROUND(TankQty,0) as Qty, TimeStamp FROM `OilLog` WHERE Timestamp >= DATE_SUB(NOW(), INTERVAL " . $Period . " DAY) AND TankID = $tankID ORDER BY ID";
	$results = $database->get_results( $query );

	$rows = array();
	$table = array();
	$table['cols'] = array(array('label' => 'Datetime', 'type' => 'string'),array('label' => 'Litres', 'type' => 'number'),array('label' => 'Tank Temp', 'type' => 'number'), array('label' => 'Inside Temp', 'type' => 'number'));

	foreach($results as $row) {

		$data = array();
		$data[] = array('v' => strval($row['TimeStamp'])); 
		$data[] = array('v' => floatval($row['Qty'])); 
		$data[] = array('v' => floatval($row['temp']));
		$data[] = array('v' => floatval($row['roomtemp'])); 
		$rows[] = array('c' => $data);

	}

	$table['rows'] = $rows;

	return $table;
}

function returnOilRefuelPrice($tankID){
	//TODO STILL TO AD DATABASE TABLE AND PHP CODE FOR THE CALCULATION
	require_once ('class.db.php');
	$database = new DB();
	
	$query = "SELECT PricePerL FROM `RefuelLog` WHERE TankID = $tankID ORDER BY ID DESC LIMIT 1";
	$results = $database->get_results( $query );

	foreach($results as $row) {
			$price = floatval($row['PricePerL']); 
	}
	
	
	return $price;
}

function returnMostRecentTankQty($tankID){
	require_once ('class.db.php');
	$database = new DB();
	
	$query = "SELECT ROUND(RoomTemp,2) as roomtemp, ROUND(TankTemp,2) as temp, MeasuredDepth, Round(TankQty,0) as Qty, Time(TimeStamp) as logTime FROM `OilLog` WHERE Timestamp >= DATE_SUB(NOW(), INTERVAL 30 DAY) AND TankID = $tankID ORDER BY ID DESC LIMIT 1";
	$results = $database->get_results( $query );

	foreach($results as $row) {
			$TimeStamp = strval($row['logTime']); 
			$TankQty = floatval($row['Qty']);
			$TankTemp = floatval($row['temp']);
			$RoomTemp = floatval($row['roomtemp']); 
	}

	$query = "SELECT TankQty FROM `OilLog` WHERE TimeStamp >= CURDATE() AND TankID = $tankID ORDER BY `ID` LIMIT 1";
	$results = $database->get_results( $query );

	foreach($results as $row) {
			$StartQty = strval($row['TankQty']); 
			}
	
	$ConsumedToday = round($StartQty - $TankQty,2);
	
	$data[] = array(
		'TimeStamp' => $TimeStamp, 
		'TankQty' => $TankQty,
		'TankTemp' => $TankTemp,
		'RoomTemp' => $RoomTemp,
		'Consumed' => $ConsumedToday
		);
		
	return $data;
}

function returnTankQtyOverPeriod($tankID,$Period){
	require_once ('class.db.php');
	$database = new DB();
	
	
	$todaysDate = date("Y/m/d");
	$periodString = "-" . $Period . " days";
	$fromDate = date($todaysDate, strtotime($periodString));

	//Get Measurement 1 (from start of period)
	$query = "SELECT Timestamp, ROUND(RoomTemp,2) as roomtemp, ROUND(TankTemp,2) as temp, MeasuredDepth, Round(TankQty,0) as Qty, Time(TimeStamp) as logTime FROM `OilLog` WHERE Timestamp >= DATE_SUB(NOW(), INTERVAL " . $Period . " DAY) AND TankID = $tankID ORDER BY ID LIMIT 1";
	$results = $database->get_results( $query );

	foreach($results as $row) {
			$sopTimeStamp = strval($row['logTime']); 
			$sopDateStamp = strval($row['Timestamp']); 
			$sopTankQty = floatval($row['Qty']);
	}
	//Get Measurement 2 (Latest)
	$query2 = "SELECT Timestamp, Round(TankQty,0) AS Qty FROM `OilLog` WHERE TankID = $tankID ORDER BY `ID` DESC LIMIT 1";
	$results = $database->get_results( $query2 );

	foreach($results as $row) {
			$endQty = floatval($row['Qty']); 
			}
	
	$ConsumedOverPeriod = round($sopTankQty - $endQty ,2);
	
	$data[] = array(
		'TimeStamp' => $TimeStamp, 
		'StartQty' => $sopTankQty,
		'EndQty' => $endQty,
		'StartPeriod' => $query,
		'EndPeriod' => $todaysDate,
		'Consumed' => $ConsumedOverPeriod
		);
		
	return $data;
}


?>