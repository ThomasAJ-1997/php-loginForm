<?php 

require 'functions/connection.php';

$errors = [];

$token = $_POST['token'];

$token_hash = hash("sha256", $token);

$conn = dbConnection();

$sql = "SELECT * FROM customer 
        WHERE reset_token_hash = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

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

  

     //////////////////////////////////////////////////////////////////////////////
     // UPDATE DATABASE

     $sql = "UPDATE customer 
             SET password = ?, 
                 reset_token_hash = NULL, 
                 reset_token_expires_at = NULL
            WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $hashed_password, $user['id']);

    $stmt->execute();

    echo "Password updated. You can now sign in.";
?>

<?php require 'includes/header.php'; ?>


<div class="login-box">
    <header>Successfully reset password</header>
    <a href="login.php">Back to login</a>
</div>

<?php require 'includes/footer.php'; ?>