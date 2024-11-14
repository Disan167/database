<?php
@include 'test.php'; 

if (isset($_POST['submit_department'])) {
    
    $name = mysqli_real_escape_string($conn, $_POST['Name']);
    $head = mysqli_real_escape_string($conn, $_POST['Head']);
    

    $sql = "INSERT INTO department (Name, Head) VALUES (?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        
        $stmt->bind_param("ss", $name, $head);
        
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
    <title>Department Registration</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f9; margin: 0;">
    <form method="POST" action="" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 90%; max-width: 500px; text-align: left; margin: auto;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Department Registration</h2>
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Name</label>
        <input type="text" name="Name" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Head</label>
        <input type="text" name="Head" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <input type="submit" name="submit_department" value="Register" style="background-color: #4CAF50; color: #fff; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; margin-top: 20px;">
    </form>

    <?php
    
    $sql = "SELECT * FROM department";
    $results = $conn->query($sql);
    ?>

    <table border="1" width="100%" style="margin-top: 40px;">
        <tr>
            <th>Name</th>
            <th>Head</th>
            <th width="90px">Actions</th>
        </tr>
        <?php
        
        if ($results->num_rows > 0) {       
            while($row = $results->fetch_assoc()){
                echo "<tr>
                        <td>" . htmlspecialchars($row['Name']) . "</td>
                        <td>" . htmlspecialchars($row['Head']) . "</td>
                        <td>
                            <a href='edit.php?Name=" . urlencode($row['Name']) . "'><button>Edit</button></a>
                            <a href='delete.php?Name=" . urlencode($row['Name']) . "' onclick='return confirm(\"Are you sure?\");'><button>Delete</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No departments found</td></tr>";
        }
        ?>
    </table>

</body>
</html>
