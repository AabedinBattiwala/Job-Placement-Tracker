<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../login.php'); exit; }
$userId = (int)$_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$bio = trim($_POST['bio'] ?? '');
$education = trim($_POST['education'] ?? '');
$skills = trim($_POST['skills'] ?? '');
$location = trim($_POST['location'] ?? '');
if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) die('Valid name and email are required.');
$stmt = $conn->prepare('UPDATE users SET name=?, email=? WHERE id=?');
$stmt->bind_param('ssi', $name, $email, $userId); $stmt->execute(); $stmt->close();
$stmt = $conn->prepare('SELECT id FROM profiles WHERE user_id=?');
$stmt->bind_param('i', $userId); $stmt->execute(); $stmt->store_result(); $exists = $stmt->num_rows > 0; $stmt->close();
if ($exists) {
    $stmt = $conn->prepare('UPDATE profiles SET phone=?, bio=?, education=?, skills=?, location=? WHERE user_id=?');
    $stmt->bind_param('sssssi', $phone, $bio, $education, $skills, $location, $userId);
} else {
    $stmt = $conn->prepare('INSERT INTO profiles (user_id, phone, bio, education, skills, location) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssss', $userId, $phone, $bio, $education, $skills, $location);
}
$stmt->execute(); $stmt->close();
$_SESSION['user_name'] = $name; $_SESSION['user_email'] = $email;
header('Location: ../profile.php?saved=1'); exit;
?>
