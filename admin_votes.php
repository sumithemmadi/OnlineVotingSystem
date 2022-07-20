<?php
require('dbconnect.php');

session_start();
if (empty($_SESSION['admin_user'])) {
  header("location: access-denied.php");
} else {
  $username = $_SESSION['admin_user'];
  // $sql = "SELECT * FROM `candidates` WHERE username = '$username'";
  // $candidate_result = mysqli_query($conn, $sql);
  // $candidate_rows = mysqli_fetch_array($candidate_result, MYSQLI_ASSOC);
  // $candidate_count = mysqli_num_rows($candidate_result);
  // if ($candidate_count == 0) {
  //   session_destroy();
  //   header("Location: /admin.php");
  // }
}

if (empty($_GET['event_id'])) {
  header("location: admin_events.php");
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

    .signup-form .x-form {
      color: #999;
      border-radius: 3px;
      margin-bottom: 15px;
      height: 640px;
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
      /* padding: 30px; */
      color: #5cb85c;
      text-decoration: none;
    }

    .partytext {
      font-size: 20px;
    }

    #form {
      display: none;
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
      color: black;
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }

    tr:nth-child(even) {
      background-color: #dddddd;
    }

    .auto-index td:first-child:before {
      counter-increment: Serial;
      content: counter(Serial);
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
    <?php
    if ($no_event) {
      echo '<div class="regbox"><p style="color: red">No event with id  ' . $event_id . '</p></div>';
    } else {
    ?>
      <script>
        $(document).ready(function() {
          $('#form').on('input change', function() {
            $('#update_btn').attr('disabled', false);
          });
        })

        function editEvent() {
          if (document.getElementById("form").style.display == "none") {
            document.getElementById("form").style.display = "block";
          } else {
            document.getElementById("form").style.display = "none";
          }
        }
      </script>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <div class="form-group">
        <div class="regbox">
          <div class="col-xs-6">
            <button type="submit" class="btn btn-success btn-lg btn-block" id="edit_event_btn" onclick="editEvent();">Edit Event</button>
          </div>

          <div class="col-xs-6">
            <form method="post">
              <button type="submit" class="btn btn-success btn-lg btn-block" name="deleteButton" id="deleteButton" onclick="document.location.href='/admin_events.php';">Delete Event</button>
            </form>
            <?php
            if (array_key_exists('deleteButton', $_POST)) {
              mysqli_query($conn, "DELETE FROM events WHERE event_id='$event_id'");
              header("Location: admin_events.php");
            } else {
              header("Location: access-denied.php");
            }
            ?>
          </div>
        </div>
      </div>
      <br><br><br>
      <form action="/update_event.php" class="x-form" id="form" method="post">
        <h2>VOTEING</h2>
        <div class="form-group">
          <input type="hidden" class="form-control" name="event_id" value="<?php echo $event_id; ?>" readonly>
        </div>
        <div class="form-group">
          Event Id<input type="text" class="form-control" name="event_name" value="<?php echo $events['eventName'] ?>">
        </div>
        <div class="form-group">
          Party Name1 <input type="text" class="form-control" name="partyName1" value="<?php echo $events['partyName1'] ?>">
        </div>
        <div class="form-group">
          Party Name2 <input type="text" class="form-control" name="partyName2" value="<?php echo $events['partyName2'] ?>">
        </div>
        <div class="form-group">
          Party Name3 <input type="text" class="form-control" name="partyName3" value="<?php echo $events['partyName3'] ?>">
        </div>
        <div class="form-group">
          Party Name4 <input type="text" class="form-control" name="partyName4" value="<?php echo $events['partyName4'] ?>">
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success btn-lg btn-block" id="update_btn" disabled>Update Now</button>
        </div>
      </form>
      <div class="regbox">
        <?php
        if ($no_event) {
          echo '<p style="color: red">No user found </p>';
        } else {
          $sql1 = "SELECT * FROM vote WHERE event_id='$event_id' AND username='$username'";

          $result1 = mysqli_query($conn, $sql1);
          $count1 = mysqli_num_rows($result1);
        ?>
          <table class="auto-index">
            <tr>
              <th>S No.</th>
              <th>Event Id</th>
              <th>Voter Id</th>
              <th>username</th>
              <th>vote party</th>
              <th>vote date</th>
            </tr>
          <?php

          $std_num = 0;
          $t_party_name1 = $t_party_name2 = $t_party_name3 = $t_party_name4 = 0;
          while ($candidates = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
            echo '
                    <tr>
                        <td></td>
                        <td>' . $candidates['event_id'] . ' </td>
                        <td>' . $candidates['voter_id'] . ' </td>
                        <td>' . $candidates['username'] . ' </td>
                        <td>' . $candidates['voteParty'] . ' </td>
                        <td>' . $candidates['VoteDate'] . ' </td>
                    </tr>';
            $std_num++;
          }
        }
          ?>
          </table>
      </div>
    <?php
      $n1 = $events['partyName1'];
      $sql2 = "SELECT * FROM vote WHERE event_id='$event_id' AND username='$username' AND votePArty = '$n1'";
      $result2 = mysqli_query($conn, $sql2);
      $count2 = mysqli_num_rows($result2);

      $n2 = $events['partyName2'];
      $sql3 = "SELECT * FROM vote WHERE event_id='$event_id' AND username='$username' AND votePArty = '$n2'";
      $result3 = mysqli_query($conn, $sql3);
      $count3 = mysqli_num_rows($result3);

      $n3 = $events['partyName3'];
      $sql4 = "SELECT * FROM vote WHERE event_id='$event_id' AND username='$username' AND votePArty = '$n3'";
      $result4 = mysqli_query($conn, $sql4);
      $count4 = mysqli_num_rows($result4);

      $n4 = $events['partyName4'];
      $sql5 = "SELECT * FROM vote WHERE event_id='$event_id' AND username='$username' AND votePArty = '$n4'";
      $result5 = mysqli_query($conn, $sql5);
      $count5 = mysqli_num_rows($result5);

      if ($count2 == 0 && $count3 == 0 && $count4 == 0 && $count5 == 0) {
        echo '<span>Winner will be announced after voting</span>';
      } else {
        if ($count2 > $count3 && $count2 > $count4 && $count2 > $count5) {
          $win = [$n1, $count2];
        } elseif ($count3 > $count2 && $count3 > $count4 && $count3 > $count5) {
          $win = [$n2, $count3];
        } elseif ($count4 > $count2 && $count4 > $count3 && $count4 > $count5) {
          $win = [$n3, $count4];
        } else {
          $win = [$n4, $count5];
        }
        echo '<span>Winner is ' . $win[0] . ' with ' . $win[1] . ' votes</span>';
      }
    }
    ?>

  </div>
</body>

</html>