<?php require_once("includes/init.php"); ?>

<?php

$user = new User($database);

if(isset($_GET['friend_username'])) {
    $user2 = test_input($_GET['friend_username']);
    $user->make_a_friend($user2);
    header("Location: home.php");

}


?>
