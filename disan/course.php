<?php 
@include 'test.php'; 


if (isset($_POST['submit_student'])) {

    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $code = mysqli_real_escape_string($conn, $_POST['Code']);
    $year = mysqli_real_escape_string($conn, $_POST['Year']);
    $semester = mysqli_real_escape_string($conn, $_POST['Semester']);
    

    $sql = "INSERT INTO course (Name, Code, Year, Semester) VALUES (?, ?, ?, ?)";


    if ($stmt = $conn->prepare($sql)) {

        $stmt->bind_param("ssss", $name, $code, $year, $semester);


        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Course registered successfully!</p>";
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
    <title>Course Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f9;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 500px;
            text-align: left;
            margin: auto;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        button {
            padding: 6px 12px;
            border: none;
            cursor: pointer;
            background-color: #4CAF50;
            color: white;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <form method="POST" action="">
        <h2>Course Registration</h2>
        
        <label for="Name">Course Name</label>
        <input type="text" name="Name" required>

        <label for="Code">Course Code</label>
        <input type="text" name="Code" required>

        <label for="Year">Year</label>
        <input type="text" name="Year" required>

        <label for="Semester">Semester</label>
        <input type="text" name="Semester" required>

        <input type="submit" name="submit_student" value="Register">
    </form>

    <?php

    $sql = "SELECT * FROM course";
    $results = $conn->query($sql);

    if ($results->num_rows > 0) { 
        echo "<table>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Year</th>
                    <th>Semester</th>
                    <th width='90px'>Actions</th>
                </tr>";


        while($row = $results->fetch_assoc()){
            echo "<tr>
                    <td>" . htmlspecialchars($row['Name']) . "</td>
                    <td>" . htmlspecialchars($row['Code']) . "</td>
                    <td>" . htmlspecialchars($row['Year']) . "</td>
                    <td>" . htmlspecialchars($row['Semester']) . "</td>
                    <td>
                        <a href='edit.php?Code=" . urlencode($row['Code']) . "'><button>Edit</button></a>
                        <a href='delete.php?Code=" . urlencode($row['Code']) . "' onclick='return confirm(\"Are you sure?\");'><button>Delete</button></a>
                    </td>
                </tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align: center;'>No courses found.</p>";
    }
    ?>

</body>
</html>
