<?php
header('Content-Type: application/json');

// Database connection settings
$host = 'localhost';
$db = 'finances';
$user = 'root';
$password = '';

// Connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query for total expenditure
    $stmt = $pdo->query("SELECT SUM(amount) AS totalExpenditure FROM expenses");
    $totalExpenditure = $stmt->fetch(PDO::FETCH_ASSOC)['totalExpenditure'] ?? 0;

    // Query for recent expenses (limit to 5 for brevity)
    $stmt = $pdo->query("SELECT date, category, description, amount FROM expenses ORDER BY date DESC LIMIT 5");
    $recentExpenses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query for spending breakdown
    $stmt = $pdo->query("SELECT category, SUM(amount) AS total FROM expenses GROUP BY category");
    $breakdown = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $categories = array_column($breakdown, 'category');
    $amounts = array_column($breakdown, 'total');

    // Output JSON response
    echo json_encode([
        'totalExpenditure' => $totalExpenditure,
        'recentExpenses' => $recentExpenses,
        'breakdown' => [
            'categories' => $categories,
            'amounts' => $amounts
        ]
    ]);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    http_response_code(500);
}
