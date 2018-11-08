<?php
include("db.php");
include("header.php");



$error_messages1 = []; // error messages for first form
$error_messages2 = []; // error messages for adding questions form

//function boolean checkUpload()
?>
<?php


// Initial form that shows when user wants to create a quiz.
function quiz_form() {
    ?>
    <!--suppress Annotator -->
    <form id="create-quiz" method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quizName"><strong>Quiz Name</strong></label>
                <input type="text" class="form-control" id="quizName" name="quiz_name" value="<?php if (isset($_POST['continue_submit'])) print $_POST['quiz_name']; ?>">
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quizDescription"><strong>Quiz Description</strong></label>
                <textarea class="form-control" rows="2" id="quizDescription" name="quiz_description"><?php if (isset($_POST['continue_submit'])) print $_POST['quiz_description']; ?></textarea>
            </div>
        </div>
        <label for="quizCategory"><strong>Quiz Category</strong></label>
        <br>
        <div class="form-row">
            <div class="form-group col-md-6">
                <select class="form-control" name="category">
                    <option value="1">General Knowledge</option>
                    <option value="5">Geography & Places</option>
                    <option value="3">Tv and Movies</option>
                    <option value="4">Music</option>
                    <option value="2">Science</option>
                </select>
            </div>
        </div>
        <input type="submit" id="cont" name="continue_submit" class="btn btn-outline-danger" value="Continue">
    </form>
    <?php
}

// Form that shows after basic quiz details have been accepted, and questions need to be added.
function questions_form($quiz_id) {
    global $conn;

    $quiz_query = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = ".(int) $quiz_id);
    $quiz = $quiz_query->fetch_assoc();

    print "You can add as many questions to <strong>{$quiz['name']}</strong> as you like!<br><br>";
    ?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {


            function updateAnswers(i) {
                $("#correct_answer" + i).empty();
                $("#correct_answer" + i).append($('<option></option>').attr("value", "option value").text($('#answer1').val()));
                $("#correct_answer" + i).append($('<option></option>').attr("value", "option value").text($('#answer2').val()));
                $("#correct_answer" + i).append($('<option></option>').attr("value", "option value").text($('#answer3').val()));
                $("#correct_answer" + i).append($('<option></option>').attr("value", "option value").text($('#answer4').val()));
            }

            $('#answer1_1').on('input', function (e) {
                updateAnswers(1);
            });
            $('#answer2').on('input', function (e) {
                updateAnswers(1);
            });
            $('#answer3').on('input', function (e) {
                updateAnswers(1);
            });
            $('#answer4').on('input', function (e) {
                updateAnswers(1);
            });

            var amount_questions = 2; // start at 2 since first questions is there by default.
            $("#addQuestion").click(function() {
                $("#questions_zone").append('<label for="question"><strong>Question #' + amount_questions + ': </strong></label><br>');
                $("#questions_zone").append('<input type="text" class="form-control" name="question[]" required="required">');
                $("#questions_zone").append('<label>Answer 1</label> <input type="radio" name="question'+amount_questions+'_answer" value="1"  required="required" />');
                $("#questions_zone").append('<input type="text" class="form-control" name="answer1[]" required="required">');
                $("#questions_zone").append('<label>Answer 2</label> <input type="radio" name="question'+amount_questions+'_answer" value="2" required="required" />');
                $("#questions_zone").append('<input type="text" class="form-control" name="answer2[]" required="required">');
                $("#questions_zone").append('<label>Answer 3</label> <input type="radio" name="question'+amount_questions+'_answer" value="3" required="required" />');
                $("#questions_zone").append('<input type="text" class="form-control" name="answer3[]">');
                $("#questions_zone").append('<label>Answer 4</label> <input type="radio" name="question'+amount_questions+'_answer" value="4" required="required" />');
                $("#questions_zone").append('<input type="text" class="form-control" name="answer4[]"><br><br>');

                amount_questions++;
            })
        });
    </script>


    <form method="POST">
        <input type="hidden" name="quiz_id" value="<?php print $_SESSION['create_progress']; ?>" />
        <div id="questions_zone">
            <label for="question"><strong>Question #1: </strong></label><br>

            <div id="questions_copy">
                <input type="text" class="form-control"  required="required" id="question" name="question[]" value="<?php if (isset($_POST['create_quiz'])) print $_POST['question1']; ?>">
                <label for="answer1">Answer 1</label> <input type="radio" name="question1_answer" value="1"  required="required" />
                <input type="text" class="form-control" id="answer1_1" name="answer1[]" required="required">

                <label for="answer2">Answer 2</label> <input type="radio" name="question1_answer" value="2"  required="required" />
                <input type="text" class="form-control" id="answer2_1" name="answer2[]" required="required">

                <label for="answer3">Answer 3</label> <input type="radio" name="question1_answer" value="3"  required="required" />
                <input type="text" class="form-control" id="answer3_1" name="answer3[]" required="required">

                <label for="answer4">Answer 4</label> <input type="radio" name="question1_answer" value="4"  required="required" />
                <input type="text" class="form-control" id="answer4_1" name="answer4[]" required="required">


            </div><br><br>

        </div>

        <input type="button" id="addQuestion" class="btn btn-default" value="Add Question">
        <input type="submit" name="create_quiz" class="btn btn-default" value="Create Quiz!">
    </form>

    <br><br>
    <form method="post">
    <input type="submit" name="back" class="btn btn-default" value="Go Back">
    </form>
    <?php

}
?>


