<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$host = 'localhost';
$db = 'basic_login';
$usr = 'root';
$pass = '';
$connection = new mysqli($host,$usr,$pass,$db);
if ($connection ->connect_error) {
    echo json_encode(['success'=>false,'message' => 'Database connection failed']);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $connection->prepare("DELETE FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
if ($stmt->execute()) {
     echo json_encode(['success'=>true,'message' => 'account deleted successfully']);
}

$stmt->close();

$connection->close();
session_unset();
session_destroy();
exit;

?>

