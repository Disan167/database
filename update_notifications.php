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
$email_notifications = isset($_POST['email_notifications']) ? 1 : 0;
$sms_notifications = isset($_POST['sms_notifications']) ? 1 : 0;
$user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session

// Update notification preferences in the database
$query = "UPDATE users SET email_notifications = ?, sms_notifications = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("iii", $email_notifications, $sms_notifications, $user_id);

if ($stmt->execute()) {
    echo "Notification preferences updated successfully.";
} else {
    echo "Error updating notification preferences.";
}

$stmt->close();
$conn->close();
?>
