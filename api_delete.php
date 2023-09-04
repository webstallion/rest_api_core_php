<?php
header('Content-Type: application/json');
header('Acess-Control-Allow-Origin: *'); 
header('Acess-Control-Allow-Methods: DELETE');
include "config.php";
$data=json_decode(file_get_contents("php://input"), true); 
$id=$data['id'];
$sql="DELETE from users WHERE id='{$id}'";
if(mysqli_query($con,$sql)){
	echo json_encode(array('message'=>'Deleted successfully..', 'status'=>true));
}else{
	echo json_encode(array('message'=>'No record found.', 'status'=>false));
}
?>