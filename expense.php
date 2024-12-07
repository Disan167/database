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
    $date = $_POST['date'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    // Validate input
    if (!empty($date) && !empty($category) && !empty($description) && !empty($amount)) {
        // Prepare SQL statement
        $stmt = $conn->prepare("INSERT INTO expenses (date, category, description, amount) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssd", $date, $category, $description, $amount);

        if ($stmt->execute()) {
            echo "<script>
                alert('Expense saved successfully!');
                window.location.href = 'addexpense.html';
            </script>";
        } else {
            echo "<script>
                alert('Failed to save expense. Please try again.');
                window.location.href = 'addexpense.html';
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('All fields are required!');
            window.location.href = 'addexpense.html';
        </script>";
    }
}

$conn->close();
?>
