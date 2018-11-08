<?php include("db.php"); ?>
<?php include("header.php"); ?>

<?php
$logged_in = false;
$user = "";
if (isset($_SESSION['user'])){
    $user = $_SESSION['user'];
    $logged_in = true;
}
$quiz_query = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = {$_GET['id']}");
$quiz = $quiz_query->fetch_array();

$questions_query = $conn->query("SELECT * FROM `questions` WHERE `quiz_id` = {$_GET['id']}");
$questions_list = $questions_query->fetch_array();
echo ("<br><h3 class='quiz-title' align='center'>" . $quiz["name"] . "</h3>");
echo "<br>";
echo ("<p class='questions' align='center'>Questions: " . $questions_query->num_rows . " </p>");
echo ("<hr class='quiz-divider'>");
echo "<br>";
echo ("<div class='quiz-prev'>");
echo("<p align='center'>" . $quiz["description"] . "</p><br>");
echo ("<div align='center'>");
echo ("<a href='answer_quiz.php?id={$quiz['quiz_id']}' class=\"btn btn-outline-success\">Start</a>");
if ($logged_in) {
    if($quiz["user_id"] == $user["user_id"]){
        print "<br><br>";
        echo ("<a href='edit_quiz.php?id={$quiz['quiz_id']}' class=\"btn btn-outline-danger\">Edit info     </a>");
        echo ("<a href='delete_quiz.php?id={$quiz['quiz_id']}' class=\"btn btn-outline-warning\">Delete</a>");
    }
}

echo("</div></div>");
?>

<?php include("footer.php");?>