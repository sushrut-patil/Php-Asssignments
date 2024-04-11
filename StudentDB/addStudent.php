<?php
session_start(); // Start the session

// Initialize session variables if they are not set
if (!isset($_SESSION['student_data'])) {
    $_SESSION['student_data'] = [
        'name' => '',
        'age' => '',
        'gpa' => '',
        'prn' => '',
        'department' => '',
        'rollno' => '',
        'password' => ''
    ];
}

include 'db_connection.php';

// Check if the connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    // Update session data with the submitted form values
    $_SESSION['student_data']['name'] = $_POST['name'];
    $_SESSION['student_data']['age'] = $_POST['age'];
    $_SESSION['student_data']['gpa'] = $_POST['gpa'];
    $_SESSION['student_data']['prn'] = $_POST['prn'];
    $_SESSION['student_data']['department'] = $_POST['department'];
    $_SESSION['student_data']['rollno'] = $_POST['rollno'];
    $_SESSION['student_data']['password'] = $_POST['password'];

    // Perform form validation
    $errors = [];

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

    // If there are no validation errors, proceed with database insertion
    if (empty($errors)) {
        $name = $_SESSION['student_data']['name'];
        $age = $_SESSION['student_data']['age'];
        $gpa = $_SESSION['student_data']['gpa'];
        $prn = $_SESSION['student_data']['prn'];
        $department = $_SESSION['student_data']['department'];
        $rollno = $_SESSION['student_data']['rollno'];
        $password = hash('sha256', $_SESSION['student_data']['password']);

        // Corrected SQL query
        $sql = "INSERT INTO students (name, age, GPA, PRN, Department, `Roll No`, Password) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind parameters with appropriate data types
            mysqli_stmt_bind_param($stmt, "sidisis", $name, $age, $gpa, $prn, $department, $rollno, $password);
            if (mysqli_stmt_execute($stmt)) {
                echo 'Record inserted successfully.';
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. " . mysqli_error($conn);
        }
    } else {
        // Display validation errors
        echo "<ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul>";
    }
}
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Add New Student</h1>
        <form action="addStudent.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $_SESSION['student_data']['name']; ?>"><br>

            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $_SESSION['student_data']['age']; ?>"><br>

            <label for="gpa">GPA:</label>
            <input type="number" step="0.01" id="gpa" name="gpa" value="<?php echo $_SESSION['student_data']['gpa']; ?>"><br>

            <label for="prn">PRN:</label>
            <input type="number" id="prn" name="prn" value="<?php echo $_SESSION['student_data']['prn']; ?>"><br>

            <label for="department">Department:</label>
            <input type="text" id="department" name="department" value="<?php echo $_SESSION['student_data']['department']; ?>"><br>

            <label for="rollno">Roll No:</label>
            <input type="number" id="rollno" name="rollno" value="<?php echo $_SESSION['student_data']['rollno']; ?>"><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo $_SESSION['student_data']['password']; ?>"><br>

            <input type="submit" value="Submit" name="submit">
        </form>
        <a class="back-btn" href="index.php">Back to Student Data</a>
    </div>
</body>

</html>
