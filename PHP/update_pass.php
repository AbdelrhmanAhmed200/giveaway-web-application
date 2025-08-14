<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "basic_login";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

$current_password = trim($_POST['current_password'] ?? '');
$new_password = trim($_POST['new_password'] ?? '');

if ($current_password === '' || $new_password === '') {
    echo json_encode(["success" => false, "message" => "All fields are required"]);
    exit;
}
if (strlen($new_password) < 8) {
    echo json_encode(["success" => false, "message" => "New password must be at least 8 characters long"]);
    exit;
}

$sql = "SELECT PASS FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->bind_result($db_pass_hash);
$stmt->fetch();
$stmt->close();

if (!password_verify($current_password, $db_pass_hash)) {
    echo json_encode(["success" => false, "message" => "Current password is incorrect"]);
    $conn->close();
    exit;
}

$new_pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
$update_sql = "UPDATE users SET PASS = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $new_pass_hash, $user_id);

if ($update_stmt->execute()) {
    session_unset();
    session_destroy();
    echo json_encode(["success" => true, "message" => "Password updated successfully. Please log in again."]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update password"]);
}

$update_stmt->close();
$conn->close();
