<?php include("db.php"); ?>
<?php include("header.php"); ?>



<?php
$result = $conn->query("SELECT * FROM `users` WHERE `user_id` = {$_GET['id']}");
if ($result->num_rows == 0) {
    echo "This user doesnt exist!";
}
else
{
    $user = $result->fetch_array();

    if (time()-$user['last_active'] < 1200) {// online for 20 mins
        $status = "[ONLINE]";
    }
    else {
        $status = "[OFFLINE]";
    }


    echo("<br><h3 class='quiz-title' align='center'>{$user["username"]}'s Profile</h3>");

    echo("<hr class='quiz-divider'>");

    echo "<strong>Date Registered:</strong> ". date('D d M Y', $user['date_registered'])."<br>";
    echo "<strong>Last Active:</strong> ". date('D d M Y', $user['last_active'])."<br>";
    echo "<strong>Login Status:</strong> $status";

    echo "<br><br>";

    
    
    echo("<br>");
    echo("<h4>{$user['username']}'s Quizzes: </h4>");
    echo("<br>");
    $quizzes = $conn->query("SELECT * FROM `quizzes` WHERE `user_id` = {$user["user_id"]} AND `status` = 1 ORDER BY `score` DESC");
    if ($quizzes->num_rows == 0) {
        echo "{$user['username']} hasn't created any quizzes yet!";
    }
    else{
        ?>
        <table class="table">
        <thead>
        <tr>
            <th scope="col">Rating</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while ($quiz = $quizzes->fetch_array()) {
            print"
            <tr>
                <th scope='row'>{$quiz['score']}</th>
                <td><a href='quiz.php?id={$quiz['quiz_id']}' /><strong>{$quiz['name']}</strong></a></td>
                <td>{$quiz['description']}</td>
            </tr>";
        }
    }
    ?>


        </tbody>
    </table>
    <br><br>
    <h4>Recently Answered Quizzes:</h4>

    <?php
    $quizzes_answered = $conn->query("SELECT * FROM `quizzes_answered` WHERE `user_id` = {$user['user_id']}");
    if ($quizzes_answered->num_rows == 0) {
        echo "{$user['username']} hasn't answered any quizzes yet!";
    }
    else{
        ?>

        <table class="table">
        <thead>
        <tr>
            <th scope="col"><?php echo $user['username']; ?>'s Score</th>
            <th scope="col">Name</th>
            <th scope="col">Quiz Rating</th>
            <th scope="col">Created By</th>
        </tr>
        </thead>
        <?php
        while ($qa = $quizzes_answered->fetch_array()) {
            $quiz = $conn->query("SELECT * FROM `quizzes` WHERE `quiz_id` = {$qa['quiz_id']}");
            $q = $quiz->fetch_array();

            $questions = $conn->query("SELECT * FROM `questions` WHERE `quiz_id` = {$q['quiz_id']}");
            $amount_questions = $questions->num_rows;

            $user = $conn->query("SELECT `username`,`user_id` FROM `users` WHERE `user_id` = {$q['user_id']}");
            $u = $user->fetch_array();
            echo "
            <tr>
                <td>{$qa['score']}/$amount_questions</td>
                <td><a href='quiz.php?id={$q['quiz_id']}' /><strong>{$q['name']}</strong></a></td>
                <td>{$q['score']}</td>
                <td><a href='user.php?id={$u['user_id']}' >{$u['username']}</a></td>
            </tr>";
        }
        echo "</table>";
    }
}
echo"<br><br>";
include("footer.php");
?>