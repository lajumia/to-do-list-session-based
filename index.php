<?php
session_start();

// Initialize tasks array if not set
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Add task
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
    $task = trim($_POST['task']);
    if (!empty($task)) {
        $_SESSION['tasks'][] = $task;
    }
    // Redirect to prevent form resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

// Delete task via GET
if (isset($_GET['delete'])) {
    $index = $_GET['delete'];
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']);
    // Redirect to avoid duplicate delete on refresh or conflict with form submission
    header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>To-Do List (Session)</title>
    <style>
        body { font-family: Arial; background: #f0f0f0; padding: 20px; }
        form, ul { background: #fff; padding: 15px; border-radius: 5px; width: 300px; margin-bottom: 10px; }
        li { margin: 8px 0; }
        button { margin-left: 10px; }
        input[type="text"] {
        padding: 8px;
        border-radius: 22px;
        border: 1px solid gray;
        margin-right: 10px;
        }

        input[type="submit"] {
            padding: 9px 20px;
            border-radius: 22px;
            border: 1px;
            cursor: pointer;
        }

        form {
            margin: auto;
        }

        h2 {
            text-align: center;
        }
        ul {
            margin: auto;
        }

        li {
            list-style: none;
            background: #ebe9e9;
            padding: 0px 10px;
            border-radius: 5px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        button {
            padding: 8px;
            border: none;
            cursor: pointer;
        }


    </style>
</head>
<body>

<h2>📝 To-Do List</h2>

<form method="post">
    <input type="text" name="task" placeholder="Enter new task" required />
    <input type="submit" name="add" value="Add Task" />
</form>
<ul>
    <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
        <li>
            <p><?php echo htmlspecialchars($task); ?></p>
            <a href="?delete=<?= $index ?>"><button>❌</button></a>
        </li>
    <?php endforeach; ?>
</ul>


</body>
</html>
