<?php

$servername = "localhost";
$username = "root";
$password = "99123456789";

$database = "OnlineVotingSystem";
$conn = mysqli_connect(
    $servername,
    $username,
    $password,
    $database
);



if ($conn) {
    $status = "success";
} else {
    die("Error" . mysqli_connect_error());
}
