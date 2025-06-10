<?php 
session_start();

require 'classes/Connect.php';
require 'classes/Account.php';
require 'classes/Cookies.php';


if (isset($_SESSION['account_loggedin'])) {
    header('Location: dashboard.php');
    exit;
}

$is_invalid = false;

$errors = [];
$message = [];

$id = '';
$firstname = '';
$lastname = '';
$email = '';
$password = '';
$remember = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
   $db = new Connect();
   $conn = $db->dbConnection();
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $account = new Account($firstname, $lastname, $email, $password);

    $user = $account->getAccountEmail($conn, $email);

    $cookies = new Cookies($remember, $email);
    $remember = $cookies->checkCookies($remember, $email);

    if (empty($email) || empty($password)) {
        $errors[] = 'Please fill both username and password fields';
    }

    if ($user) {
        $errors = $account->validateVerifiedPassword($password, $user);

} else {
    $errors[] = 'Email and/or password is invalid, please try again';
}

} $is_invalid = true;


?>

<?php require 'includes/header.php'; ?>

<div class="login-box">
    <form action="" method="post">
                <div class="login-header">
            <header>Login Form</header>
        </div>

        <div class="input-box">
            <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off" value="<?php if(!empty($email)) { echo $email; } elseif (isset($_COOKIE['remember_email'])) { echo $_COOKIE['remember_email']; } ?>">
        </div>

        <div class="input-box">
            <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off">
        </div>

        <div class="forgot">
            <section>
                <input name="remember" type="checkbox" id="check">
                <label for="check">Remember me</label>
            </section>
            <section>
                <a href="forgot.php">Forgot Password</a>
            </section>
        </div>

          <?php if(!empty($errors)): ?>
            <ul>
        <?php foreach($errors as $error): ?>
            <div class="error">
                <li class="error-text"><?= $error ?></li>
            </div>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>


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