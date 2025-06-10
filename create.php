<?php

require 'classes/Connect.php';
require 'classes/Account.php';

session_start();

if (isset($_SESSION['account_loggedin'])) {
    header('Location: dashboard.php');
    exit;
}

$firstname = '';
$lastname = '';
$email = '';
$password = '';
$messages = [];

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $db = new Connect();
    $conn = $db->dbConnection();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $account = new Account($firstname, $lastname, $email, $password);
    // Validate Errors
    $errors = $account->validateAccount($conn, $firstname, $lastname, $email, $password);


    if(empty($errors)) {
        $messages[] = 'Registration Successful. Please sign in';

        $account->registerAccount($conn, $firstname, $lastname, $email, $hashed_password);
    }
}


?>

<?php require 'includes/header.php'; ?>

    <div class="login-box">
        <form action="create.php" method="post">
            <div class="login-header">
                <header>Create Account</header>
            </div>

            <div class="input-box">
                <input type="text" name="firstname" class="input-field" placeholder="First Name" autocomplete="off" value="<?= htmlspecialchars($firstname) ?>">
            </div>

            <div class="input-box">
                <input type="text" name="lastname" class="input-field" placeholder="Last Name" autocomplete="off" value="<?= htmlspecialchars($lastname)?>">
            </div>

            <div class="input-box">
                <input type="text" name="email" class="input-field" placeholder="Email" autocomplete="off" value="<?= htmlspecialchars($email)?>">
            </div>

            <div class="input-box">
                <input type="password" name="password" class="input-field" placeholder="Password" autocomplete="off">
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

            <?php if(!empty($messages)): ?>
                <ul>
                    <?php foreach($messages as $message): ?>
                        <div class="message">
                            <li class="message-text"><?= $message ?></li>
                        </div>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>



            <div class="input-submit">
                <button class="submit-btn" id="submit"></button>
                <label for="submit">Sign Up</label>
            </div>
            <div class="sign-up-link">
                <p>Have An Account? <a href="login.php">Sign In</a></p>

            </div>
    </div>
    </form>

<?php require 'includes/footer.php'; ?>

