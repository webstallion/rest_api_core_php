<?php
header('Content-Type: application/json');
header('Acess-Control-Allow-Origin: *');
$data=json_decode(file_get_contents("php://input"), true);
include "config.php";
$user_id=$data['id'];
$sql="Select * from users where id = '$user_id'";
$result=mysqli_query($con,$sql) or die("Sql query failed");
if(mysqli_num_rows($result)>0){
	$output=mysqli_fetch_all($result, MYSQLI_ASSOC);
	echo json_encode($output);
}else{
	echo json_encode(array('message'=>'No record found.', 'status'=>false));
}
?>