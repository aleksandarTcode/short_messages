<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database); //$database is instance of Database class

$user->set_username($_SESSION['username']);

$user->set_friend($_POST['friend']);

$user->set_msg_text($_POST['message_text']);

$user->add_new_message();

header("Location: sent.php");


?>




<?php include ("includes/home_footer.php");?>
