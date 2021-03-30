<?php
require_once("includes/config.php");

$_SESSION['username'] = "";

if(isset($_POST['login'])){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $_SESSION['username'] = $username;

    header("Location: home.php");


}

?>