<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if username already exists
    $sql_check = "SELECT * FROM users WHERE username='$username'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        echo "<script>
                alert('Username already exists! Please choose a different username.');
                window.location.href = 'register.html'; // Redirect to register page
             </script>";
        exit();
    }

    // Username is unique, proceed with registration
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql_insert = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
        // Redirect to login page after successful registration
        echo "<script>window.location.href = 'index.html';</script>";
        exit();
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

$conn->close();
?>
