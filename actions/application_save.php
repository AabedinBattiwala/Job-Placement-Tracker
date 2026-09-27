<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../login.php'); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: ../applications.php'); exit; }

$userId = (int)$_SESSION['user_id'];
$id = (int)($_POST['id'] ?? 0);
$company = trim($_POST['company'] ?? '');
$role = trim($_POST['role'] ?? '');
$location = trim($_POST['location'] ?? '');
$date = trim($_POST['date'] ?? '');
$status = trim($_POST['status'] ?? 'Applied');
$jobLink = trim($_POST['jobLink'] ?? '');
$notes = trim($_POST['notes'] ?? '');

if ($company === '' || $role === '' || $date === '') die('Company, role and application date are required.');
$allowed = ['Applied','Interview','Selected','Rejected'];
if (!in_array($status, $allowed, true)) $status = 'Applied';

if ($id > 0) {
    $stmt = $conn->prepare('UPDATE applications SET company=?, role=?, location=?, application_date=?, status=?, job_link=?, notes=? WHERE id=? AND user_id=?');
    $stmt->bind_param('sssssssii', $company, $role, $location, $date, $status, $jobLink, $notes, $id, $userId);
} else {
    $stmt = $conn->prepare('INSERT INTO applications (user_id, company, role, location, application_date, status, job_link, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->bind_param('isssssss', $userId, $company, $role, $location, $date, $status, $jobLink, $notes);
}
$stmt->execute();
$stmt->close();
header('Location: ../applications.php');
exit;
?>
