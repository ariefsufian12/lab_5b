<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Matric: <input type="text" name="matric" required><br>
        Name: <input type="text" name="name" required><br>
        Password: <input type="password" name="password" required><br>
        Access Level: 
        <select name="role" placeholder="Please Select">
            <option value="student">Student</option>
            <option value="lecturer">Lecturer</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
    <br>
    <a href="login.php">Login</a></p>

    <?php
    // Connect to DB
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lab_5b";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matric = $_POST['matric'];
        $name = $_POST['name'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Password hashing
        $role = $_POST['role'];

        // Inserts new record into a database table named users
        $sql = "INSERT INTO users (matric, name, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $matric, $name, $password, $role);

        if ($stmt->execute()) {
            echo "New record created successfully! Now you can login...";
            header("refresh:2; url=login.php"); // Redirect after 2 seconds
            exit();

        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>