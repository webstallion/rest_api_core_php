<?php 
header('Content-Type: application/json');
header('Acess-Control-Allow-Origin: *');
header('Acess-Control-Allow-Methods: POST');
$data=json_decode(file_get_contents("php://input"), true);
$firstname=$data['firstname'];
$lastname=$data['lastname'];
$flag=$data['flag'];
include "config.php";
$sql="INSERT INTO users(firstname, lastname, flag) values ('{$firstname}', '{$lastname}', '{$flag}')";
if(mysqli_query($con,$sql)){
	echo json_encode(array('message'=>'Record insert successfully..', 'status'=>true));
}else{
	echo json_encode(array('message'=>'Record not inserted.', 'status'=>false));
}