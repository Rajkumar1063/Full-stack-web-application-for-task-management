<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $username;
            header("Location: tasks.php");
            exit();
        } else {
            echo "<script>
                    alert('Invalid password! Please re-enter your password.');
                    window.location.href = 'index.html'; // Redirect to login page
                 </script>";
        }
    } else {
        echo "<script>
                alert('Invalid username! Please re-enter your username.');
                window.location.href = 'index.html'; // Redirect to login page
             </script>";
    }
}

$conn->close();
?>
