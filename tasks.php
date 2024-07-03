<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Add Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_task'])) {
    $task_name = $_POST['task_name'];
    $sql = "INSERT INTO tasks (user_id, task_name) VALUES ($user_id, '$task_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Task added successfully!";
    } else {
        echo "Error adding task: " . $conn->error;
    }
}

// Delete Task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_task'])) {
    $task_id = $_POST['task_id'];
    $sql = "DELETE FROM tasks WHERE id=$task_id AND user_id=$user_id";
    if ($conn->query($sql) === TRUE) {
        echo "Task deleted successfully!";
    } else {
        echo "Error deleting task: " . $conn->error;
    }
}

// Fetch Tasks
$sql = "SELECT * FROM tasks WHERE user_id=$user_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager - Tasks</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
        <form action="tasks.php" method="post">
            <input type="text" name="task_name" placeholder="Enter task" required>
            <button type="submit" name="add_task">Add Task</button>
        </form>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . $row['task_name'] . " <form action='tasks.php' method='post'><input type='hidden' name='task_id' value='" . $row['id'] . "'><button type='submit' name='delete_task'>Delete</button></form></li>";
                }
            } else {
                echo "<li>No tasks found.</li>";
            }
            ?>
        </ul>
        <a href="logout.php">Logout</a>
    </div>
</body>
</html>

<?php
$conn->close();
?>
