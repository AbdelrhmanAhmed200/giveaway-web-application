<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "basic_login";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["success" => false, "message" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT fname, lname, email FROM giveaways WHERE user_id = ? ORDER BY RAND() LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "No participants found"]);
    exit;
}
$stmt->close();

$conn->close();
?>
