<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();
if (empty($_SESSION['admin_user'])) {
    header("location: access-denied.php");
    exit();
} 

if($_SERVER["REQUEST_METHOD"] == "GET") {
    include("dbconnect.php");
    $username = $_SESSION['admin_user'];
    $event_id = $_GET['event_id'];

    $sql = mysqli_query($conn, "SELECT * FROM events WHERE event_id='$event_id'");
    if (mysqli_num_rows($sql)) {
        $ins = mysqli_query($conn, "DELETE FROM events WHERE event_id='$event_id'");
        mysqli_close($conn);
        echo "<h3>Event Deleted</h3>";
    } else {
        echo "<h3 style='color:green'>There is no such event</h3>";
    }
}
?>