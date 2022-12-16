<?php include("includes/profile_header.php") ?>

<?php

$first_name_updateErr = $last_name_updateErr = $username_updateErr = $email_updateErr =  $new_passwordErr = $confirm_passwordErr = $current_passwordErr = "";
$first_name_update = $last_name_update = $username_update = $email_update = $new_password = $confirm_password = $current_password = "";

$_SESSION['first_name_update'] = $_SESSION['last_name_update'] = $_SESSION['username_update'] = $_SESSION['email_update'] = $_SESSION['new_password'] = $_SESSION['confirm_password'] = $_SESSION['hashed_password'] = $_SESSION['current_password'] = "" ;


$user = new User($database);
$row = $user->get_user();


if($_SERVER['REQUEST_METHOD'] == 'POST'){

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
        echo "radi ovo sad sve";

        if(password_verify(test_input($_POST['current_password']),$_SESSION['password_from_database'])){

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
                header("Location: profile.php");

            }

        }else {
            $current_passwordErr = "That is not current password, please try again or leave this field empty!";
        }

//        $user = new User($database);

//        $user->mail = $mail;//set mail property in User class to Phpmailer instance
//        $user->add_user();
//        $username_updateErr = $user->usernameErr;//print error message if username is taken
//        $email_updateErr = $user->emailErr;//print error message if email is taken
//
//        if($username_updateErr=='' && $email_updateErr==''){
//            header("Location: profile.php");
//        }


    }


} //end if

print_r($_SESSION);
print_r($_POST);
?>



<div class="container mt-6" id="profile">
    <div class="row flex-lg-nowrap">

        <div class="col">
            <div class="row">
                <div class="col mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="e-profile">
                                <div class="row">
                                    <div class="col-12 col-sm-auto mb-3">
                                        <div class="mx-auto" style="width: 140px;">
                                            <div class="d-flex justify-content-center align-items-center rounded" style="height: 140px; background-color: rgb(233, 236, 239);">
                                                <span style="color: rgb(166, 168, 170); font: bold 8pt Arial;">140x140</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col d-flex flex-column flex-sm-row justify-content-between mb-3">
                                        <div class="text-center text-sm-left mb-2 mb-sm-0">
                                            <h4 class="pt-sm-2 pb-1 mb-0 text-nowrap"><?php echo $row->first_name." ".$row->last_name;?></h4>
                                            <p class="mb-0">@<?php echo $row->username;?></p>
                                            <div class="text-muted"><small>Registered: <?php echo time_elapsed_string($row->time_registered);?></small></div>
                                            <div class="mt-2">
                                                <button class="btn btn-primary" type="button">
                                                    <i class="fa fa-fw fa-camera"></i>
                                                    <span>Change Photo</span>
                                                </button>
                                            </div>
                                        </div>


                                        <div class="text-center text-sm-right">
                                            <span class="badge badge-secondary"><?php echo "Role: ".$row->role;?></span>
                                        </div>
                                    </div>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="" class="active nav-link">Settings</a></li>
                                </ul>
                                <div class="tab-content pt-3">
                                    <div class="tab-pane active">
                                        <form class="form" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onclick="yes">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="first_name">First Name</label>
                                                                <input type="text" class="form-control" name="first_name_update" placeholder="Enter First Name" maxlength="30" value="<?php if(!empty($_SESSION['first_name_update'])){echo $_SESSION['first_name_update'];}else echo $_SESSION['first_name'];?>"><span class="error"><?php echo $first_name_updateErr;?></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="last_name">Last Name</label>
                                                                <input type="text" class="form-control" name="last_name_update" placeholder="Enter Last Name" maxlength="30" value="<?php if(!empty($_SESSION['last_name_update'])){echo $_SESSION['last_name_update'];}else echo $_SESSION['last_name'];?>"><span class="error"><?php echo $last_name_updateErr;?></span>
                                                            </div>
                                                        </div>



                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="user">Username</label>
                                                                <input class="form-control" name="username_update" type="text" id="username_update" placeholder="Enter Username" maxlength="30" value="<?php if(!empty($_SESSION['username_update'])){echo $_SESSION['username_update'];}else echo $_SESSION['username'];?>"><span class="error"><?php echo $username_updateErr;?></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input class="form-control" name="email_update" type="text" id="email_update" placeholder="Enter Email" maxlength="30" value="<?php if(!empty($_SESSION['email_update'])){echo $_SESSION['email_update'];}else echo $_SESSION['email'];?>"><span class="error"><?php echo $email_updateErr;?></span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 col-sm-6 mb-3">
                                                    <div class="mb-2"><b>Change Password</b></div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="current_password">Current Password</label>
                                                                <input class="form-control" name="current_password" type="password" id="current_password" placeholder="••••••" maxlength="30" value="<?php echo $_SESSION['current_password']; ?>"><span class="error"><?php echo $current_passwordErr;?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="form-group">
                                                                <label for="new_password">New Password</label>
                                                                <input class="form-control" name="new_password" type="password" id="new_password" placeholder="••••••" maxlength="30" value="<?php echo $_SESSION['new_password']; ?>"><span class="error"><?php echo $new_passwordErr;?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col">
                                                        <div class="form-group">
                                                            <label for="confirm_password"> Password</span></label>
                                                            <input class="form-control" name="confirm_password" type="password" placeholder="••••••" id="password2" maxlength="30" value="<?php echo $_SESSION['confirm_password']; ?>"><span class="error"><?php echo $confirm_passwordErr;?></span>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>

                                                <div class="col-md-3 mt-4">
                                                    <button class="btn btn-block btn-primary" type="submit" >Save Changes</button>
                                                </div>


                                                        <div class="col-md-3 mt-4">
                                                                <a href="logout.php" class="btn btn-block btn-secondary" role="button" onClick="return confirm('Are you sure you want to logout?')">Logout</a>
                                                        </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



        </div>
    </div>
</div>








<?php include ("includes/home_footer.php");?>





