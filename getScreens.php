<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oneclick";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM screens";
$result = $conn->query($sql);

$screens = array();
while($row = $result->fetch_assoc()) {
    $screens[] = $row;
}

echo json_encode($screens);

$conn->close();
?>
