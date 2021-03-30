<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database); //$database is instance of Database class
$user->set_username($_SESSION['username']);

$user->inbox_for_current_user();
?>




<?php include ("includes/home_footer.php");?>





