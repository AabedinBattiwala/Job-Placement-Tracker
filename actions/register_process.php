<?php

require_once "../db.php";


// Make sure the form was submitted using POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.php");
    exit;
}


// Get form values
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";
$confirm = $_POST["confirm_password"] ?? "";


// -------------------------
// VALIDATION
// -------------------------

// Empty fields
if ($name === "" || $email === "" || $password === "" || $confirm === "") {
    header("Location: ../register.php?error=empty");
    exit;
}


// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../register.php?error=email");
    exit;
}


// Password confirmation
if ($password !== $confirm) {
    header("Location: ../register.php?error=match");
    exit;
}


// Minimum 6 characters
if (strlen($password) < 6) {
    header("Location: ../register.php?error=short");
    exit;
}


// Terms & Conditions
if (!isset($_POST["terms"])) {
    header("Location: ../register.php?error=terms");
    exit;
}


// -------------------------
// CHECK EMAIL
// -------------------------

$check = $conn->prepare(
    "SELECT id FROM users WHERE email = ?"
);

$check->bind_param("s", $email);
$check->execute();
$check->store_result();


if ($check->num_rows > 0) {

    $check->close();

    header("Location: ../register.php?error=exists");
    exit;
}

$check->close();


// -------------------------
// CREATE ACCOUNT
// -------------------------

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "INSERT INTO users (name, email, password)
     VALUES (?, ?, ?)"
);

$stmt->bind_param(
    "sss",
    $name,
    $email,
    $hash
);


// Check if account was created
if ($stmt->execute()) {

    $stmt->close();

    // Registration successful
    header("Location: ../login.php?registered=1");
    exit;

} else {

    $stmt->close();

    header("Location: ../register.php?error=failed");
    exit;
}

?>