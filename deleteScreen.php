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

// Get the JSON input
$input = json_decode(file_get_contents('php://input'), true);

$screenName = $conn->real_escape_string($input['screenName']);

// SQL to delete a record
$sql = "DELETE FROM screens WHERE screen_name = '$screenName'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
