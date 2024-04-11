<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
</head>

<body>
    <h1>Delete Student</h1>
    <?php
    include 'db_connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "DELETE FROM students WHERE id = ?";
        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "i", $id);

            if (mysqli_stmt_execute($stmt)) {
                echo "Records deleted successfully.";
            } else {
                echo "ERROR: Could not execute query: $sql. \n" . mysqli_error($conn);
            }
        } else {
            echo "ERROR: Could not prepare query: $sql. \n" . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
    ?>
    <a class="back-btn" href="index.php">Back to Student Data</a>
</body>

</html>