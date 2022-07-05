<?php
require('dbconnect.php');

session_start();
if (empty($_SESSION['login_user'])) {
  header("location: access-denied.php");
} else {
  $username = $_SESSION['login_user'];
  $sql = "SELECT * FROM `candidates` WHERE username = '$username'";
  $candidate_result = mysqli_query($conn, $sql);
  $candidate_rows = mysqli_fetch_array($candidate_result, MYSQLI_ASSOC);
  $candidate_count = mysqli_num_rows($candidate_result);
  if ($candidate_count == 0) {
    session_destroy();
    header("Location: /login.php");
  }
}

if (empty($_GET['event_id'])) {
  header("location: events.php");
} else {
  $event_id = $_GET['event_id'];
  $sql = "SELECT * FROM events WHERE event_id = '$event_id'";

  $result = mysqli_query($conn, $sql);
  $events = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);

  if ($count == 0) {
    $no_event = true;
  } else {
    $no_event = false;
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
  <title>Online voting</title>
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
    <?php
    if ($no_event) {
      echo '<div class="regbox"><p style="color: red">No event with id  ' . $event_id . '</p></div>';
    } else {
      $sql = mysqli_query($conn, "SELECT * FROM vote where event_id='$event_id' and username='$username'");
      if (mysqli_num_rows($sql)) {
        echo '<div class="regbox"><p style="color: red">You have already marked your vote.</p></div>';
      } else {
    ?>
        <form action="/save_vote.php" method="post">
          <h2>VOTEING</h2>
          <h3 id="question" style="color: black;"><?php echo $events['eventName'] ?></h3>
          <div class="form-group">
            <div class="col-xs-6">
              <input type="hidden" class="form-control" name="event_id" value="<?php echo $event_id; ?>" readonly>
            </div>
            <div class="col-xs-6">
              <input type="hidden" class="form-control" name="voter_id" value="<?php echo $candidate_rows['voter_id']; ?>" readonly>
            </div>
          </div>
          <div class="form-group">
            <input type="radio" name="vote_value" value="<?php echo $events['partyName1'] ?>">
            <label class="partytext" for="<?php echo $events['partyName1'] ?>"><?php echo $events['partyName1'] ?></label>
            <br>
            <input type="radio" name="vote_value" value="<?php echo $events['partyName2'] ?>">
            <label class="partytext" for="<?php echo $events['partyName2'] ?>"><?php echo $events['partyName2'] ?></label>
            <br>
            <input type="radio" name="vote_value" value="<?php echo $events['partyName3'] ?>">
            <label class="partytext" for="<?php echo $events['partyName3'] ?>"><?php echo $events['partyName3'] ?></label>
            <br>
            <input type="radio" name="vote_value" value="<?php echo $events['partyName4'] ?>">
            <label class="partytext" for="<?php echo $events['partyName4'] ?>"><?php echo $events['partyName4'] ?></label>
            <br>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-success btn-lg btn-block">Vote Now</button>
          </div>
        </form>
    <?php
      }
    }
    ?>
  </div>
</body>

</html>