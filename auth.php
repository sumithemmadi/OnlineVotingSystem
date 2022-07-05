<?php      
    include('dbconnect.php');  
    $username = $_POST['username'];  
    $password = $_POST['password'];  
    $hash = password_hash(
        $password,
        PASSWORD_DEFAULT
    ); 
      
    $sql = "select * from login where username = '$username' and password = '$hash'"; 
    $result = mysqli_query($con, $sql);  
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);  
    $count = mysqli_num_rows($result);  

    if($count == 1){  
        echo "<h1><center> Login successful </center></h1>";  
    }  
    else{  
        echo "<h1> Login failed. Invalid username or password.</h1>";  
    }     
?>  
