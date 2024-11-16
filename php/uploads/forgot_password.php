<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Include database connection file
include 'database_connection.php'; // Ensure this initializes $con correctly

// Process form submission if POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $current_password = mysqli_real_escape_string($con, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($con, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Retrieve user ID from session
    $user_id = $_SESSION['user_id'];

    // Validate new password and confirm password match
    if ($new_password !== $confirm_password) {
        echo "New password and confirmation do not match.";
    } else {
        // Fetch current password from the database
        $query = "SELECT password FROM registration WHERE id = '$user_id'";
        $result = mysqli_query($con, $query);
        $user = mysqli_fetch_assoc($result);

        // Check if current password matches the stored password (assuming password is hashed)
        if (password_verify($current_password, $user['password'])) {
            // Hash the new password before saving it
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_query = "UPDATE registration SET password = '$hashed_password' WHERE id = '$user_id'";

            if (mysqli_query($con, $update_query)) {
                echo "Password updated successfully.";
                echo "<script>
                window.location.href = 'http://localhost/php/Cara/';</script>";
            } else {
                echo "Error updating password: " . mysqli_error($con);
            }
        } else {
            echo "Current password is incorrect.";
        }
    }
}

// Close the database connection (optional)
mysqli_close($con);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #088178;
            font-size: 28px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 16px;
            color: #333;
        }

        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
            color: #333;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #088178;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #088178;
        }

        .success-message {
            background-color: #088178;
            color: white;
            padding: 12px;
            margin-top: 10px;
            border-radius: 5px;
        }

        .error-message {
            background-color: #f44336;
            color: white;
            padding: 12px;
            margin-top: 10px;
            border-radius: 5px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            color: #088178;
            font-size: 16px;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Change Your Password</h1>

        <!-- Password change form -->
        <form method="POST" action="">
            <label for="current_password">Current Password:</label>
            <input type="password" id="current_password" name="current_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Change Password</button>
        </form>

        <a href="http://localhost/php/Cara/">Logout</a>
    </div>

</body>

</html>
