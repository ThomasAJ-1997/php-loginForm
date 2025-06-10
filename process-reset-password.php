<?php 

require 'classes/Connect.php';
require 'classes/Account.php';
require 'classes/Token.php';
$errors = [];

$token = $_POST['token'];

$token_hash = hash("sha256", $token);

$db = new Connect();
$conn = $db->dbConnection();

$new_token = new Token();
$user = $new_token->tokenHash($conn, $token_hash);

if ($user === null) {
    die('Token not found');
}

 if (strtotime($user['reset_token_expires_at']) <= time()) {
    die("Token has expired");
 }   
 $hashed_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*[ !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"])[0-9A-Za-z !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"]{8,50}$/", $_POST['password'])) {
        die('Make sure password contains: 1 digit, 1 capital, 1 lower and 1 special character');
        // Checks for:
        // 1 digit / 1 Capital / 1 lower / 1 special  

    }

    if (strlen(trim($_POST['password'])) < 8) {
        die('Password needs to be more than eight characters');
        
    }

    if (password_verify($_POST['password'], $hashed_password)) {
        $messages[] = 'Valid Password';
    } else {
        die('Invalid Password');
    
    }

    if ($_POST['password'] !== $_POST['password_confirmation']) {
        die('Passwords much match');
    }

    $token_reset = $new_token->resetToken($conn, $hashed_password, $user);
?>

<?php require 'includes/header.php'; ?>


<div class="login-box">
    <header>Successfully reset password</header>
    <a href="login.php">Back to login</a>
</div>

<?php require 'includes/footer.php'; ?>