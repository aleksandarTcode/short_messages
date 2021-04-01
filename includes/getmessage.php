<?php require_once("init.php"); ?>

<?php

$user = new User($database); //$database is instance of Database class
$user->set_username($_SESSION['username']);

$result_array = $user->get_all_messages_for_current_user('SELECT id,sender,recipient,msg_text,time,read_msg,time FROM msg WHERE recipient = ? OR sender = ? ORDER BY time DESC',$user->username,$user->username);


$q = $_REQUEST["q"];

$hint = "";

// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);

    foreach($result_array as $msg) {

        $msg_text = strtolower($msg->msg_text);
        $msg_text = html_entity_decode($msg_text);
        $msg_text = strip_tags($msg_text);


        if($msg->sender==$user->username){
            $href = "message_from_sent.php?id=$msg->id";
        }else $href = "message_from_inbox.php?id=$msg->id";


        if (strpos($msg_text,$q)!==false) {
            if ($hint === "") {
                $hint = "<br>"."<a href = {$href}>".$msg_text." <i class='text-info'>"."(".($msg->sender==$user->username?"me to ".$msg->recipient:$msg->sender).")"."</i>"." "."<i class='text-info'>".time_elapsed_string($msg->time)."</i>"."</a>";
            } else {
                $hint .= "<br>"."<a href={$href}>".$msg_text." <i class='text-info'>"."(".($msg->sender==$user->username?"me to ".$msg->recipient:$msg->sender).")"."</i>"." "."<i class='text-info'>".time_elapsed_string($msg->time)."</i>"."</a>";
            }
        }
    }
}

// Output "no suggestion" if no hint was found or output correct values
if($hint === ""){
    echo "no suggestion";
}elseif($len<3){
    echo "Type min 3 characters";
}
else echo $hint;


?>




















