<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "OneClick";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array('success' => false, 'message' => '');

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['id']) && isset($data['role'])) {
    $id = $data['id'];
    $role = $data['role'];

    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $role, $id);

    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['message'] = "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
