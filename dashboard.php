<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'db.php';

$sql = "SELECT * FROM posts WHERE author_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <div class="header">
            Welcome to Your Dashboard
        </div>

        <div class="navbar">
            <a href="#">Home</a>
            <a href="#">Profile</a>
            <a href="#">Settings</a>
            <a href="logout.php">Logout</a>
        </div>

        <div class="main-content">
            <h2>Dashboard Overview</h2>

            <a href="create.php" class="btn-create-post">Create Post</a>

            <h3>Your Posts:</h3>
            <?php if ($result->num_rows > 0): ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <a href="view_post.php?id=<?= $row['id']; ?>" class="post-title">
                                <?= htmlspecialchars($row['title']); ?>
                            </a>
                            <p><?= substr(htmlspecialchars($row['body']), 0, 100); ?>...</p>
                            <p><small>Created on: <?= $row['created_at']; ?></small></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>You have no posts yet. Create a post to get started!</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>