<?php include("db.php"); ?>
<?php include("header.php");?>


<h1>Register</h1>
<br>
<?php
    if (isset($_POST['register'])) {
        $email = (strip_tags($_POST['inputEmail']));
        $newUsername = (strip_tags($_POST['inputUsername']));
        $newPassword = (strip_tags(md5($_POST['inputPassword'])));
        $date = time();

        $emailCheck = $conn->query("SELECT * FROM `users` WHERE `email` = \"{$email}\"");
        if ($emailCheck->num_rows != 0) {
            echo ("Error, a user with that email address already exists" . "<br>");
        }else{

        $usernameCheck = $conn->query("SELECT * FROM `users` WHERE `username` = \"{$newUsername}\"");
        if ($usernameCheck->num_rows != 0) {
            echo ("Error, a user with that username already exists" . "<br>");
        }else{

        $conn->query("INSERT INTO `users` (`username`, `email`, `password`, `date_registered`) 
                            VALUES ('{$newUsername}', '{$email}', '{$newPassword}', '{$date}' )");
        $get_id = $conn->query("SELECT MAX(user_id) FROM `users`");
        $id = $get_id->fetch_array();
        $user_id = $id['MAX(user_id)'];
        $user_conn = $conn->query( "SELECT * FROM `users` WHERE `user_id` = {$user_id}");
        $user = $user_conn->fetch_array();
        $_SESSION['user'] = $user;
        echo("Registration Successful!");
        //header("Location: account-view.php");
    }}
    }
?>
<?php include("register-form.php"); ?>
<?php include("footer.php");?>