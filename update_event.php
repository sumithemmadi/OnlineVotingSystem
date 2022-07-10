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
    $event_id  = $_POST['event_id'];
    $eventName  = $_POST['event_name'];
    $partyName1 = $_POST['partyName1'];
    $partyName2 = $_POST['partyName2'];
    $partyName3 = $_POST['partyName3'];
    $partyName4 = $_POST['partyName4'];
    print_r( $eventName );

    echo $partyName1;
    mysqli_query($conn, "UPDATE  `events` SET admin_id = '$username' , eventName = '$eventName' , partyName1 = '$partyName1', partyName2 = '$partyName2', partyName3 = '$partyName3', partyName4 = '$partyName4' WHERE  event_id ='$event_id'");
    mysqli_close($conn);
    header("Location: admin_votes.php?event_id=" . $event_id);
}
