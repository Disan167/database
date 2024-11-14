<?php 
@include 'test.php'; 

if (isset($_POST['submit_mark'])) {

    $course = mysqli_real_escape_string($conn, $_POST['Course']);
    $mark = mysqli_real_escape_string($conn, $_POST['Mark']);
    $grade = mysqli_real_escape_string($conn, $_POST['Grade']);
    $comment = mysqli_real_escape_string($conn, $_POST['Comment']);
    
    $sql = "INSERT INTO mark (Course, Mark, Grade, Comment) VALUES (?, ?, ?, ?)";
    

    if ($stmt = $conn->prepare($sql)) {
       
        $stmt->bind_param("ssss", $course, $mark, $grade, $comment);

        if ($stmt->execute()) {
            echo "<p style='text-align: center; color: green;'>Marks registered successfully!</p>";
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
    <title>Mark Registration</title>
</head>
<body style="font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f4f4f9; margin: 0;">
    <form method="POST" action="" style="background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); width: 90%; max-width: 500px; text-align: left; margin: auto;">
        <h2 style="text-align: center; color: #333; margin-bottom: 20px;">Mark Registration</h2>
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Course</label>
        <input type="text" name="Course" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Mark</label>
        <input type="text" name="Mark" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Grade</label>
        <input type="text" name="Grade" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <label style="display: block; margin-top: 10px; font-weight: bold; color: #555;">Comment</label>
        <input type="text" name="Comment" required style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ddd; border-radius: 4px;">
        
        <input type="submit" name="submit_mark" value="Register" style="background-color: #4CAF50; color: #fff; border: none; padding: 12px; width: 100%; border-radius: 4px; cursor: pointer; margin-top: 20px;">
    </form>

    <?php

    $sql = "SELECT * FROM mark";
    $results = $conn->query($sql);
    ?>

    <table border="1" width="100%" style="margin-top: 20px;">
        <tr>
            <th>Course</th>
            <th>Mark</th>
            <th>Grade</th>
            <th>Comment</th>
            <th width="90px">Actions</th>
        </tr>
        <?php

        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['Course']) . "</td>
                        <td>" . htmlspecialchars($row['Mark']) . "</td>
                        <td>" . htmlspecialchars($row['Grade']) . "</td>
                        <td>" . htmlspecialchars($row['Comment']) . "</td>
                        <td>
                            <a href='edit.php?Grade=" . urlencode($row['Grade']) . "'><button>Edit</button></a>
                            <a href='delete.php?Grade=" . urlencode($row['Grade']) . "' onclick='return confirm(\"Are you sure?\");'><button>Delete</button></a>
                        </td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No results found</td></tr>";
        }
        ?>
    </table>

</body>
</html>
