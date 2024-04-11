<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Data</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Student Data</h1>
    <div class="container">
        <a class="btn" href="addStudent.php">Add New Student</a>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Age</th>
                <th>GPA</th>
                <th>PRN</th>
                <th>Department</th>
                <th>Roll No</th>
                <th>Action</th>
            </tr>
            <?php
            include 'db_connection.php';

            $sql = "SELECT * FROM students";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['id']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['age']}</td>";
                    echo "<td>{$row['GPA']}</td>";
                    echo "<td>{$row['PRN']}</td>";
                    echo "<td>{$row['Department']}</td>";
                    echo "<td>{$row['Roll No']}</td>";
                    echo "<td><a class='btn' href='editStudent.php?id={$row['id']}'>Edit</a> <a class='btn btn-danger' href='deleteStudent.php?id={$row['id']}'>Delete</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No students found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
