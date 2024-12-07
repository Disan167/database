<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "finances");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Retrieve user from database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Login successful: Redirect to dashboard
            echo "<script>
                    alert('Login successful! Welcome back.');
                    window.location.href = 'dashboard.html';
                  </script>";
        } else {
            // Incorrect password
            echo "<script>
                    alert('Invalid login. Please check your email and password.');
                    window.location.href = 'login.php';
                  </script>";
        }
    } else {
        // No account found
        echo "<script>
                alert('No account found with that email.');
                window.location.href = 'login.php';
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
