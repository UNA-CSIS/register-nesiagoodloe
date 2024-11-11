<?php
session_start();

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} else {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        Display games here...
        <?php
        // put your code here
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "softball";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM games order by id";
        $result = $conn->query($sql);

        echo "<table border='1'>
                <tr>
                <th>ID</th>
                <th>Opponent</th>
                <th>Site</th>
                <th>Result</th>
                </tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['opponent']) . "</td>";
                echo "<td>" . htmlspecialchars($row['site']) . "</td>";
                echo "<td>" . htmlspecialchars($row['result']) . "</td>";
                echo "</tr>";
            }
        
            echo "</table>";
            ?>
    </body>
</html>
