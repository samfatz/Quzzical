<?php
$servername = "devweb2017.cis.strath.ac.uk";
$username = "cs312_p";
$password = "Aisush5pi5ei";
$dbname = $username;

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " .$conn->connect_error);
}