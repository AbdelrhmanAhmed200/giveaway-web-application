<?php
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

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$fname = isset($_POST['fname']) ? trim($_POST['fname']) : '';
$lname = isset($_POST['lname']) ? trim($_POST['lname']) : '';

$email = $connection->real_escape_string(filter_var($email, FILTER_SANITIZE_EMAIL));
$fname = $connection->real_escape_string(htmlspecialchars($fname, ENT_QUOTES, 'UTF-8'));
$lname = $connection->real_escape_string(htmlspecialchars($lname, ENT_QUOTES, 'UTF-8'));

if ($email === '') {
    echo json_encode(['success' => false, 'message' => 'Email cannot be empty']);
    exit;
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email']);
    exit;
}
if ($fname === '' || $lname === '') {
    echo json_encode(['success' => false, 'message' => 'First name or last name is empty']);
    exit;
}

$stms = $connection->prepare("SELECT email FROM giveaways WHERE user_id = ? AND email = ?");
$stms->bind_param("is", $user_id, $email);
$stms->execute();
$result = $stms->get_result();
if ($result->num_rows > 0) {
    echo json_encode(['success' => false, 'message' => 'This email is already in the giveaway']);
    exit;
}
$stms->close();

$stmsinsert = $connection->prepare("INSERT INTO giveaways (user_id, fname, lname, email) VALUES (?, ?, ?, ?)");
$stmsinsert->bind_param("isss", $user_id, $fname, $lname, $email);
if ($stmsinsert->execute()) {
    echo json_encode(['success' => true, 'message' => 'Member add successful']);
} else {
    echo json_encode(['success' => false, 'message' => 'Member add failed: ' . $stmsinsert->error]);
}
?>
