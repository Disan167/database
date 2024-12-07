<?php
@include 'bud.php'; 

if (isset($_POST['submit_department'])) {
    
    $head = mysqli_real_escape_string($conn, $_POST['category']);
    $name = mysqli_real_escape_string($conn, $_POST['amount']);
    

    $sql = "INSERT INTO expenses (amount, category) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssss", $amount, $category);
        
        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Department registered successfully!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>Error: " . $stmt->error . "</p>";
        }
        
        $stmt->close();
    } else {
        echo "<p style='text-align: center; color: red;'>Error preparing statement: " . $conn->error . "</p>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Expense - My Finances Tracker</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #000000;
            color: #f1f1f1;
            display: flex;
            flex-direction: column; /* Make the body a column layout */
            min-height: 100vh; /* Ensure body takes full height */
        }

        /* Sidebar Styles */
        .sidebar {
            background-color: #2d2d2d;
            width: 250px;
            height: 100vh;
            padding: 20px;
            box-sizing: border-box;
            position: fixed;
            left: 0;
            top: 0;
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 1000;
        }

        .sidebar.active {
            transform: translateX(0);
        }

        .sidebar h2 {
            color: #ff8c00;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: #f1f1f1;
            text-decoration: none;
            font-size: 1.1rem;
            display: block;
            transition: color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #ff8c00;
        }

        .logout {
            margin-top: 30px;
            display: block;
            color: #ff8c00;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        .logout:hover {
            color: #e77f00;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 0;
            padding: 20px;
            flex-grow: 1;
            box-sizing: border-box;
            width: 100%;
            display: flex;
            height: 100%;
            flex-direction: column;
        }

        .main-content .toggle-btn {
            background-color: #ff8c00;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1500;
        }

        .main-content {
            margin-left: 0;
            padding: 20px;
            flex-grow: 1; /* Allow main content to grow and fill available space */
            box-sizing: border-box;
            width: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            justify-content: center;
        }

        .logo img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
        }

        .logo h1 {
            color: #ff8c00;
            font-size: 2.5rem;
            margin: 0;
        }

        .budget-form {
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            margin-bottom: 20px;
        }

        .budget-form h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .budget-form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            background-color: #444;
            border: 1px solid #555;
            border-radius: 8px;
            color: #f1f1f1;
        }

        .budget-form button {
            background-color: #ff8c00;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
        }

        .budget-form button:hover {
            background-color: #e77f00;
        }

        /* Budget Overview */
        .budget-overview {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .budget-item {
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .budget-item h4 {
            margin-bottom: 10px;
        }

        .budget-item .progress-bar {
            height: 10px;
            background-color: #444;
            border-radius: 5px;
            margin-top: 10px;
        }

        .progress-bar-inner {
            height: 100%;
            background-color: #ff8c00;
            width: 0%; /* This will be dynamically updated */
            border-radius: 5px;
        }
        footer {
            background-color: #2d2d2d;
            color: #a1a1a1;
            text-align: center;
            padding: 10px;
            font-size: 0.9rem;
            margin-top: auto;
        }

    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <br><br>
        <ul>
            <li><a href="dash.html">Dashboard</a></li>
            <li><a href="userprofile.html">My Profile</a></li>
            <li><a href="addexpense.html" class="active">Add Expense</a></li>
            <li><a href="report.html">Reports</a></li>
            <li><a href="settings.html">Settings</a></li>
            <li><a href="help.html">Help/Support</a></li>
        </ul>
        <a href="logout.html" class="logout">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <button class="toggle-btn" onclick="toggleSidebar()">☰ Menu</button>

        <div class="logo">
            <img src="logo.png" alt="My Finances Tracker Logo">
            <h1>My Finances Tracker</h1>
        </div>

        <!-- Budget Form -->
        <div class="budget-form">
            <h3>Set a New Budget</h3>
            <form action="save-budget.php" method="POST">
                <input type="text" name="category" placeholder="Enter Category (e.g., Food, Entertainment)" required>
                <input type="number" name="amount" placeholder="Enter Amount ($)" required>
                <button type="submit">Set Budget</button>
            </form>
        </div>
        

        <!-- Budget Overview -->
        <div class="budget-overview">
            <?php
            // Database connection
            $conn = new mysqli('localhost', 'root', '', 'finances');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            // Fetch all budgets
            $result = $conn->query("SELECT * FROM budgets");
            while ($row = $result->fetch_assoc()) {
                $category = $row['category'];
                $budgetAmount = $row['amount'];
        
                // Fetch total expenses for this category
                $expensesResult = $conn->query("SELECT SUM(amount) AS total_expenses FROM expenses WHERE category = '$category'");
                $expensesRow = $expensesResult->fetch_assoc();
                $totalExpenses = $expensesRow['total_expenses'] ?? 0;
        
                // Calculate progress percentage
                $progress = ($totalExpenses / $budgetAmount) * 100;
                $progress = min($progress, 100); // Ensure progress doesn't exceed 100%
        
                // Display the budget item with progress bar
                echo "
                <div class='budget-item'>
                    <h4>$category</h4>
                    <p>Budget: $$budgetAmount</p>
                    <div class='progress-bar'>
                        <div class='progress-bar-inner' style='width: $progress%;'></div>
                    </div>
                </div>";
            }
            ?>
        </div>
        
        </div>
    </div>

    </div>

    <!-- Footer -->
    <footer>
        &copy; 2024 My Finances Tracker. All Rights Reserved.
    </footer>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
    </script>
</body>
</html>
