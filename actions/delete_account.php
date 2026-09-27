<?php

session_start();

require_once "../db.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: ../login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$conn->begin_transaction();

try {

    // Delete user's applications
    $stmt = $conn->prepare("DELETE FROM applications WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Delete user's profile
    $stmt = $conn->prepare("DELETE FROM profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Delete user's settings
    $stmt = $conn->prepare("DELETE FROM settings WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Delete the account
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->close();

    // Save changes
    $conn->commit();

    // Remove login session
    $_SESSION = [];
    session_destroy();

    // Send user to login page
    header("Location: ../login.php?deleted=1");
    exit;

} catch (Exception $e) {

    // Undo everything if something fails
    $conn->rollback();

    die("Account deletion failed: " . $e->getMessage());
}