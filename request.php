<?php
require "connect.php";

$limitStart = $_POST['limitStart'];
$limitCount = 50; // Set how much data you have to fetch on each request

if(isset($limitStart ) || !empty($limitStart)) {
	$query = "SELECT first_name FROM datatables_demo ORDER BY first_name limit $limitStart, $limitCount";
	$result = mysqli_query($conn, $query);
	
	$response = array();
	while($resultSet = mysqli_fetch_assoc($result)) {
		$response['html'][] = $resultSet['first_name'];
	}

	// Get total count of records
	$query 		= "SELECT count(id) as totalRec FROM datatables_demo";
	$result 	= mysqli_query($conn, $query);
	$result 	= mysqli_fetch_assoc($result);	// $response['totalRec']
	$totalRec 	= $result['totalRec'];

	$response['limitReached'] = false;
	if($limitStart >= $totalRec)
	{
		$response['limitReached'] = true;
	}

	echo json_encode($response);
}
?>