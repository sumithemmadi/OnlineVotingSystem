<?php 
session_start();
if(isset($_SESSION['login_user'])){
    echo "hello sumith";
} else {
    header("Location: login.php");
}
?>