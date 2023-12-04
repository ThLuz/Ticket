<?php
include 'config.php';

function createTask($title, $description) {
    global $conn;
    $sql = "INSERT INTO tasks (title, description) VALUES ('$title', '$description')";
    $conn->query($sql);
}

function readTasks() {
    global $conn;
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);
    $tasks = [];
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
    return $tasks;
}

function updateTask($id, $title, $description) {
    global $conn;
    $sql = "UPDATE tasks SET title='$title', description='$description' WHERE id=$id";
    $conn->query($sql);
}

function deleteTask($id) {
    global $conn;
    $sql = "DELETE FROM tasks WHERE id=$id";
    $conn->query($sql);
}
?>
