<?php
header('Content-Type: application/json');
session_start();

$host = 'localhost';
$db = 'basic_login';
$usr = 'root';
$passw = '';
$connection = new mysqli($host, $usr, $passw, $db);
if ($connection->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$pass = isset($_POST['password']) ? $_POST['password'] : '';

$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$email = $connection->real_escape_string($email);

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

$stmt = $connection->prepare("SELECT id, PASS FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($pass, $user['PASS'])) {
        $_SESSION['user_id'] = $user['id'];
        echo json_encode(['success' => true, 'message' => 'Login successful']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Wrong password']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Email not found']);
}

$stmt->close();
$connection->close();
?>
