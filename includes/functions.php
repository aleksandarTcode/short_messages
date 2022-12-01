<?php

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

function set_message($msg){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else {
        $msg = "";
    }
}

function display_message(){
    if(isset ($_SESSION['message'])){
        echo  $_SESSION['message'];
        unset($_SESSION['message']);
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function text_input_field_check($data,$regex_pattern,$message){

    if (empty($_POST[$data])) {
        global ${$data.'Err'}; // makes name for error variable, ex. if $input is first_name, it is first_nameErr
        ${$data.'Err'} = "Field is required";
        ${$data.'C'} = 0;
    }  // check regular expression for input
    elseif (!preg_match($regex_pattern, $_POST[$data])) {
        global ${$data.'Err'};
        ${$data.'Err'} = $message;
        ${$data.'C'} = 0;
        $_SESSION[$data] = $_POST[$data]; // makes session for form output when input is wrong
    }
    else {
        global $$data; // // makes name for variable
        $$data = test_input($_POST[$data]);
        $_SESSION[$data] = $$data;
    }
}




?>