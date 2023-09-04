<?php 
header('Content-Type: application/json');
header('Acess-Control-Allow-Origin: *');
header('Acess-Control-Allow-Methods: PUT');
$data=json_decode(file_get_contents("php://input"), true);
$id=$data['id'];
$firstname=$data['firstname'];
$lastname=$data['lastname'];
$flag=$data['flag'];

include "config.php";
$sql="UPDATE users SET firstname='{$firstname}', lastname='{$lastname}', flag='{$flag}' WHERE id= '{$id}'";
if(mysqli_query($con,$sql)){
	echo json_encode(array('message'=>'Record update successfully..', 'status'=>true));
}else{
	echo json_encode(array('message'=>'Record not updated.', 'status'=>false));
}