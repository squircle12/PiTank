<?php 
 require('./config.php');
 include('./dbclass.php');
 
 //The All important Variables
 $litresPerMM = 0.92;
 $totalTankCapacity = 1237; //in mm
 
 if (!empty($_GET)) 
 {
 	//check the action type
 	if (isset($_GET['action'])) 
 	{
 		switch ($_GET['action'])
 		{
 		case 'log':
 			$tankID = '1';
 			$measuredDepth = floatval($_GET['depth']) * 10; //in mm
 			$tankTemp = $_GET['tanktemp'];
 			$roomTemp = $_GET['roomtemp'];
 			$tankConsumed = $totalTankCapacity - $measuredDepth;
			$tankQty = $tankConsumed * $litresPerMM;
			logOilMeasurement($tankID, $measuredDepth, $tankQty, $tankTemp, $roomTemp);

			echo "Depth: $measuredDepth <br>Tank Consumed: $tankConsumed<br>Tank Litres Remaining: $tankQty";
 			if (SEND_EMAILS) 
			{
				// The message
				$message = print_r($_GET,true);
				// Send
				mail(SEND_ERRORS_TO, 'Received Log call from oiltank.php', $message);
			}
			break;
 		default:
			// The message
			$message = 'An issue occurred trying to process an Log request from Pi, here are the calls sent to me:';
			$message .= print_r($_GET,true);
			// Send
			mail(SEND_ERRORS_TO, 'Received Error from oiltank.php', $message);
 			break;
 		}
	}
} else {
	echo "Nothing to say";
}
?>