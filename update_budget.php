<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'finances');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch submitted form data
$category = $_POST['category'];
$amount = $_POST['amount'];

// Check if the category already has a budget
$result = $conn->query("SELECT * FROM budgets WHERE category = '$category'");

if ($result->num_rows > 0) {
    // If category exists, update the budget
    $query = "UPDATE budgets SET amount = $amount WHERE category = '$category'";
    if ($conn->query($query)) {
        echo "Budget updated successfully!";
    } else {
        echo "Error updating budget: " . $conn->error;
    }
} else {
    // If category doesn't exist, insert a new budget
    $query = "INSERT INTO budgets (category, amount) VALUES ('$category', $amount)";
    if ($conn->query($query)) {
        echo "Budget added successfully!";
    } else {
        echo "Error adding budget: " . $conn->error;
    }
}

// Redirect back to the budget page
header("Location: budget.php");
exit();
?>
