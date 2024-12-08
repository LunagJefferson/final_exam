<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'db.php';

    $title = $_POST['title'];
    $body = $_POST['body'];

    if (empty($title) || empty($body)) {
        echo "Please fill in all fields.";
        exit;
    }

    $sql = "INSERT INTO posts (title, body, author_id, created_at) VALUES (?, ?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $_SESSION['user_id'], $title, $body);

    if ($stmt->execute()) {
        echo "Post created successfully!";
        header("Location: dashboard.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" body="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <h2>Create a New Post</h2>
        <form action="create.php" method="POST">
            <label for="title">Post Title</label>
            <input type="text" name="title" id="title" required>

            <label for="body">Post Body</label>
            <textarea name="body" id="body" rows="4" required></textarea>

            <button type="submit" class="btn-create-post">Create Post</button>
        </form>
    </div>
</body>
</html>