<?php

$showAlert = false;
$showError = false;
$exists = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'dbconnect.php';

    $firstname = $_POST["first_name"];
    $lastname = $_POST["last_name"];
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $cpassword = $_POST["confirm_password"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];

    $sql = "SELECT * FROM `candidates` WHERE username = '$username'";

    $result = mysqli_query($conn, $sql);

    $num = mysqli_num_rows($result);
    if ($num == 0) {
        if (($password == $cpassword) && $exists == false) {
            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );
            $sql = "INSERT INTO `candidates` ( `firstname`, `lastname` , `username`, `email` , `password`, `gender` , `dob` ) VALUES ('$firstname' , '$lastname', '$username', '$email' , '$hash', '$gender' , '$dob' )";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $showAlert = true;
            }
        } else {
            $showError = "Passwords do not match";
        }
    }
    if ($num > 0) {
        $exists = "Username already exist";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <title>Bootstrap Simple Registration Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.18.0/additional-methods.js"></script>
    <style>
        body {
            color: #fff;
            background: #63738a;
            font-family: 'Roboto', sans-serif;
        }

        .form-control {
            height: 40px;
            box-shadow: none;
            color: #969fa4;
        }

        .form-control:focus {
            border-color: #5cb85c;
        }

        .form-control,
        .btn {
            border-radius: 3px;
        }

        .signup-form {
            width: 400px;
            margin: 0 auto;
            padding: 30px 0;
        }

        .signup-form h2 {
            color: #636363;
            margin: 0 0 15px;
            position: relative;
            text-align: center;
        }

        .signup-form h2:before,
        .signup-form h2:after {
            content: "";
            height: 2px;
            width: 30%;
            background: #d4d4d4;
            position: absolute;
            top: 50%;
            z-index: 2;
        }

        .signup-form h2:before {
            left: 0;
        }

        .signup-form h2:after {
            right: 0;
        }

        .signup-form .hint-text {
            color: #999;
            margin-bottom: 30px;
            text-align: center;
        }

        .signup-form form {
            color: #999;
            border-radius: 3px;
            margin-bottom: 15px;
            background: #f2f3f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
        }

        .signup-form .form-group {
            margin-bottom: 20px;
        }

        .signup-form input[type="checkbox"] {
            margin-top: 3px;
        }

        .signup-form .btn {
            font-size: 16px;
            font-weight: bold;
            min-width: 140px;
            outline: none !important;
        }

        .signup-form .row div:first-child {
            padding-right: 10px;
        }

        .signup-form .row div:last-child {
            padding-left: 10px;
        }

        .signup-form a {
            color: #fff;
            text-decoration: underline;
        }

        .signup-form a:hover {
            text-decoration: none;
        }

        .signup-form form a {
            color: #5cb85c;
            text-decoration: none;
        }

        .signup-form form a:hover {
            text-decoration: underline;
        }
        .statusmsgerror {
            color: red ;
        }
    </style>
</head>

<body>
    <div style="background-color: white;">
        <nav class="navbar navbar-dark blue">
            <div class="container">
                <a class="navbar-brand" href="#">ONLINE VOTING SYSTEM</a>
                <ul class="nav navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/registration.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vote.php">Vote</a>
                    </li>
                </ul>
                <!-- <div class="list-inline pull-right">
                    <a id="logout-link" class="btn btn-raised btn-default waves-effect">Logout</a>&nbsp;&nbsp;
                </div> -->
            </div>
        </nav>
    </div>
    <div class="signup-form">
        <form action="/registration.php" method="post">
            <h2>Register</h2>
            <p class="hint-text">Create your account. Register as a new voter </p>

            <div class="form-group">
                <div class="row">
                    <div class="col-xs-6"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required"></div>
                    <div class="col-xs-6"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required"></div>
                </div>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="Username" required="required">
            </div>
            <div class="form-group">
                <input type="email" class="form-control" name="email" placeholder="Email" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required="required">
            </div>
            <div class="form-group">
                <label for="male">Male</label>
                <input type="radio" name="gender" id="male" value="male" checked>
                <label for="female">Female</label>
                <input type="radio" name="gender" id="female" value="female">
            </div>
            <div class="form-group">
                <input type="date" placeholder="Select your age" id="age" name="dob">
            </div>
            <!-- <div class="form-group">
                <label class="checkbox-inline"><input type="checkbox" required="required"> I accept the <a href="#">Terms of Use</a> &amp; <a href="#">Privacy Policy</a></label>
            </div> -->
            <div class="form-group">
                <button type="submit" class="btn btn-success btn-lg btn-block">Register Now</button>
            </div>
        </form>
        <div class="text-center">Already have an account? <a href="/login.php">Sign in</a></div>
    </div>
</body>

</html>