<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Get the user details from the session
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Display the user's courses if they are a student
if ($role == 'student') {
    $stmt = $conn->prepare("SELECT * FROM courses WHERE id IN (SELECT course_id FROM enrollments WHERE user_id = ?)");
    $stmt->execute([$user_id]);
    $courses = $stmt->fetchAll();
    
    // Display a welcome message
    echo "<h1>Welcome to your dashboard, " . $_SESSION['user_id'] . "!</h1>";
    
    // Display the courses the user is enrolled in
    echo "<h3>Your Courses:</h3>";
    echo "<ul>";
    foreach ($courses as $course) {
        echo "<li>{$course['title']}</li>";
    }
    echo "</ul>";
}

?>

<!-- Log Out Button -->
<form action="logout.php" method="POST">
    <button type="submit">Log Out</button>
</form>
