

<div class="col-lg-4">
    <div class="card bg-primary text-center card-form">
        <div class="card-body">
            <h3>Login</h3>
            <p>Please fill out this form to login</p>
            <form action="login.php" method="post" >
                <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>
                <p class="error text-center"><?php echo display_message();?></p>
                <input type="submit" value="Login" name="login" class="btn btn-outline-light btn-block">
                <a href="register.php" class="btn btn-outline-dark btn-block" name="register">Register</a>
            </form>
        </div>
    </div>
</div>

