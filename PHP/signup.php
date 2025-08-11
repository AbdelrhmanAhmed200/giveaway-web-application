<?php
header('Content-Type: application/json');
session_start();
$host = 'sql208.infinityfree.com';
$db = 'if0_39684393_basic_login';
$usr = 'if0_39684393';
$pass = 'Sova2006425';
$connection = new mysqli($host,$usr,$pass,$db);
if ($connection ->connect_error) {
    echo json_encode(['success'=>false,'message' => 'Database connection failed']);
    exit;
}
$email = isset($_POST['email'])?$connection->real_escape_string($_POST['email']):'';
$pass = isset($_POST['password'])?$_POST['password']:'';
$usename = isset($_POST['username'])?$_POST['username']:'';
$stmt = $connection->prepare("select id,PASS from users where email =?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows>0) {
    echo json_encode(['success' => false, 'message' => 'Email is already registered']);
    exit;
}

$hashed_pass = password_hash($pass,PASSWORD_DEFAULT);

$stmt = $connection->prepare("insert into users(name,email,PASS) values (?,?,?)");
$stmt -> bind_param("sss", $usename,$email,$hashed_pass);

if ($stmt->execute()) {
    echo json_encode(['success'=>true,'message'=>'sign up successful']);
}else{
    echo json_encode(['success'=>false,'message'=>'sign up failed']);
    echo "Error: " . $stmt->error;
}

$stmt->close();
$connection->close();

?>