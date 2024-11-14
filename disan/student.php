<?php 
@include 'test.php'; 

if (isset($_POST['submit_student'])) {

    
    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $accessNo = mysqli_real_escape_string($conn, $_POST['accessNo']);
    $id = mysqli_real_escape_string($conn, $_POST['ID']);
    $contact = mysqli_real_escape_string($conn, $_POST['Contact']);
    $program = mysqli_real_escape_string($conn, $_POST['Program']);
    $address = mysqli_real_escape_string($conn, $_POST['Address']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $sex = mysqli_real_escape_string($conn, $_POST['Sex']);
    $username = mysqli_real_escape_string($conn, $_POST['Username']);
    $password = password_hash($_POST['Password'], PASSWORD_BCRYPT); 
    $age = mysqli_real_escape_string($conn, $_POST['Age']);

    $sql = "INSERT INTO student (Name, accessNo, ID, Contact, Program, Address, Email, Sex, Username, Password, Age) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ssssssssssi", $name, $accessNo, $id, $contact, $program, $address, $email, $sex, $username, $password, $age);


        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Student registered successfully!</p>";
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
    <title>Student Registration</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f9; margin: 0;">
    <form method="POST" action="" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 90%; max-width: 500px; text-align: left; margin: auto;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Student Registration</h2>

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Name</label>
        <input type="text" name="Name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">accessNo</label>
        <input type="text" name="accessNo" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">ID</label>
        <input type="text" name="ID" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Contact</label>
        <input type="text" name="Contact" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Program</label>
        <input type="text" name="Program" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Address</label>
        <input type="text" name="Address" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Email</label>
        <input type="email" name="Email" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Sex</label>
        <input type="text" name="Sex" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Username</label>
        <input type="text" name="Username" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Password</label>
        <input type="password" name="Password" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Age</label>
        <input type="number" name="Age" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">

        <input type="submit" name="submit_student" value="Register" style="background-color: #4CAF50; color: #fff; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; margin-top: 20px;">
    </form>

    <?php
    // Fetch and display data from the student_registration table
    $sql = "SELECT * FROM student";
    $results = $conn->query($sql);

    if ($results->num_rows > 0) {       
        echo "<table border='1' width='100%'>
                <tr>
                    <th>Name</th>
                    <th>Access No</th>
                    <th>ID</th>
                    <th>Contact</th>
                    <th>Program</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Sex</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Age</th>
                    <th width='90px'>Actions</th>
                </tr>";

        while ($row = $results->fetch_assoc()) {
            echo "<tr>
                    <td>" . htmlspecialchars($row['Name']) . "</td>
                    <td>" . htmlspecialchars($row['accessNo']) . "</td>
                    <td>" . htmlspecialchars($row['ID']) . "</td>
                    <td>" . htmlspecialchars($row['Contact']) . "</td>
                    <td>" . htmlspecialchars($row['Program']) . "</td>
                    <td>" . htmlspecialchars($row['Address']) . "</td>
                    <td>" . htmlspecialchars($row['Email']) . "</td>
                    <td>" . htmlspecialchars($row['Sex']) . "</td>
                    <td>" . htmlspecialchars($row['Username']) . "</td>
                    <td>" . htmlspecialchars($row['Password']) . "</td>
                    <td>" . htmlspecialchars($row['Age']) . "</td>
                    <td>
                        <a href='edit.php?accessNo=" . urlencode($row['accessNo']) . "'><button>Edit</button></a>
                        <a href='delete.php?accessNo=" . urlencode($row['accessNo']) . "' onclick='return confirm(\"Are you sure?\");'><button>Delete</button></a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No students found.</p>";
    }
    ?>
</body>
</html>
