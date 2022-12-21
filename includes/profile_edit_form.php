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
                                                <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
                                                    <div class="custom-file">
                                                        <input type="file" name="profile_photo" class="custom-file-input" id="profile_photo">
                                                        <label class="custom-file-label" for="profile_photo">Choose profile picture</label>
                                                    </div>
                                                    <span class="error"><?php echo $user->imageMsg;?></span>
                                                    <button class="btn btn-primary" type="submit" name="picture">
                                                        <i class="fa fa-fw fa-camera"></i>
                                                        <span>Change Photo</span>
                                                    </button>
                                                </form>
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
                                                    <button class="btn btn-block btn-primary" type="submit" name="profile">Save Changes</button>
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

</div>