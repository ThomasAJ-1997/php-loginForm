<?php 
require 'functions/connection.php';

dbConnection();


?>

<?php require 'includes/header.php'; ?>

<div class="login-box">
    <form action="" method="post">
                <div class="login-header">
            <header>Login Form</header>
        </div>

        <div class="input-box">
            <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off">
        </div>

        <div class="input-box">
            <input type="text" name="password" class="input-field" placeholder="Password" autocomplete="off">
        </div>

        <div class="forgot">
            <section>
                <input type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>
            <section>
                <a href="forgotPassword.php">Forgot Password</a>
            </section>
        </div>

        <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Sign In</label>
        </div>
        <div class="sign-up-link">
            <p>Don't have an account? <a href="create.php">Sign Up</a></p>
            
        </div>
    </div>
</form>
    
<?php require 'includes/footer.php'; ?>