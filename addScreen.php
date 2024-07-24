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

$screenName = $_POST['screenName'];
$ip = $_POST['ip'];
$url = $_POST['url'];

$sql = "INSERT INTO screens (screen_name, location, screen_url) VALUES ('$screenName', '$ip', '$url')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
