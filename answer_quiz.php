<?php
include("db.php");
include("header.php");
$quiz_id = $_GET['id'];
$result = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = {$quiz_id}");
$quiz = $result->fetch_array();
$answers = array();
?>
<?php

echo ("<h3 class='quiz-title' align='center'>" . $quiz["name"] . "</h3>");
echo ("<hr class='quiz-divider'>");
 $q_counter = 1;
$correct_answers = array();
?>

<div align="center">
    <form method="post">
<?php

$question_answers = $conn->query("SELECT * FROM `questions` WHERE `quiz_id` = {$quiz_id} ORDER BY `question_id`");
while ($question = $question_answers->fetch_array()) {
    array_push($correct_answers, $question["correct_answer"]);
}

if (isset($_POST["submit-answers"])) {
    $amount_questions = $question_answers->num_rows;
    $users_answers = array();
    for ($i = 0; $i < $amount_questions; $i++){
        $str = "radio" . ($i + 1);
        array_push($users_answers, $_POST["$str"]);
    }

    $score = 0;
    for ($j = 0; $j < count($users_answers); $j++) {
        $q_no = $j+1;
        if ($users_answers[$j] != $correct_answers[$j]) {

        }else{
            $score++;
        }
    }

    if ($score == 0)
        $percentage = 0;
    else
        $percentage = $score/$amount_questions;

    if ($percentage < 0.2) {
        $message = "Damn, were you TRYING to answer the wrong questions?!?";
    } elseif ($percentage < 0.5) {
        $message = "It would appear you need to brush up your knowledge, not a very good score son.";
    } elseif ($percentage < 0.8) {
        $message = "Not bad at all, you might be on to something here.";
    } elseif ($percentage < 1) {
        $message = "Wow, very good score, but not perfect. Why not try and get 100% next time?";
    } else{
        $message = "Your pretty insane if I do say so myself.  Congrats, you got full marks.";
    }

    echo "<span style='font-size: 15px;'><strong>YOU SCORED $score/$amount_questions</strong></span><br>";
    echo $message."<br><br>";
    
    for ($j = 0; $j < count($users_answers); $j++) {
        $q_no = $j+1;
        if ($users_answers[$j] != $correct_answers[$j]) {
            print "You got question $q_no wrong! <br>" ;
        }else{
            print "You get question $q_no correct! <br>";
        }
    }

    echo "<br><br>";
    echo "<a href='' >Try this quiz again</a><br>";
    echo "<a href='quizzes.php' />View other quizzes</a><br>";

    if (isset($_SESSION['user'])) {
        $answered = $conn->query("SELECT * FROM `quizzes_answered` WHERE `user_id` = {$_SESSION['user']['user_id']} AND `quiz_id` = {$quiz['quiz_id']}");
        if ($answered->num_rows == 0) {
            $conn->query("INSERT INTO `quizzes_answered` (`user_id`, `quiz_id`, `score`) VALUES ({$_SESSION['user']['user_id']}, {$quiz['quiz_id']}, $score)");
            $conn->query("UPDATE `quizzes` SET `score`=`score`+1, `times_completed`=`times_completed`+1 WHERE `quiz_id` = {$quiz['quiz_id']}");
        }
    }


    }
else
{

$questions = $conn->query("SELECT * FROM `questions` WHERE `quiz_id` = {$quiz_id}  ORDER BY `question_id`");
while ($question = $questions->fetch_array()) {

    echo("<p class='questions' align='center'>Question " . $q_counter . "</p>");
    echo("<hr class='quiz-divider'> <br>");
    print ("<p align='center'>" . $question["question_text"]) . "</p><br>";
    ?>

    <label>
        <input type="radio" name="radio<?php print $q_counter ?>" value="1" required>
        <?php print ($question["answer1_text"]); ?>
    </label>
    <br>
    <label>
        <input type="radio" name="radio<?php print $q_counter ?>" value="2">
        <?php print ($question["answer2_text"]); ?>
    </label>
    <br>
    <label>
        <input type="radio" name="radio<?php print $q_counter ?>" value="3">
        <?php print ($question["answer3_text"]); ?>
    </label>
    <br>
    <label>
        <input type="radio" name="radio<?php print $q_counter ?>" value="4">
        <?php print ($question["answer4_text"]); ?>
    </label>
    <br><br>
    <?php $q_counter++;
} ?>
        <br>
        <button class="btn btn-default" name="submit-answers">Submit Answers</button>
    </form>
</div>

<?php
}
?>

<?php
include("footer.php");
?>

