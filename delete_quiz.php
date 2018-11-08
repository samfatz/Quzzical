<?php include("db.php"); ?>
<?php include("header.php"); ?>


<?php
$delete_query = $conn->query( "DELETE FROM `quizzes` WHERE `quiz_id` = {$_GET['id']}");
print "<strong>Deleted quiz!</strong><br>";
print "Redirecting...";
header('Refresh: 3; URL=quizzes.php');
?>



<?php include("footer.php");?>
