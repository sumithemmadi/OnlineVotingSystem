<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
require('connection.php');
 $vote = $_REQUEST['vote'];
  $user_id=$_REQUEST['user_id'];
   $position=$_REQUEST['position'];

$sql=mysqli_query($con, "SELECT position,voter_id FROM tblvotes where position='$position' and voter_id='$user_id'");

if(mysqli_num_rows($sql))
{
    echo "<h3>You have already done your for this Position</h3>";
  //return "1";
 /* echo "<script>alert('already vote')</script>";*/ 
}
else
{
    //insert data and check position
    $ins=mysqli_query($con,"INSERT INTO tblvotes (voter_id, position, candidateName) VALUES ('$user_id', '$position', '$vote')");
    mysqli_query($con, "UPDATE tbCandidates SET candidate_cvotes=candidate_cvotes+1 WHERE candidate_name='$vote'");
    mysqli_close($con);
 
echo "<h3 style='color:blue'>Congrates You have submitted your vote for canditate ".$vote."</h3>";

}

?> 