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

$host = 'localhost';
$db = 'basic_login';
$usr = 'root';
$pass = '';
$connection = new mysqli($host, $usr, $pass, $db);

if ($connection->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$new_username = $connection->real_escape_string(trim($_POST['username']));
$user_id = $_SESSION['user_id'];

$check_sql = "SELECT id FROM users WHERE name = '$new_username' AND id != '$user_id'";
$result = $connection->query($check_sql);

if ($result && $result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Username already taken']);
    $connection->close();
    exit;
}

$update_sql = "UPDATE users SET name = '$new_username' WHERE id = '$user_id'";
if ($connection->query($update_sql) === TRUE) {
    $_SESSION['user']['name'] = $new_username;
    echo json_encode(['success' => true, 'message' => 'Username updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update username']);
}

$connection->close();
exit;
?>
