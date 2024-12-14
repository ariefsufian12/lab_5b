<?php
// Connect to DB
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "lab_5b";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $matric = $_GET['matric'];

    $sql = "SELECT * FROM users WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $matric);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <h2>Update User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="old_matric" value="<?php echo $row['matric']; ?>">
            Matric: <input type="text" name="new_matric" value="<?php echo $row['matric']; ?>"><br>
            Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
            Access Level: <input type="text" name="role" value="<?php echo $row['role']; ?>"><br>
            <button type="submit">Update</button>
            <a href="admin_dashboard.php">Cancel</a>
        </form>
<?php
    } else {
        echo "User not found.";
    }

    $stmt->close();
    $conn->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $old_matric = $_POST['old_matric'];
    $new_matric = $_POST['new_matric'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    // Validate new matric number (optional but recommended)
    // You might want to check if the new matric number is unique, valid format, etc.

    $sql = "UPDATE users SET matric = ?, name = ?, role = ? WHERE matric = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $new_matric, $name, $role, $old_matric);

    if ($stmt->execute()) {
        echo "User updated successfully! Redirecting to dashboard...";
        header("refresh:2; url=admin_dashboard.php"); // Redirect after 2 seconds
        exit();
    } else {
        echo "Error updating user: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>