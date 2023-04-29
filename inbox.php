<?php include ("includes/home_header.php");?>



<?php


$user = new User($database); //$database is instance of Database class

$row = $user->messages_for_current_user_with_pagination('SELECT msg.id,msg.sender,msg.msg_text,msg.time,msg.read_msg,users.user_photo FROM msg LEFT JOIN users ON msg.sender = users.username WHERE recipient = ? ORDER BY time DESC', $user->username);

if ($row!==null){

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


    <tbody>
    <tr>
        <?php
        // for user.photo select from database
        if($row){
        foreach($row as $msg){
            ?>
                <tr>
                 <td class="text-center align-middle"><strong><a href='thread_from_inbox.php?friend=<?php echo $msg->sender;?>'><?php echo $msg->sender;?></a></strong>&nbsp;<img src="img/profile_photos/<?php echo $msg->user_photo; ?>" width="30px" style="border-radius:50%"></td>
                    <td><a href="message_from_inbox.php?id=<?php echo $msg->id;?>" class="text-success">
                    <?php echo (strlen($msg->msg_text) > 15) ? substr($msg->msg_text, 0, 15) . '...' : $msg->msg_text; ?></a></td>
                    <td class="text-center align-middle"><?php echo $msg->time;?></td>
                     <td class="text-center align-middle"><?php echo $msg->read_msg==1?"<i class='fas fa-check' style='color:green; background-color: transparent;vertical-align: bottom' ></i>":"<i class='far fa-times-circle' style='color:red'></i>"; ?></td>
                     </tr>



        <?php
        } //end foreach

        }

        ?>
    </tr>
    </tbody>



</table>

<?php
}// end if row exists

else {
    echo "There are no messages in inbox!";
}
?>



<?php include("includes/home_footer.php"); ?>














