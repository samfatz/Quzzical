<?php
include("db.php");
include("header.php");

//Get user quiz search
if(isset($_POST['Search'])){
    $quizToSearch = strip_tags($_POST['searchValue']);
    $query = "SELECT * FROM `quizzes` WHERE `name` LIKE '%{$quizToSearch}%'";
    $search_result = searchQuiz($query);

} else {
    $query = "SELECT * FROM `quizzes`";
    $search_result = searchQuiz($query);
}

function searchQuiz($query){
    global $conn;
    $filter_search = mysqli_query($conn, $query);
    //echo "Error:", mysqli_error($conn);
    return $filter_search;
}
?>
<h1 class="quiz-title" align="center">Quizzes</h1>
<?php if (isset($_SESSION['user'])){
    print ("<p align='center'><a href=\"create-quiz.php\">Create a new Quiz</a></p>
");
} ?>
    <hr class="quiz-divider">
<div align="center" class="search">
    <form name="search" action="quizzes.php" method="POST">
        <input type="text" class="form-control" name="searchValue" placeholder="Search for a quiz">
        <br>
        <input type="submit" class="btn btn-outline-primary" name="Search" value="Search">
    </form>
</div>
    <br>
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Popularity</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Creator</th>
            <th scope="col">Category</th>
        </tr>
        </thead>
        <tbody>
        <?php

            $quizzes = $conn->query("SELECT * FROM `quizzes` WHERE `status`= 1 ORDER BY `score` DESC");
            if(!(isset($_POST['Search']))){
                while ($quiz = $quizzes->fetch_array()) {
                    $user = $conn->query("SELECT `username`,`user_id` FROM `users` WHERE `user_id` = {$quiz['user_id']}");
                    $u = $user->fetch_array();

                    $cat = $conn->query("SELECT * FROM `categories` WHERE `category_id` = {$quiz['category_id']}");
                    $c = $cat->fetch_array();
                    print"
        <tr>
            <th scope='row'>{$quiz['score']}</th>
            <td><a href='quiz.php?id={$quiz['quiz_id']}' /><strong>{$quiz['name']}</strong></a></td>
            <td>{$quiz['description']}</td>
            <td><a href='user.php?id={$u['user_id']}' />{$u['username']}</a></td>
            <td><a href='category.php?id={$c['category_id']}' />{$c['name']}</a></td>
        </tr>";
                }
            } else {
                while ($search = mysqli_fetch_array($search_result)) {
                    $user = $conn->query("SELECT `username`,`user_id` FROM `users` WHERE `user_id` = {$search['user_id']}");
                    $u = $user->fetch_array();
                    print"
        <tr>
            <th scope='row'>{$search['score']}</th>
            <td><a href='quiz.php?id={$search['quiz_id']}' /><strong>{$search['name']}</strong></a></td>
            <td>{$search['description']}</td>
            <td><a href='user.php?id={$u['user_id']}' />{$u['username']}</a></td>
            <td></td>
        </tr>";
                }
            }

            ?>
            </tbody>
            </table>

    <hr class="quiz-divider">
<?php
if(isset($_POST['Search'])) {
    echo ("<div align=\"center\">
    <form name=\"resetTable\" action=\"quizzes.php\" method=\"POST\">
        <input type=\"submit\"  class=\"btn btn-outline-danger\" value=\"Reset table\">
        <br>
    </form>
</div>");
}

?>




<?php include("footer.php");?>