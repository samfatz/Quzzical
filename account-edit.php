
<?php
include("db.php");
include("header.php");

$user = "NOT SET";
if (!isset($_SESSION['user'])) {
    header("location: login.php");
} else{
    $user = $_SESSION['user'];
}

if(isset ($_POST['update'])){
    if($_POST['username'] !== ""){
        $userName= (strip_tags($_POST['username']));
$nameTaken = $conn->query("SELECT * FROM `users` WHERE `username` = '$userName'");

    if($nameTaken->num_rows!==0){?>
        <script>
        alert("Username is already in use");
        </script>
        <?php
    }else{
        $newUsername = (strip_tags($_POST['username']));
        $oldName=$user[1];
        $conn->query("UPDATE `users` SET `username` = '$newUsername' WHERE `username` = '$oldName'");
        $getUserInfo =$conn->query("SELECT * FROM `users` WHERE `username` = '$newUsername'");
        $user = $getUserInfo->fetch_array();
        $_SESSION['user'] = $user;
    }

}if($_POST['password'] !== "" && $_POST['passwordV']!==""){


        if($_POST['password']!==$_POST['passwordV']){
                ?>
            <script>
                alert("Sorry passwords dont match");
            </script>
            <?php
        }else{
            $finalPass =(strip_tags(md5($_POST['password'])));
            $username=$_SESSION['user'];
            $conn->query("UPDATE `users` SET `password` = '$finalPass' WHERE `username` = '{$username[1]}'");
        }
    }

    if($_POST['email']!==""){
    $email = strip_tags($_POST['email']);
        $username=$_SESSION['user'];
        $conn->query("UPDATE `users` SET `email` = '$email' WHERE `username` = '{$username[1]}'");

    }
    header("location: account-view.php");

}



echo ("<br><h3 class='quiz-title' align='center'>" . "Edit $user[1]'s Account </h3>");
echo ("<hr class='quiz-divider'>");
?>
<form name="update" onsubmit="return validateForm()" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">New Username:</label>
        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Enter new username">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">New Password:</label>
        <input type="password" class="form-control" id="inputPassword" name="password" placeholder=" New Password">
    </div><div class="form-group">
        <label for="exampleInputPassword1">Verify new Password:</label>
        <input type="password" class="form-control" id="verifyPassword" name="passwordV" placeholder=" Re-enter Password">
    </div><div class="form-group">
        <label for="exampleInputPassword1">Update Email address:</label>
        <input type="text" class="form-control" id="email" name="email" placeholder=" Change Email">
    </div>

    <br>
    <input type="submit" class="btn btn-default" value="Update info" name="update" />

    <?php $username_err = $password_err = "";?>
    <script>
        function validateForm() {
            var inputUsername = document.forms["update"]["inputUsername"].value;
            if (inputUsername !== "") {




            if (inputUsername.toString().length < 4 || inputUsername.toString().length > 12){
                <?php $username_err = "Your username must be between 4 and 12 characters" ?>
                alert("<?php echo($username_err); ?>");
                return false;
            }
            }
            var inputPassword = document.forms["update"]["inputPassword"].value;
            var inputPassVerify = document.forms["update"]["verifyPassword"].value;
            if (inputPassword !== "") {

            if (inputPassword.toString().length < 6 || inputPassword.toString().length > 16) {
                <?php $password_err = "Your password must be between 6 and 16 characters" ?>
                alert("<?php echo($password_err); ?>");
                return false;
            }
            if(inputPassword.toString() !== inputPassVerify.toString()){
                <?php $password_err = "New passwords dont match" ?>
                alert("<?php echo($password_err); ?>");
                return false;
            }
            }
        }
    </script>