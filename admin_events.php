<?php
require('dbconnect.php');

session_start();
if (empty($_SESSION['admin_user'])) {
    header("location: access-denied.php");
}

$sql = "SELECT * FROM events";

$result = mysqli_query($conn, $sql);
$count = mysqli_num_rows($result);

if ($count == 0) {
    $no_event = true;
} else {
    $no_event = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">
    <title>ONLINE VOTING SYSTEM | Events</title>
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

        .regbox {
            color: #999;
            border-radius: 3px;
            margin-bottom: 15px;
            background: #f2f3f7;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
            padding: 30px;
            color: #5cb85c;
            text-decoration: none;
        }

        .partytext {
            font-size: 20px;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Full-width input fields */
        input[type=text],
        input[type=password] {
            border-radius: 6px;
            width: 60%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        /* Set a style for all buttons */
        button {
            background-color: #04AA6D;
            border-radius: 6px;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            opacity: 0.8;
        }

        /* Extra styles for the cancel button */
        .cancelbtn {
            border-radius: 6px;
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        /* Center the image and position the close button */
        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
            position: relative;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            padding: 16px;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto 15% auto;
            /* 5% from the top, 15% from the bottom and centered */
            border: 1px solid #888;
            width: 50%;
            /* Could be more or less, depending on screen size */
        }

        /* The Close Button (x) */
        .close {
            position: absolute;
            right: 25px;
            top: 0;
            color: #000;
            font-size: 35px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: red;
            cursor: pointer;
        }

        /* Add Zoom Animation */
        .animate {
            -webkit-animation: animatezoom 0.6s;
            animation: animatezoom 0.6s
        }

        @-webkit-keyframes animatezoom {
            from {
                -webkit-transform: scale(0)
            }

            to {
                -webkit-transform: scale(1)
            }
        }

        @keyframes animatezoom {
            from {
                transform: scale(0)
            }

            to {
                transform: scale(1)
            }
        }

        /* Change styles for span and cancel button on extra small screens */
        @media screen and (max-width: 300px) {
            span.psw {
                display: block;
                float: none;
            }

            .cancelbtn {
                width: 100%;
            }
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
                        <a class="nav-link" href="/home.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/voterlist.php">Voter List</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin_events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin_votes.php">Votes</a>
                    </li>
                </ul>
                <div class="list-inline pull-right">
                    <a id="logout-link" class="btn btn-raised btn-default waves-effect" href="/logout.php">Logout</a>&nbsp;&nbsp;
                </div>
            </div>
        </nav>
    </div>

    <div class="signup-form">
        <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Create Event</button>

        <div id="id01" class="modal">
            <form class="modal-content animate" action="/create_event.php" method="post">
                <div class="imgcontainer">
                    <h3>Create new event</h3>
                    <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                </div>
                <div class="container">
                    <div class="form-group">
                        <label for="event_name"><b>Event Name : </b></label>
                        <input type="text" placeholder="Enter Event Name" name="event_name" required>
                    </div>
                    <div class="form-group">
                        <label for="partyName1"><b>Party 1 :</b></label>
                        <input type="text" placeholder="Enter party name" name="partyName1" required>
                    </div>
                    <div class="form-group">
                        <label for="partyName1"><b>Party 2 :</b></label>
                        <input type="text" placeholder="Enter party name" name="partyName2" required>
                    </div>
                    <div class="form-group">
                        <label for="partyName3"><b>Party 3 :</b></label>
                        <input type="text" placeholder="Enter party name" name="partyName3" required>
                    </div>
                    <div class="form-group">
                        <label for="partyName4"><b>Party 4 :</b></label>
                        <input type="text" placeholder="Enter party name" name="partyName4" required>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <button type="submit">Submit</button>
                            </div>
                            <div class="col-xs-6">
                                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <script>
            var modal = document.getElementById('id01');
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        </script>
        <div class="regbox">
            <h2> Events </h2>
            <?php
            if ($no_event) {
                echo '<p style="color: red">No events </p>';
            } else {
                // echo "$count";
                $std_num = 0;
                while ($events = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    echo '
                    <div class="form-group">
                        <a class="btn btn-success btn-lg btn-block" href="/admin_votes.php?event_id=' . $events["event_id"] . '" >' . $events["eventName"] . '</a>
                    </div>';
                    $std_num++;
                }
            }
            ?>
        </div>
    </div>
</body>

</html>