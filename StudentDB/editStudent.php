<?php
include 'db_connection.php';

$id = $_GET['id'];
$sql = "SELECT * FROM students WHERE id=$id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$errors = []; // Initialize an array to store validation errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form fields
    if (empty($_POST['name'])) {
        $errors[] = "Name is required.";
    }
    if (empty($_POST['age'])) {
        $errors[] = "Age is required.";
    } elseif (!is_numeric($_POST['age'])) {
        $errors[] = "Age must be a number.";
    }
    if (empty($_POST['gpa'])) {
        $errors[] = "GPA is required.";
    } elseif (!is_numeric($_POST['gpa'])) {
        $errors[] = "GPA must be a number.";
    }
    if (empty($_POST['prn'])) {
        $errors[] = "PRN is required.";
    } elseif (!is_numeric($_POST['prn'])) {
        $errors[] = "PRN must be a number.";
    }
    if (empty($_POST['department'])) {
        $errors[] = "Department is required.";
    }
    if (empty($_POST['rollno'])) {
        $errors[] = "Roll No is required.";
    } elseif (!is_numeric($_POST['rollno'])) {
        $errors[] = "Roll No must be a number.";
    }
    if (empty($_POST['password'])) {
        $errors[] = "Password is required.";
    }

    if (empty($errors)) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $age = $_POST['age'];
        $gpa = $_POST['gpa'];
        $prn = $_POST['prn'];
        $department = $_POST['department'];
        $rollno = $_POST['rollno'];
        $password = hash('sha256', $_POST['password']);

        $sql = "UPDATE students SET name = ?, age = ?  ,GPA = ?, PRN = ?, Department = ?, `Roll No` = ?, Password = ? WHERE id = ?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "sidisisi", $name, $age,$gpa, $prn, $department, $rollno, $password, $id);

            if (mysqli_stmt_execute($stmt)) {
                echo '<script>alert("Records updated successfully.");</script>';
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }

        // Fetch the updated record
        $sql = "SELECT * FROM students WHERE id=$id";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Edit Student</h1>
    <?php if (!empty($errors)) : ?>
        <div class="errors">
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>
        <label for="age">Age:</label>
        <input type="text" id="age" name="age" value="<?php echo $row['age']; ?>"><br>
        <label for="gpa">GPA:</label>
        <input type="text" id="gpa" name="gpa" value="<?php echo $row['GPA']; ?>"><br>
        <label for="prn">PRN:</label>
        <input type="text" id="prn" name="prn" value="<?php echo $row['PRN']; ?>"><br>
        <label for="department">Department:</label>
        <input type="text" id="department" name="department" value="<?php echo $row['Department']; ?>"><br>
        <label for="rollno">Roll No:</label>
        <input type="text" id="rollno" name="rollno" value="<?php echo $row['Roll No']; ?>"><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $row['Password']; ?>"><br>
        <input type="submit" value="Submit" name="submit">
    </form>
    <a class="back-btn" href="index.php">Back to Student Data</a>
</div>
</body>
</html>
