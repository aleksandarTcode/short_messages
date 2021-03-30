<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database);
$user->set_username($_SESSION['username']);

$user->inbox_for_user();
?>




<?php include ("includes/home_footer.php");?>





