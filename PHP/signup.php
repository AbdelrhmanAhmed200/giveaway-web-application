<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();

$host = 'localhost';
$db = 'basic_login';
$usr = 'root';
$pass = '';
$connection = new mysqli($host, $usr, $pass, $db);
if ($connection->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';
$username = isset($_POST['username']) ? trim($_POST['username']) : '';

$email = $connection->real_escape_string(filter_var($email, FILTER_SANITIZE_EMAIL));
$username = $connection->real_escape_string(htmlspecialchars($username, ENT_QUOTES, 'UTF-8'));

if ($email === '') {
    echo json_encode(['success' => false, 'message' => 'Email cannot be empty']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email']);
    exit;
}
if ($pass === '') {
    echo json_encode(['success' => false, 'message' => 'Password cannot be empty']);
    exit;
}
if (strlen($pass) < 8) {
    echo json_encode(['success' => false, 'message' => 'Password less than 8 letters']);
    exit;
}
if ($username === '') {
    echo json_encode(['success' => false, 'message' => 'Enter user name']);
    exit;
}

$stmt = $connection->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'Email is already registered']);
    exit;
}
$stmt->close();

$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
$stmt = $connection->prepare("INSERT INTO users (name, email, PASS) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $email, $hashed_pass);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Sign up successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Sign up failed: ' . $stmt->error]);
}

$stmt->close();
$connection->close();
?>
