<?php
session_start();
header('Content-Type: application/json');

// Database connection
$host = "sql208.infinityfree.com";
$user = "if0_39684393";
$pass = "Sova2006425";
$dbname = "if0_39684393_basic_login";
$conn = new mysqli($host, $user, $pass, $dbname);

// Check DB connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed"]);
    exit;
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];

// Get input data
$current_password = $_POST['current_password'] ?? '';
$new_password = $_POST['new_password'] ?? '';



// Get the current password hash from DB
$sql = "SELECT PASS FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "User not found"]);
    exit;
}

$stmt->bind_result($db_pass_hash);
$stmt->fetch();

// Verify current password
if (!password_verify($current_password, $db_pass_hash)) {
    echo json_encode(["success" => false, "message" => "Current password is wrong"]);
    exit;
}

// Hash new password
$new_pass_hash = password_hash($new_password, PASSWORD_DEFAULT);

// Update password in DB
$update_sql = "UPDATE users SET PASS = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param("si", $new_pass_hash, $user_id);

if ($update_stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Password updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update password"]);
}

$stmt->close();
$update_stmt->close();
$conn->close();
session_unset();
session_destroy();
?>
