<?php 
require 'connection.php';

$email = $_POST['email'];

$token = bin2hex(random_bytes(16));

$token_hash = hash("sha256", $token);

$token_expiry = date("Y-m-d H:i:s", time() + 60 * 30);

$conn = dbConnection();

$sql = "UPDATE customer 
SET reset_token_hash = ?,
    reset_token_expires_at = ?
    WHERE email = ?";

$stmt = mysqli_prepare($conn, $sql);

 if ($stmt === false) {
    echo mysqli_error($conn);
}

mysqli_stmt_bind_param($stmt, "sss", $token_hash, $token_expiry, $email);

if (mysqli_stmt_execute($stmt)) {

    if (mysqli_affected_rows($conn)) {
        $mail = require 'send-mail.php';
        $mail->setFrom("from@example.com", "Mailer");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = <<<END

        Click <a href="http://localhost:8888/phpbegin/LoginForm/reset-password.php?token=$token">To reset your password</a>

        END;

        try {

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    }
  
} else {
    echo mysqli_stmt_error($stmt);
}    

echo 'Message sent, please check your inbox';