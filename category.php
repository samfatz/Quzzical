<?php include("db.php"); ?>
<?php include("header.php"); ?>
<?php
$cat_query = $conn->query("SELECT * FROM `categories` WHERE `category_id` = {$_GET['id']}");
$cat = $cat_query->fetch_array();
?>

<h1 class="quiz-title" align="center">Category: <?php print $cat['name'];?></h1>
<hr class="quiz-divider">
<br>
<br>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Popularity</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Creator</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $quizzes = $conn->query("SELECT * FROM `quizzes` WHERE `status` = 1 AND `category_id` = {$_GET['id']} ORDER BY `score` DESC");
    while($quiz = $quizzes->fetch_array()) {
        $user = $conn->query("SELECT `username`,`user_id` FROM `users` WHERE `user_id` = {$quiz['user_id']}");
        $u = $user->fetch_array();
        print"
        <tr>
            <th scope='row'>{$quiz['score']}</th>
            <td><a href='quiz.php?id={$quiz['quiz_id']}' /><strong>{$quiz['name']}</strong></a></td>
            <td>{$quiz['description']}</td>
            <td><a href='user.php?id={$u['user_id']}' />{$u['username']}</a></td>
        </tr>";
    }
    ?>
    </tbody>
</table>


<?php include ("footer.php"); ?>
