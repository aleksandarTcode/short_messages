<?php include ("includes/home_header.php");?>



<?php


//print_r($_SESSION);

$user = new User($database); //$database is instance of Database class
$user->set_username($_SESSION['username']);

$message_id = $_GET['id'];


$result_array = $user->messages_for_current_user('SELECT id,recipient,msg_text,time,read_msg FROM msg WHERE id = ? ORDER BY time DESC',$message_id);


?>


<table class='table table-bordered mt-5'>
    <thead>
    <tr>
        <th class='text-center align-middle' style="width: 10%">Recipient</th>
        <th class='text-center align-middle' style="width: 75%">Message</th>
        <th class='text-center align-middle' style="width: 15%">Time</th>

    </tr>
    </thead>

    <?php

    foreach ($result_array as $msg){

        ?>
        <tbody>
        <tr>
            <td class='text-center align-middle'><strong><a href='thread_from_sent.php?friend=<?php echo $msg->recipient; ?>'><?php echo $msg->recipient; ?></a></strong></td>
            <td><?php echo $msg->msg_text; ?></td>
            <td class='text-center align-middle'><?php echo $msg->time; ?></td>

        </tr>
        </tbody>

        <?php
    }
    ?>

</table>



<?php include("includes/home_footer.php"); ?>














