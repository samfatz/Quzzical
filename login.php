<?php
include("db.php");
include("header.php");

if (isset($_POST['login'])) {
    $userNoTags=(strip_tags($_POST['username']));
    $passNoTags=strip_tags(md5($_POST['password']));
    $user_exists = $conn->query("SELECT * FROM `users` WHERE `username` = '$userNoTags' AND `password` = '$passNoTags'");
    if ($user_exists->num_rows == 0) {
        ?>
        <script>
            alert("Incorrect username or password"); // todo improve incorrect login response
        </script>
        <?php
    }
    else
    {
        $user = $user_exists->fetch_array();
        $_SESSION['user'] = $user;
        header("Location: account-view.php");
    }
}
?>

<?php $username_err = $password_err = "";?>
<script>
    function validateForm() {
        var inputUsername = document.forms["login"]["inputUsername"].value;
        if (inputUsername === "") {
            <?php $username_err = "Please enter a username, remember it must be between 4 and 12 characters" ?>
            alert("<?php echo($username_err); ?>");
            return false;
        }
        if (inputUsername.toString().length < 4 || inputUsername.toString().length > 12){
            <?php $username_err = "Your username must be between 4 and 12 characters" ?>
            alert("<?php echo($username_err); ?>");
            return false;
        }
        var inputPassword = document.forms["login"]["inputPassword"].value;
        if (inputPassword === "") {
            <?php $password_err = "Please enter a password" ?>
            alert("<?php echo($password_err); ?>");
            return false;
        }
        if (inputPassword.toString().length < 6 || inputPassword.toString().length > 16) {
            <?php $password_err = "Your password must be between 6 and 16 characters" ?>
            alert("<?php echo($password_err); ?>");
            return false;
        }
    }
</script>

<h1>Login</h1>
<br>
<form name="login" onsubmit="return validateForm()" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Enter username">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password">
    </div>

    <br>
    <input type="submit" class="btn btn-outline-danger" value="Sign In" name="login" />
</form>
<?php
?>
<?php include("footer.php");?>