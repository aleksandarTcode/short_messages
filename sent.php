<?php include ("includes/home_header.php");?>



<?php

$user = new User($database); //$database is instance of Database class

$row = $user->messages_for_current_user_with_pagination('SELECT msg.id,msg.recipient,msg.msg_text,msg.time,msg.read_msg,users.user_photo FROM msg LEFT JOIN users ON msg.recipient = users.username WHERE sender = ? ORDER BY time DESC', $user->username);

if ($row!==null){

?>


<table class='table table-bordered mt-5'>
    <thead>
    <tr>
        <th class="text-center align-middle">Recipient</th>
        <th class="text-center align-middle">Message</th>
        <th class="text-center align-middle">Time</th>
        <th class="text-center align-middle">Delivery Report</th>
    </tr>
    </thead>

    <?php



        ?>
        <tbody>
        <tr>

            <?php
            // for user.photo select from database

            if($row){
            foreach($row as $msg){
            ?>
        <tr>
            <td class="text-center align-middle"><strong><a href='thread_from_sent.php?friend=<?php echo $msg->recipient; ?>'><?php echo $msg->recipient; ?></a></strong>&nbsp;<img src="img/profile_photos/<?php echo $msg->user_photo; ?>" width="30px" style="border-radius:50%"></td>
            <td><a href="message_from_sent.php?id=<?php echo $msg->id;?>" class="text-success"><?php echo (strlen($msg->msg_text) > 15) ? substr($msg->msg_text, 0, 15) . '...' : $msg->msg_text; ?></a></td>
            <td class="text-center align-middle"><?php echo $msg->time; ?></td>
            <td class="text-center align-middle"><?php echo $msg->read_msg==1?"delivered":"waiting for delivery";  ?></td>
        </tr>


        <?php
    }//end foreach
        } //end if
    ?>

    </tr>
    </tbody>
</table>

    <?php
}// end if row exists

else {
    echo "There are no messages here!";
}
?>

<?php include("includes/home_footer.php"); ?>




