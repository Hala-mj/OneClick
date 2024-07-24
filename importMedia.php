<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "oneclick";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['mediaFiles'])) {
    $files = $_FILES['mediaFiles'];
    $uploadDirectory = 'uploads/';

    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }

    foreach ($files['tmp_name'] as $key => $tmpName) {
        $fileName = basename($files['name'][$key]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $filePath = $uploadDirectory . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            $stmt = $conn->prepare("INSERT INTO media (media_name, type, path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fileName, $fileType, $filePath);

            if ($stmt->execute()) {
                $response['success'] = true;
            } else {
                $response['success'] = false;
                $response['error'] = "Error inserting into database: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $response['success'] = false;
            $response['error'] = "Error moving uploaded file: " . $tmpName . " to " . $filePath;
        }
    }
} else {
    $response['success'] = false;
    $response['error'] = "No files uploaded or invalid request method";
}

$conn->close();
echo json_encode($response);
?>
