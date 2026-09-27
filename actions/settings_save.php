<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../login.php'); exit; }
$userId = (int)$_SESSION['user_id'];
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
if ($name !== '' && filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $stmt = $conn->prepare('UPDATE users SET name=?, email=? WHERE id=?');
    $stmt->bind_param('ssi', $name, $email, $userId);
    $stmt->execute();
    $stmt->close();
    $_SESSION['user_name'] = $name;
    $_SESSION['user_email'] = $email;
    $stmt = $conn->prepare('SELECT id FROM profiles WHERE user_id=?');
    $stmt->bind_param('i', $userId); $stmt->execute(); $stmt->store_result();
    $profileExists = $stmt->num_rows > 0; $stmt->close();
    if ($profileExists) {
        $stmt = $conn->prepare('UPDATE profiles SET phone=? WHERE user_id=?');
        $stmt->bind_param('si', $phone, $userId);
    } else {
        $stmt = $conn->prepare('INSERT INTO profiles (user_id, phone) VALUES (?, ?)');
        $stmt->bind_param('is', $userId, $phone);
    }
    $stmt->execute(); $stmt->close();
}
$emailNotifications = isset($_POST['email_notifications']) ? 1 : 0;
$applicationUpdates = isset($_POST['application_updates']) ? 1 : 0;
$weeklySummary = isset($_POST['weekly_summary']) ? 1 : 0;
$stmt = $conn->prepare('SELECT id FROM settings WHERE user_id=?');
$stmt->bind_param('i', $userId); $stmt->execute(); $stmt->store_result(); $exists = $stmt->num_rows > 0; $stmt->close();
if ($exists) {
    $stmt = $conn->prepare('UPDATE settings SET email_notifications=?, application_updates=?, weekly_summary=? WHERE user_id=?');
    $stmt->bind_param('iiii', $emailNotifications, $applicationUpdates, $weeklySummary, $userId);
} else {
    $stmt = $conn->prepare('INSERT INTO settings (user_id, email_notifications, application_updates, weekly_summary) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('iiii', $userId, $emailNotifications, $applicationUpdates, $weeklySummary);
}
$stmt->execute(); $stmt->close();
header('Location: ../settings.php?saved=1'); exit;
?>
