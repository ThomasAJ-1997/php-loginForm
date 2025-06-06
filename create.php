<?php 
session_start();

require 'functions/connection.php';
require 'functions/validator.php';

if (isset($_SESSION['account_loggedin'])) {
    header('Location: dashboard.php');
    exit;
}

$errors = [];
$messages = [];

$firstname = '';
$lastname = '';
$email = '';
$password = '';

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $conn = dbConnection();

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Validate Errors
    $errors = validateAccount($conn, $firstname, $lastname, $email, $password);


    if(empty($errors)) {
            $messages[] = 'Account Successfully Created! Please sign in.';
        // SQL query
            $sql = "INSERT INTO customer (firstname, lastname, email, password)
            VALUES (?, ?, ?, ?)";

            // Prepare statement
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt === false) {
                echo mysqli_error($conn);
            }

            //Bind params
            mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $email, $hashed_password);
            
            // Execute SQL
            if (mysqli_stmt_execute($stmt)) {
                $message = 'Account Successfully created. Please sign in';
            } else {
                echo mysqli_stmt_error($stmt);
            }    
            
            
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

        <?php if(!empty($message)): ?>
                <?php foreach($messages as $message): ?>
                    <div class="message">
                        <p class="message-text"><?= $message ?></p>
                    </div>
                <?php endforeach; ?>
           
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