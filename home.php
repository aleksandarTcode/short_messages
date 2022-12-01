<?php include ("includes/home_header.php");?>


<?php

//print_r($_SESSION);

$user = new User($database);
//$user->set_username($_SESSION['username']);

?>

<form method="post" action="sending_msg.php">

    <div class="form-group">
        <label for="friends">Select Friend</label>
        <select class="form-control" id="friends" name="friend">
            <option class='text-black-50' value="">pick one</option>
            <?php $user->get_friends_for_user(); ?>
        </select>
    </div>

    <div class="form-group">
        <label for="exampleFormControlTextarea1">Example textarea</label>
        <textarea class="form-control" id="message_text" name="message_text" rows="3"></textarea
    </div>

    <button class="btn btn-primary btn-block mt-3" type="submit" name="submit" onClick="return confirm('Send message?')">Send</button>
</form>





<?php include ("includes/home_footer.php");?>





