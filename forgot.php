<?php 

?>

<?php require 'includes/header.php'; ?>

<div class="login-box">
    <form action="functions/send-password-reset.php" method="post">
                <div class="login-header">
            <header>Forgot Password</header>
        </div>

        <div class="input-box">
            <input type="email" name="email" class="input-field" placeholder="Email" autocomplete="off">
        </div>

          <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Reset Password</label>
        </div>

   
        </form>

<?php require 'includes/footer.php'; ?>