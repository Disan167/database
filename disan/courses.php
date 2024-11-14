<?php 

@include 'test.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>course Registration</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f9; margin: 0;">
    <form method="POST" action="" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 90%; max-width: 500px; text-align: left; margin: auto;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">course Registration</h2>
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Name</label>
        <input type="text" name="Name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Code</label>
        <input type="text" name="Code" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Year</label>
        <input type="text" name="Year" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Semester</label>
        <input type="text" name="Semester" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <input type="submit" name="submit_student" value="Register" style="background-color: #4CAF50; color: #fff; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; margin-top: 20px;">
    </form>

    <?php
    if (isset($_POST['submit_course'])) {
        $sql = "INSERT INTO course (Name, Code, Year, Semester) 
            VALUES ('{$_POST['Name']}', '{$_POST['Code']}', '{$_POST['Year']}', {$_POST['Semester']})";
        echo $conn->query($sql) ? "<p style='text-align: center; color: green;'>course registered successfully!</p>" : "<p style='text-align: center; color: red;'>Error: " . $conn->error . "</p>";
    }
    ?>

    

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['Name'];
    $accessno = $_POST['Code'];
    $idNumber = $_POST['Year'];
    $accessno = $_POST['Semester'];

    // Use a prepared statement to insert data into the database securely
    $stmt = $conn->prepare("INSERT INTO course (Name, Code, Year, Semester) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $Name, $Code, $Year, $Semester);

    if ($stmt->execute()) {
        echo "<p>New course registered successfully.</p>";
    } else {
        echo "<p>Error: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch and display data from the student_registration table
$sql = "SELECT * FROM course";
$results = $conn->query($sql);
?>

<table border="1" width="100%">
    <tr>
        <th>Name</th>
        <th>Code</th>
        <th>Year</th>
        <th>Semester</th>
        <th width="90px">Actions</th>
    </tr>
    <?php
    if ($results->num_rows > 0) {       
        while($row = $results->fetch_assoc()){
            echo "<tr>
                    <td>" . htmlspecialchars($row['Name']) . "</td>
                    <td>" . htmlspecialchars($row['Code']) . "</td>
                    <td>" . htmlspecialchars($row['Year']) . "</td>
                    <td>" . htmlspecialchars($row['Semester']) . "</td>

                    <td>
                        <a href='edit.php?Year=" . urlencode($row['Year']) . "'><button>Edit</button></a>
                        <a href='delete.php?Year=" . urlencode($row['Year']) . "' onclick='return confirm(\"Are you sure?\");'><button>Delete</button></a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='10'>No results found</td></tr>";
    }
    ?>
</table>

</body>
</html>
