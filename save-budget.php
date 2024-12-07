<?php
// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'finances';

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];
    $amount = $_POST['amount'];

    // Validate input
    if (!empty($category) && !empty($amount)) {
        // Prepare SQL statement to insert budget data
        $stmt = $conn->prepare("INSERT INTO budgets (category, amount) VALUES (?, ?)");
        $stmt->bind_param("sd", $category, $amount); // 's' for string, 'd' for double (decimal)
        if ($stmt->execute()) {
            echo "Budget saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

