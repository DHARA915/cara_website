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

// Handle form submission for login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL statement to check if the email exists in the registration table
    $sql = "SELECT id, username, password FROM registration WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if email exists in the registration table
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $username, $hashedPassword);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashedPassword)) {
            // Set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $username;

            // Redirect to the dashboard
            echo "<script>
                    alert('Login successful! Redirecting to your dashboard.');
                    window.location.href = 'http://localhost/php/Cara/';
                  </script>";
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.');
            window.location.href = 'http://localhost/php/Cara/';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Please register.');</script>";
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>
