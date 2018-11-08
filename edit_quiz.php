<?php
include("db.php");
include("header.php");

$quiz_id = $_GET['id'];
$result = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = {$quiz_id}");
$quiz = $result->fetch_array();
$error_messages1 = [];
$quizName = $quiz['name'];
$quizDesc = $quiz['description'];


//function boolean checkUpload()
?>
<?php


// Initial form that shows when user wants to create a quiz.
function quiz_form($quizName, $quizDesc)
{
    ?>
    <!--suppress Annotator -->
    <form id="create-quiz" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data" xmlns="http://www.w3.org/1999/html">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quizName"><strong>Quiz Name</strong></label>
                <input type="text" class="form-control" id="quizName" name="quiz_name" value=<?php print $quizName ?>>
            </div>

        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="quizDescription"><strong>Quiz Description</strong></label>
                <textarea class="form-control" rows="2" id="quizDescription"
                          name="quiz_description"><?php print $quizDesc ?></textarea>
            </div>
        </div>
        <br>
        <input type="submit" id="cont" name="continue_submit" class="btn btn-default" value="Save Changes">
    </form>
    <?php
}

// Form that shows after basic quiz details have been accepted, and questions need to be added.


?>


<?php

if (!isset($_SESSION['user'])) {
    print "You need to be logged in to edit a quiz!<br><br>
            <a href='register.php' />Register an account</a><br>
            <a href='login.php' />Login</a>";
} else {

    quiz_form($quizName, $quizDesc);

}
if (isset ($_POST['continue_submit'])) {
    $name = $_POST['quiz_name'];
    $description = $_POST['quiz_description'];

    if (strlen($name) < 10)
        array_push($error_messages1, "The name of your quiz is too short! It must be at least 10 characters");
    if (strlen($description) < 10)
        array_push($error_messages1, "The description of your quiz is too short! It must be at least 10 characters");
    if (count($error_messages1) == 0) {

        $conn->query("UPDATE `quizzes` SET `name` = '$name' WHERE `quiz_id` = '$quiz_id'");
        $conn->query("UPDATE `quizzes` SET `description` = '$description' WHERE `quiz_id` = '$quiz_id'");
        $_SESSION['create_progress'] = 1;



        print "Successfully edited the quiz <a href='quiz.php?id={$quiz_id}' /><storng>{$quizName}</storng></a>!<br><br>";
        print "Redirecting you now...";
        header('Refresh: 5; URL=quiz.php?id='.$quiz_id);

        $_SESSION['create_progress'] = 0;
        die();
    }

}


?>

    <script>
        function validateForm() {
            var inputName = document.forms["edit_quiz"]["quizName"].value;
            if (inputName.toString().length < 4 || inputName.toString().length > 12){
                <?php $name_err = "Your username must be over 10 characters" ?>
                alert("<?php echo($name_err); ?>");
                return false;
            }
            var inputDesc = document.forms["edit_quiz"]["quizDescription"].value;
            if (inputDesc.toString().length < 10) {
                <?php $word_err = "Your description must be over 10 characters" ?>
                alert("<?php echo($word_err); ?>");
                return false;
            }
        }
    </script>

<?php include("footer.php"); ?>