<?php
@include 'expense.php'; 

if (isset($_POST['submit_department'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['date']);
    $head = mysqli_real_escape_string($conn, $_POST['category']);
    $name = mysqli_real_escape_string($conn, $_POST['description']);
    $name = mysqli_real_escape_string($conn, $_POST['amount']);
    

    $sql = "INSERT INTO expenses (date, amount, description, category) VALUES (?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssss", $date, $amount, $description, $category);
        
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
            flex-direction: column;
            min-height: 100vh;
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
            justify-content: center;
            align-items: center;
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

        .main-content .toggle-btn:hover {
            background-color: #e77f00;
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

        .add-expense-form {
            background-color: #2d2d2d;
            padding: 20px;
            border-radius: 12px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
        }

        .add-expense-form h2 {
            color: #ff8c00;
            text-align: center;
            margin-bottom: 20px;
        }

        .add-expense-form label {
            display: block;
            margin: 10px 0 5px;
            font-weight: 500;
        }

        .add-expense-form input,
        .add-expense-form select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 8px;
            background-color: #444;
            color: #f1f1f1;
            font-size: 1rem;
        }

        .add-expense-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 8px;
            background-color: #ff8c00;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .add-expense-form button:hover {
            background-color: #e77f00;
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
            <li><a href="budget.html">Budget</a></li>
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

        <div class="add-expense-form">
            <h2>Add Expense</h2>
            <form action="expense.php" method="POST">
                <label for="date">Date</label>
                <input type="date" id="date" name="date" required>

                <label for="category">Category</label>
                <select id="category" name="category" required>
                    <option value="">--Select Category--</option>
                    <option value="food">Food</option>
                    <option value="entertainment">Entertainment</option>
                    <option value="tuition">Tuition</option>
                    <option value="others">Others</option>
                </select>

                <label for="description">Description</label>
                <input type="text" id="description" name="description" placeholder="e.g., Lunch at cafe" required>

                <label for="amount">Amount ($)</label>
                <input type="number" id="amount" name="amount" placeholder="e.g., 50" step="0.01" required>

                <button type="submit">Save Expense</button>
            </form>
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