<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Matric: <input type="text" name="matric" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>

    <?php
    // Connect to DB
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "lab_5b";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $matric = $_POST['matric'];
        $password = $_POST['password'];

        // Retrieves record from the users table
        $sql = "SELECT * FROM users WHERE matric = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $matric);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password using password_verify()
            if (password_verify($password, $row['password'])) {
                // Successful login, store user data in session
                session_start();
                $_SESSION['user_id'] = $row['matric'];
                $_SESSION['user_role'] = $row['role'];

                // Redirect to page based on user role
                if ($row['role'] == 'lecturer') {
                    header('Location: lecturer_dashboard.php');
                } else {
                    header('Location: student_dashboard.php');
                }
                exit();
            } else {
                echo "Incorrect password.";
            }
        } else {
            echo "User not found.";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>