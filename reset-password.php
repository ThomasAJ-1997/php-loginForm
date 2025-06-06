<?php
require 'functions/connection.php';

$token = $_GET['token'];

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

?>

<?php require 'includes/header.php'; ?>

<div class="login-box">
    <form action="process-reset-password.php" method="post">
        <div class="login-header">
            <header>Create New Password</header>
        </div>

        <div class="input-box">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        </div>

        <div class="input-box">
            <input type="password" name="password" class="input-field" placeholder="New Password" autocomplete="off">
        </div>


        <div class="input-box">
            <input type="password" name="password_confirmation" class="input-field" placeholder="Confirm Password" autocomplete="off">
        </div>


        <div class="input-submit">
            <button class="submit-btn" id="submit"></button>
            <label for="submit">Submit</label>
        </div>


<?php require 'includes/footer.php'; ?>

