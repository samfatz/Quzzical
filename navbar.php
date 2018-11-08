<?php if (isset($_SESSION['user'])) $user = $_SESSION['user'];?>
<ul class="nav nav-pills nav-fill justify-content-center">
<!--    <li class="nav-item">-->
<!--        --><?php
//        if (basename($_SERVER['PHP_SELF']) == "index.php") {
//            echo(" <a class=\"nav-link active\" href=\"index.php\">Home</a>");
//        } else{
//            echo("<a class=\"nav-link\" href=\"index.php\">Home</a>");
//        }
//        ?>
<!--    </li>-->
    <li class="nav-item">
        <?php
        if (basename($_SERVER['PHP_SELF']) == "quizzes.php") {
            echo(" <a class=\"nav-link active\" href=\"quizzes.php\">Quizzes</a>");
        } else{
            echo("<a class=\"nav-link\" href=\"quizzes.php\">Quizzes</a>");
        }
        ?>    </li>
    <li class="nav-item">
        <?php
        if (isset($_SESSION['user'])) {
            if (basename($_SERVER['PHP_SELF']) == "account-view.php") {
                echo(" <a class=\"nav-link active\" href=\"account-view.php\">" . $user['username'] . "'s Account</a>");
            } else{
                echo(" <a class=\"nav-link\" href=\"account-view.php\">" . $user['username'] . "'s Account</a>");
            }
        } else{
            if (basename($_SERVER['PHP_SELF']) == "login.php") {
                echo(" <a class=\"nav-link active\" href=\"login.php\">Login</a>");
            } else{
                echo("<a class=\"nav-link\" href=\"login.php\">Login</a>");
            }
        }
        ?>
    </li>
    <li class="nav-item">
        <?php
        if (isset($_SESSION['user'])) {
            echo("<a class=\"nav-link\" href=\"logout.php\">Log Out</a>");
        } else{
            if (basename($_SERVER['PHP_SELF']) == "register.php") {
                echo(" <a class=\"nav-link active\" href=\"register.php\">Register</a>");
            } else{
                echo("<a class=\"nav-link\" href=\"register.php\">Register</a>");
            }
        }
        ?>
    </li>
</ul>
<br>
<hr>
