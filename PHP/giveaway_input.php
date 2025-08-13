<?php
session_start();

$host = 'localhost';
$db = 'basic_login';
$usr = 'root';
$pass = '';
$connection = new mysqli($host,$usr,$pass,$db);
if ($connection ->connect_error) {
    echo json_encode(['success'=>false,'message' => 'Database connection failed']);
    exit;
}
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false,'message'=> 'Not logged in']);
    exit;
}
$user_id = $_SESSION['user_id'];
$email = isset($_POST['email'])?$connection->real_escape_string($_POST['email']):'';
$fname = isset($_POST['fname'])?$_POST['fname']:'';
$lname = isset($_POST['lname'])?$_POST['lname']:'';


$stms = $connection->prepare("select email from giveaways where user_id=? and email=?");
$stms->bind_param("is",$user_id,$email);
$stms->execute();
$result = $stms->get_result();
if ($result->num_rows>0) {
    echo json_encode(['success'=>false,'message'=>'this email is aready in the giveaway']);
    exit;
}
$stms->close();

$stmsinsert = $connection->prepare("insert into giveaways(user_id ,fname,lname,email) values (?,?,?,?)");
$stmsinsert-> bind_param("isss",$user_id,$fname,$lname,$email);
if ($stmsinsert->execute()) {
    echo json_encode(['success'=>true,'message'=>'memmber add successful']);
}else {
     echo json_encode(['success'=>false,'message'=>'memmber add failed']);
    echo "Error: " . $stmsinsert->error;
}



?>