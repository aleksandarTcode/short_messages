<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database); //$database is instance of Database class
//$user->set_username($_SESSION['username']);


$result_array = $user->messages_for_current_user('SELECT id,sender,msg_text,time,read_msg FROM msg WHERE recipient = ? ORDER BY time DESC',$user->username);

?>


<table class='table table-bordered mt-5'>
    <thead>
    <tr>
        <th class="text-center align-middle" style="width: 15%">Sender</th>
        <th class="text-center align-middle" style="width: 45%">Message</th>
        <th class="text-center align-middle" style="width: 30%">Time</th>
        <th class="text-center align-middle" style="width: 10%">Already Read</th>
    </tr>
    </thead>

    <?php

foreach ($result_array as $msg){

?>
        <tbody>
                 <tr>
                    <td class="text-center align-middle"><strong><a href='thread_from_inbox.php?friend=<?php echo $msg->sender; ?>'><?php echo $msg->sender; ?></a></strong></td>
                    <td><a href="message_from_inbox.php?id=<?php echo $msg->id;?>" class="text-success"><?php echo (strlen($msg->msg_text) > 15) ? substr($msg->msg_text, 0, 15) . '...' : $msg->msg_text; ?></a></td>
                    <td class="text-center align-middle"><?php echo $msg->time; ?></td>
                     <td class="text-center align-middle"><?php echo $msg->read_msg==1?"<i class='fas fa-check' style='color:green; background-color: transparent;vertical-align: bottom' ></i>":"<i class='far fa-times-circle' style='color:red'></i>"; ?></td>
                 </tr>
                 </tbody>

<?php
    }
?>

</table>



<?php include("includes/home_footer.php"); ?>














