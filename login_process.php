<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require 'db.php';

// Check if form is submitted
if(isset($_POST['login'])) {

    // Get form data safely
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role']; // 'Student' or 'Employee'

    // Check for empty fields
    if(empty($email) || empty($password) || empty($role)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login.php");
        exit;
    }

    // Query user by email and role
    $sql = "SELECT * FROM users WHERE email='$email' AND role='$role'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $user['password'])) {

            // Login success, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to dashboard
            if($role == 'Student') {
                header("Location: student_dashboard.php");
            } else {
                header("Location: employee_dashboard.php");
            }
            exit;

        } else {
            $_SESSION['error'] = "Incorrect password.";
            header("Location: Login.php");
            exit;
        }

    } else {
        $_SESSION['error'] = "No user found with this email and role.";
        header("Location: Login.php");
        exit;
    }

} else {
    // Form not submitted properly
    header("Location: login.php");
    exit;
}
?>
