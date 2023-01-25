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
            //the second condition removes from search results own profile, third condition removes from search results profiles that are already friends
            if ($hint === "" && $user->username!==$friend->username && $user->check_if_user_and_friend_in_search_are_already_friends($friend->username)==false) {
               $hint = <<<DEILMITER
  <div style="min-height: 65px"><br><a href="add_friend_from_search.php?username={$friend->username}" class="btn btn-outline-info btn-sm ml-2">Add <strong>{$friend->username}</strong> as a friend</a><img src='img/profile_photos/{$friend->user_photo}' style='float: right; width: 60px; height: 60px; object-fit: cover;'></div>
DEILMITER;

            } elseif($user->username!==$friend->username && $user->check_if_user_and_friend_in_search_are_already_friends($friend->username)==false) {
                $hint .= <<<DEILMITER
  <div style="min-height: 65px"><br><a href="add_friend_from_search.php?username={$friend->username}" class="btn btn-outline-info btn-sm ml-2">Add <strong>{$friend->username}</strong> as a friend</a><img src='img/profile_photos/{$friend->user_photo}' style='float: right; width: 60px; height: 60px; object-fit: cover;'></div>
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




















