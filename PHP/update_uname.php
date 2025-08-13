<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

if (!isset($_POST['username']) || empty(trim($_POST['username']))) {
    echo json_encode(['success' => false, 'message' => 'Username is required']);
    exit;
}
$new_username =trim($_POST['username']);


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

$stmt = $connection->prepare("SELECT id FROM users WHERE name = ? AND id != ?");
$stmt->bind_param("si", $new_username, $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already taken']);
    $stmt->close();
    $connection->close();
    exit;
}
$stmt->close();

$update_stmt = $connection->prepare("UPDATE users SET name = ? WHERE id = ?");
$update_stmt->bind_param("si", $new_username, $user_id);
if ($update_stmt->execute()) {
    $_SESSION['user']['name'] = $new_username;
    echo json_encode(['success' => true, 'message' => 'Username updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update username']);
}
$update_stmt->close();
$connection->close();
exit;

?>

