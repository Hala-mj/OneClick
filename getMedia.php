<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oneclick";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT media_name FROM media";
$result = $conn->query($sql);

$mediaList = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mediaList[] = $row;
    }
}

$conn->close();
echo json_encode($mediaList);
?>
