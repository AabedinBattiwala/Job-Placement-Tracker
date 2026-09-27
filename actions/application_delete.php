<?php
session_start();
require_once '../db.php';
if (!isset($_SESSION['user_id'])) { header('Location: ../login.php'); exit; }
$id = (int)($_GET['id'] ?? 0);
if ($id > 0) {
    $stmt = $conn->prepare('DELETE FROM applications WHERE id=? AND user_id=?');
    $stmt->bind_param('ii', $id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}
header('Location: ../applications.php'); exit;
?>
