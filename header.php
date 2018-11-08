<?php session_start();
if (isset($_SESSION['user']))
    $conn->query("UPDATE `users` SET `last_active` = ".time()." WHERE `user_id` = {$_SESSION['user']['user_id']}");
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Quizzical</title>
    <!-- Custom styling -->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Captcha script -->
    <script src='https://www.google.com/recaptcha/api.js'></script
</head>
<body>

<h1 class="site-title" align="center">Quizzical</h1>
<br>
<br>
<?php include("navbar.php"); ?>
