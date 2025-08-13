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
$connection = new mysqli($host, $usr, $pass, $db);

if ($connection->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $connection->prepare("SELECT fname,lname, email FROM giveaways WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
   $data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode($data);
} else {
    echo json_encode(['success' => false, 'message' => 'empty list']);
}
$stmt->close();
$connection->close();
?>
