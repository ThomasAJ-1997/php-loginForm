<?php 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Registration Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-box">
    <form action="" method="post">
                <div class="login-header">
            <header>Create Account</header>
        </div>

        <div class="input-box">
            <input type="text" name="firstname" class="input-field" placeholder="First Name" autocomplete="off">
        </div>

        <div class="input-box">
            <input type="text" name="lastname" class="input-field" placeholder="Last Name" autocomplete="off">
        </div>

        <div class="input-box">
            <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off">
        </div>

        <div class="input-box">
            <input type="text" name="password" class="input-field" placeholder="Password" autocomplete="off">
        </div>

        <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Sign Up</label>
        </div>
        <div class="sign-up-link">
            <p>Have An Account? <a href="login.php">Sign In</a></p>
            
        </div>
    </div>
</form>
    
</body>
</html>