<?php
require_once("includes/init.php");

$_SESSION['username'] = $_SESSION['password'] = "";

$user = new User($database);


if(isset($_POST['login'])){

    $user->login_user();


}

?>