<h1>Create Quiz</h1>
<br>
<?php
$quiz_id = null;
if (isset($_POST['back'])) {
    $_SESSION['create_progress'] = 0;
}
elseif (isset($_POST['create_quiz'])) {
    $current_question = 0;
    while (isset($_POST['question'][$current_question])) {
        $actual_question = $current_question+1;

        $question = strip_tags($_POST['question'][$current_question]);
        $answer1 = strip_tags($_POST['answer1'][$current_question]);
        $answer2 = strip_tags($_POST['answer2'][$current_question]);
        $answer3 = strip_tags($_POST['answer3'][$current_question]);
        $answer4 = strip_tags($_POST['answer4'][$current_question]);

        $conn->query("INSERT INTO `questions` (`quiz_id`, `question_text`, `answer1_text`, `answer2_text`, `answer3_text`, `answer4_text`, `correct_answer`)
                  VALUES ({$_POST['quiz_id']},'{$question}', '{$answer1}', '{$answer2}',
                   '{$answer3}', '{$answer4}', ".$_POST['question'.$actual_question.'_answer'].")");

        $current_question++;
    }

    $quiz = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = {$_SESSION['create_progress']}");
    $q = $quiz->fetch_array();
    $conn->query("UPDATE `quizzes` SET `status` = 1 WHERE `quiz_id` = {$_SESSION['create_progress']}");



    print "Successfully created the quiz <a href='quiz.php?id={$q['quiz_id']}' /><storng>{$q['name']}</storng></a>!<br><br>";
    print "Redirecting you now...";
    header('Refresh: 5; URL=quiz.php?id='.$q['quiz_id']);

    $_SESSION['create_progress'] = 0;
    die();

}
elseif (isset($_POST['continue_submit']))
{
    // Only runs when 'Continue' button is hit, on the initial form.
    $name = strip_tags($_POST['quiz_name']);
    $description = strip_tags($_POST['quiz_description']);
    $category=$_POST['category'];

    if (strlen($name) < 10)
        array_push($error_messages1, "The name of your quiz is too short! It must be at least 10 characters");
    if (strlen($description) < 10)
        array_push($error_messages1, "The description of your quiz is too short! It must be at least 10 characters");

    if (count($error_messages1) == 0) {
        $logged_user = $_SESSION['user'];
        $logged_user_id = $logged_user['user_id'];
        //print $logged_user_id;
        // Should escape (mysql_real_escape_string) inputs later
        $conn->query("INSERT INTO `quizzes` (`name`, `description`, `image`, `user_id`, `category_id`, `date_created`,`status`)
                        VALUES ('$name','$description', 'SERVER_IMAGE', $logged_user_id, $category, ".time().", 0)");
        print $conn->error;
        $id_query = $conn->query("SELECT MAX(quiz_id) FROM `quizzes`");
        $id = $id_query->fetch_assoc();
        $_SESSION['create_progress'] = $id['MAX(quiz_id)'];
        $quiz_id = $id['MAX(quiz_id)'];
    }
    else
    {
        $_SESSION['create_progress'] = 0;
    }


}

if (!isset($_SESSION['user'])) {
    print "You need to be logged in to create a quiz!<br><br>
            <a href='register.php' />Register an account</a><br>
            <a href='login.php' />Login</a>";
}
else {
    if (!isset($_SESSION['create_progress'])) {
        quiz_form();
    } elseif ($_SESSION['create_progress'] == 0) {
        for ($i = 0; $i < sizeof($error_messages1); $i++) {
            print $error_messages1[$i] . "<br>";
        }

        quiz_form();
    } elseif ($_SESSION['create_progress'] != 0) {
        questions_form($quiz_id);
    }
}




?>

<?php include("footer.php");?>