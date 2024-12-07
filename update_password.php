<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");  // Redirect to login if not logged in
    exit();
}

// Database connection
include 'db_connection.php';

// Get the form data
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_new_password = $_POST['confirm_new_password'];
$user_id = $_SESSION['user_id'];

// Check if new passwords match
if ($new_password !== $confirm_new_password) {
    echo "Passwords do not match!";
    exit();
}

// Check if current password is correct
$query = "SELECT password FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($hashed_password);
$stmt->fetch();
$stmt->close();

if (!password_verify($current_password, $hashed_password)) {
    echo "Current password is incorrect.";
    exit();
}

// Hash the new password and update it
$new_password_hashed = password_hash($new_password, PASSWORD_BCRYPT);

$query = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("si", $new_password_hashed, $user_id);

if ($stmt->execute()) {
    echo "Password updated successfully.";
} else {
    echo "Error updating password.";
}

$stmt->close();
$conn->close();
?>
