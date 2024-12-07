<?php
// Database connection
$host = "localhost"; // Change if your DB is hosted elsewhere
$username = "root"; // Your DB username
$password = ""; // Your DB password
$dbname = "finances"; // Replace with your actual database name

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed: " . $conn->connect_error]));
}

// Initialize response structure
$response = [
    "transactions" => [],
    "categorySummary" => []
];

// Fetch all transactions
$transactionQuery = "SELECT date, category, description, amount FROM transactions ORDER BY date DESC";
$transactionResult = $conn->query($transactionQuery);

if ($transactionResult && $transactionResult->num_rows > 0) {
    while ($row = $transactionResult->fetch_assoc()) {
        $response['transactions'][] = [
            "date" => $row['date'],
            "category" => $row['category'],
            "description" => $row['description'],
            "amount" => $row['amount']
        ];
    }
}

// Fetch spending by category
$categoryQuery = "SELECT category, SUM(amount) as totalAmount FROM transactions GROUP BY category";
$categoryResult = $conn->query($categoryQuery);

if ($categoryResult && $categoryResult->num_rows > 0) {
    while ($row = $categoryResult->fetch_assoc()) {
        $response['categorySummary'][] = [
            "category" => $row['category'],
            "totalAmount" => $row['totalAmount']
        ];
    }
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
$conn->close();
?>
