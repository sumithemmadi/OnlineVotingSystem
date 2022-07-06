<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);

session_start();
if (empty($_SESSION['login_user'])) {
    header("location: access-denied.php");
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("dbconnect.php");
    $username = $_SESSION['login_user'];
    $event_id = $_POST['event_id'];
    $voter_id = $_POST['voter_id'];
    $voteParty = $_POST['vote_value'];
    $VoteDate = date('m/d/Y h:i:s a', time());

    $sql = mysqli_query($conn, "SELECT * FROM vote where event_id='$event_id' and username='$username'");
    if (mysqli_num_rows($sql)) {
        echo "<h3>You have already marked your vote.</h3>";
    } else {
        $ins = mysqli_query($conn, "INSERT INTO vote (event_id, voter_id, username, voteParty, VoteDate ) VALUES ('$event_id', '$voter_id', '$username', '$voteParty', '$VoteDate')");
        mysqli_close($conn);
        echo "<h3 style='color:green'>Congrates You have submitted your vote for " . $voteParty . "</h3>";
    }
}
?>