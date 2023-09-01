<?php
header('Content-Type: application/json');
header('Acess-Control-Allow-Origin: *'); 
include "config.php";
$sql="Select * from users";
$result=mysqli_query($con,$sql) or die("Sql query failed");
if(mysqli_num_rows($result)>0){
	//$output=mysqli_fetch_all($result, );
	$output=mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($output);
}else{
	echo json_encode(array('message'=>'No record found.', 'status'=>flase));
}
?>