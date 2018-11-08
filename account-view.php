<?php
include("db.php");
include("header.php");
$user = "NOT SET";
if (!isset($_SESSION['user'])) {
    header("location: login.php");
} else{
    $user = $_SESSION['user'];
}
echo ("<br><h1 class='quiz-title' align='center'>" . "My Account </h1>");
echo ("<hr class='quiz-divider'>");
echo ("<br>");
echo ("<p class='questions' align='center'>My Details</p>");
echo ("<br>");
echo ("<div class='account-details'>");
echo ("<strong>Username: </strong>" . $user["username"] . "<br>");
echo ("<strong>Email: </strong>" . $user["email"] . "<br>");
echo "<strong>Date Registered:</strong> ". date('D d M Y', $user['date_registered'])."<br>";
echo "<strong>Last Active:</strong> ". date('D d M Y', $user['last_active'])."<br>";
echo "<a href='account-edit.php' /><strong>Edit Account Details</strong></a>";


echo "<hr class='quiz-divider'>";
echo ("<p class='questions' align='center'>My Quizzes</p>");
echo ("<br>");
?>

    <table class="table">
        <thead>
        <tr>
            <th scope="col">Popularity Rating</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $quizzes = $conn->query("SELECT * FROM `quizzes` WHERE `user_id` = {$user["user_id"]} ORDER BY `score` DESC");
        while($quiz = $quizzes->fetch_array()) {
            print"
        <tr>
            <th scope='row'>{$quiz['score']}</th>
            <td><a href='quiz.php?id={$quiz['quiz_id']}' /><strong>{$quiz['name']}</strong></a></td>
            <td>{$quiz['description']}</td>
            
        </tr>";
        }
        ?>
        </tbody>
    </table>


<?php
echo "<br><br>";
echo ("<hr class='quiz-divider'>");
echo ("</div>");

?>
<?php include("footer.php");?>