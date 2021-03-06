<?php
session_start();
if (isset($_SESSION['login_user'])) {
    include("dbconnect.php");
    $username = $_SESSION['login_user'];
    $sql = "SELECT * FROM candidates WHERE username = '$username'";

    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);

    if ($count == 0) {
        session_destroy();
        header("location: login.php");
    } else {
        $age  = (date('Y') - date('Y', strtotime($row['dob'])));
    }
} else {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <title>ONLINE VOTING SYSTEM | DASHBOARD</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/bootstrap-theme.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>

    <script src="/js/jquery.validate.js"></script>
    <script src="/js/additional-methods.js"></script>
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
            color: red;
        }

        .tablebox {
            color: #999;
            border-radius: 3px;
            margin-bottom: 15px;
            background: #f2f3f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            color: black;
            text-decoration: none;
        }

        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
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
                        <a class="nav-link" href="/dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/vote.php">Vote</a>
                    </li>
                </ul>
                <div class="list-inline pull-right">
                    <a id="logout-link" class="btn btn-raised btn-default waves-effect" href="/logout.php">Logout</a>&nbsp;&nbsp;
                </div>
            </div>
        </nav>
    </div>
    <div class="signup-form">
        <div class="tablebox">
            <table>
                <tr>
                    <th><?php echo $username ?></th>
                    <!-- <th>Contact</th> -->
                </tr>
                <tr>
                    <td>Name</td>
                    <td><?php echo  $row['firstname'] . " " . $row['lastname'] ?></td>
                </tr>
                <tr>
                    <td>Voter ID</td>
                    <td><?php echo $row['voter_id'] ?></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td><?php echo $row['email'] ?></td>
                </tr>
                <tr>
                    <td>Gender</td>
                    <td><?php echo $row['gender'] ?></td>

                </tr>
                <tr>
                    <td>DOB</td>
                    <td><?php echo $row['dob'] ?></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><?php echo $age . " Years"  ?></td>
                </tr>
                <tr>
                    <td>Phone Number</td>
                    <td>non</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>