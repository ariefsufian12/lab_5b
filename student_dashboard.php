<!DOCTYPE html>
<html>
<head>
    <title>Student Dashboard</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Student Dashboard</h2>

    <table>
        <tr>
            <th>Matric</th>
            <th>Name</th>
            <th>Level</th>
        </tr>
        <?php
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        // Connect to DB
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "lab_5b";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT matric, name, role AS level FROM users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["matric"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["level"] . "</td>";
    
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No users found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
    
    <br>
    <a href="login.php">Logout</a>
    
</body>
</html>