<?php require_once("init.php"); ?>

<?php

$user = new User($database); //$database is instance of Database class
$user->set_username($_SESSION['username']);

$result_array = $user->get_all_users_for_search();

//print_r($result_array);

$q = $_REQUEST["q"];

$hint = "";


// lookup all hints from array if $q is different from ""
if ($q !== "") {
    $q = strtolower($q);
    $len=strlen($q);

    foreach($result_array as $friend) {

        $friends_search = strtolower($friend->username);
        $friends_search = html_entity_decode($friend->username);
        $friends_search = strip_tags($friend->username);


        if (strpos($friends_search,$q)!==false) {
            //a second condition removes from search results own profile
            if ($hint === "" && $user->username!==$friend->username) {
               $hint = <<<DEILMITER
  <div style="min-height: 65px"><br><a href = 'friend_profile_from_search.php?id={$friend->id}'>{$friend->username}<img src='img/profile_photos/{$friend->user_photo}' style='float: right; width: 60px; height: 60px; object-fit: cover;'></a></div>
DEILMITER;

            } elseif($user->username!==$friend->username) {
                $hint .= <<<DEILMITER
  <div style="min-height: 65px"><br><a href = 'friend_profile_from_search.php?id={$friend->id}'>{$friend->username}<img src='img/profile_photos/{$friend->user_photo}' style='float: right; width: 60px; height: 60px; object-fit: cover;'></a></div>
DEILMITER;
            }//end else
        }//end strpos if
    }//end foreach
}

// Output "no suggestion" if no hint was found or output correct values
if($hint === "") {
    echo "no suggestion";
}elseif($len<3){
    echo "Type min 3 characters";
}
else echo $hint;


?>




















