<?php
session_start();
if (empty($_SESSION['admin_user'])) {
    header("location: access-denied.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("dbconnect.php");
    $username = $_SESSION['admin_user'];
    $uname = $_POST['name'];

    $sql = mysqli_query($conn, "SELECT * FROM `candidates` WHERE username = '$uname'");
    if (mysqli_num_rows($sql)) {
        $ins = mysqli_query($conn, "DELETE FROM candidates WHERE username = '$uname'");
        mysqli_close($conn);
        echo "<h3>User ".$uname." is delete </h3>";
    } else {
        echo "<h3 style='color:blue'>No user found</h3>";
    }
}
?>