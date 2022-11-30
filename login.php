<?php
require_once("includes/init.php");


$user = new User($database);


if(isset($_POST['login'])){

    $user->login_user();


}

?>