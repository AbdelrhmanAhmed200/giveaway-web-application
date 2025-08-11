<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$host = 'sql208.infinityfree.com';
$db = 'if0_39684393_basic_login';
$usr = 'if0_39684393';
$pass = 'Sova2006425';
$connection = new mysqli($host, $usr, $pass, $db);

if ($connection->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $connection->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo json_encode(['success' => true, 'user' => $user]);
} else {
    echo json_encode(['success' => false, 'message' => 'User not found']);
}
$stmt->close();
$connection->close();
?>
