<?php
session_start();
require_once '../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../login.php'); exit; }
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare('SELECT id, name, email, password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: ../login.php?error=1'); exit;
}

session_regenerate_id(true);
$_SESSION['user_id'] = (int)$user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_email'] = $user['email'];
header('Location: ../dashboard.php');
exit;
?>
