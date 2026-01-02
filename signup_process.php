<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role     = $_POST['role']; // Student / Employee
    $idno     = $_POST['idno'];
    $address  = $_POST['address'];

    $sql = "INSERT INTO users (username, email, password, role, id_no, address)
            VALUES ('$username', '$email', '$password', '$role', '$idno', '$address')";

    if (mysqli_query($conn, $sql)) {
        header("Location: login.php?signup=success");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
