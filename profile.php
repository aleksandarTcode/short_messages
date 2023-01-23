<?php include("includes/profile_header.php") ?>

<?php

// Initialize variables for error messages and form input
$first_name_updateErr = $last_name_updateErr = $username_updateErr = $email_updateErr =  $new_passwordErr = $confirm_passwordErr = $current_passwordErr = $imageMsg = "";
$first_name_update = $last_name_update = $username_update = $email_update = $new_password = $confirm_password = $current_password = "";

$onclick = "";

$_SESSION['first_name_update'] = $_SESSION['last_name_update'] = $_SESSION['username_update'] = $_SESSION['email_update'] = $_SESSION['new_password'] = $_SESSION['confirm_password'] = $_SESSION['hashed_password'] = $_SESSION['current_password'] = "" ;


$user = new User($database);


// Check if a profile picture is being uploaded
if(isset($_POST["picture"]) && is_uploaded_file($_FILES['profile_photo']['tmp_name'])) {
    $user->upload_profile_image();
} // end upload profile picture form if

$row = $user->get_user();

if(isset($_POST['profile'])){

    // First and last name check and set
    $text_input_field_check_regEx = "/^[a-zA-Z-' ]*$/";
    $text_input_field_check_msg = "Only letters and white space allowed";
    text_input_field_check('first_name_update',$text_input_field_check_regEx,$text_input_field_check_msg);
    text_input_field_check('last_name_update',$text_input_field_check_regEx,$text_input_field_check_msg);

    // Username check and set
    $username_regEx = "/^[a-zA-Z0-9]*$/";
    $username_msg = "Only letters and numbers allowed";
    text_input_field_check('username_update',$username_regEx,$username_msg);


    // Email check and set
    if (empty($_POST["email_update"])) {
        $email_updateErr = "Email is required";
    }
    // Check if e-mail address is well-formed
    elseif (!filter_var(test_input($_POST["email_update"]), FILTER_VALIDATE_EMAIL)) {
        $email_updateErr = "Invalid email format";
        $_SESSION['email_update'] = $_POST["email_update"];
    }
    else {
        $email_update = test_input($_POST["email_update"]);
        $_SESSION['email_update'] = $email_update;
    }


    if($first_name_update && $last_name_update && $username_update && $email_update ){


        $_SESSION['current_password'] = $_POST['current_password'];

        if(empty($_POST['current_password'])){

            $_SESSION['hashed_password'] = $_SESSION['password_from_database'];

            $user = new User($database);
            $user->update_user();


            $username_updateErr = $user->username_updateErr;//print error message if username is taken
            $email_updateErr = $user->email_updateErr;//print error message if email is taken


            if($username_updateErr=='' && $email_updateErr==''){

                header("Location: profile.php");
            }
        }
        else if(password_verify(test_input($_POST['current_password']),$_SESSION['password_from_database'])){

            // Password check and set
            $password_regEx = "/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/";
            $password_msg = "Password must contain 8-20 characters of at least one lowercase, uppercase, number and special character. Allowed characters are letters, numbers and special characters @#-_$%^&+=§!?";
            text_input_field_check('new_password',$password_regEx,$password_msg);

            // Check is confirmed password the same
            if (empty($_POST["confirm_password"])) {
                $confirm_passwordErr = "Please confirm password";
            } elseif (strcmp($new_password,$_POST["confirm_password"])!==0){
                $confirm_passwordErr = "Password is not confirmed, enter the same password!";
                $_SESSION['confirm_password'] = $_POST["confirm_password"];
            }else {
                $confirm_password = test_input($_POST["confirm_password"]);
                $_SESSION['confirm_password'] = $confirm_password;
                $hashed_password = password_hash($confirm_password, PASSWORD_DEFAULT);
                $_SESSION['hashed_password'] = $hashed_password;

                $user = new User($database);
                $user->update_user();


                $username_updateErr = $user->username_updateErr;//print error message if username is taken
                $email_updateErr = $user->email_updateErr;//print error message if email is taken


                if($username_updateErr=='' && $email_updateErr==''){
                    header("Location: profile.php");
                }

            }

        }else {
            $current_passwordErr = "That is not your current password, please try again or leave this field empty if you don't want to change you password!";
        }


//        $user->mail = $mail;//set mail property in User class to Phpmailer instance



    }


} //end edit profile form if

print_r($_SESSION);
echo "<br>";
print_r($_POST);
echo "<br>";
print_r($_FILES);

?>

<?php include ("includes/profile_edit_form.php") ?>

<?php include ("includes/home_footer.php");?>





