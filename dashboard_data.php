<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "finances";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Fetch total expenditure
$totalExpenditureResult = $conn->query("SELECT SUM(amount) AS total FROM expenses");
$totalExpenditure = $totalExpenditureResult->fetch_assoc()['total'] ?? 0;

// Fetch recent expenses
$recentExpensesResult = $conn->query("SELECT date, category, description, amount FROM expenses ORDER BY date DESC LIMIT 5");
$recentExpenses = [];
while ($row = $recentExpensesResult->fetch_assoc()) {
    $recentExpenses[] = $row;
}

// Fetch spending breakdown
$breakdownResult = $conn->query("SELECT category, SUM(amount) AS total FROM expenses GROUP BY category");
$categories = [];
$amounts = [];
while ($row = $breakdownResult->fetch_assoc()) {
    $categories[] = $row['category'];
    $amounts[] = $row['total'];
}

// Prepare JSON response
$response = [
    "totalExpenditure" => $totalExpenditure,
    "recentExpenses" => $recentExpenses,
    "breakdown" => [
        "categories" => $categories,
        "amounts" => $amounts
    ]
];

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

// Close connection
$conn->close();
?>
