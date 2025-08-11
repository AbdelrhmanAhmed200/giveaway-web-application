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

$stmt = $connection->prepare("select id,PASS from users where email =?");
$stmt->bind_param("s",$email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows>0) {
    $user = $result->fetch_assoc();
    if (password_verify($pass,$user['PASS'])) {
         $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success'=>true,'message'=>'login successful']);
    }else{
        echo json_encode(['success'=>false,'message'=>'wrong password']);
    }

}else{
    echo json_encode(['success'=>false,'message'=>'email not found']);
}
$stmt->close();
$connection->close();
?>