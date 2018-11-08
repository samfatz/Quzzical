<?php $email_err = $username_err = $password_err = $confirmPass_err = ""; include("db.php"); ?>

<script>
    function validateForm() {
        var inputEmail = document.forms["register"]["inputEmail"].value;
        if (inputEmail === "") {
            <?php $email_err = "Please enter your email address" ?>
            alert("<?php echo($email_err); ?>");
            return false;
        }
        var inputUsername = document.forms["register"]["inputUsername"].value;
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
        var inputPassword = document.forms["register"]["inputPassword"].value;
        if (inputPassword === "") {
            <?php $password_err = "Please enter a password between 8 and 16 characters" ?>
            alert("<?php echo($password_err); ?>");
            return false;
        }
        if (inputPassword.toString().length < 6 || inputPassword.toString().length > 16) {
            <?php $password_err = "Your password must be between 6 and 16 characters" ?>
            alert("<?php echo($password_err); ?>");
            return false;
        }
        var inputConfirmPassword = document.forms["register"]["inputConfirmPassword"].value;
        if (inputConfirmPassword === ""  || inputConfirmPassword !== inputPassword) {
            <?php $confirmPass_err = "Your passwords don't match" ?>
            alert("<?php echo($confirmPass_err); ?>");
            return false;
        }
    }
</script>

<form name="register"  onsubmit="return validateForm()" method="POST">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Email</label>
            <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="xXx_htid_xXx@live.com">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group col-md-6">
            <label for="inputPassword4">Username</label>
            <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="1337_Sn1p3z">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="inputAddress">Password</label>
            <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="dangerouswoman">
        </div>
        <div class="form-group col-md-6">
            <label for="inputAddress2">Confirm Password</label>
            <input type="password" class="form-control" id="inputConfirmPassword" name="inputConfirmPassword" placeholder="dangerouswoman">
        </div>
    </div>

    <br>
    <input type="submit" class="btn btn-outline-danger" name="register" value="Register"/>
</form>