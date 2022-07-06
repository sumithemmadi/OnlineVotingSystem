<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();
if (empty($_SESSION['admin_user'])) {
    header("location: access-denied.php");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("dbconnect.php");
    $username = $_SESSION['admin_user'];
    $eventName  = $_POST['event_name'];
    $partyName1 = $_POST['partyName1'];
    $partyName2 = $_POST['partyName2'];
    $partyName3 = $_POST['partyName3'];
    $partyName4 = $_POST['partyName4'];
    mysqli_query($conn, "INSERT INTO `events` (`eventName`, `partyName1`, `partyName2`, `partyName3`, `partyName4` ) VALUES ( '$eventName' , '$partyName1', '$partyName2', '$partyName3', '$partyName4' )");
    mysqli_close($conn);
    header("Location: admin_events.php");
}
