<?php
// Start session
session_start();

// Database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "Cara";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the registration table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone VARCHAR(15) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    document_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql);

// Create the users table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    FOREIGN KEY (registration_id) REFERENCES registration(id) ON DELETE CASCADE
)";
$conn->query($sql);

// Handle form submission for registration
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // File upload handling
    $document = $_FILES['document'];
    $uploadDir = './uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $documentPath = $uploadDir . basename($document['name']);

    if (move_uploaded_file($document['tmp_name'], $documentPath)) {
        // Insert into registration table
        $sql = "INSERT INTO registration (full_name, gender, email, phone, username, password, document_path) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $full_name, $gender, $email, $phone, $username, $password, $documentPath);

        if ($stmt->execute()) {
            $registration_id = $stmt->insert_id;

            // Insert into users table with registration_id
            $sql = "INSERT INTO users (registration_id, email, password) VALUES (?, ?, ?)";
            $user_stmt = $conn->prepare($sql);
            $user_stmt->bind_param("iss", $registration_id, $email, $password);

            if ($user_stmt->execute()) {
                echo "<script>
                        alert('Registration successful! You can now login.');
                        window.location.href = 'http://localhost/php/Cara/';
                      </script>";
                exit();
            } else {
                echo "Error: " . $user_stmt->error;
            }
            $user_stmt->close();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Error uploading document.";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
