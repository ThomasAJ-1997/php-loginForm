<?php
/**
 * Summary of validateAccount
 * @param object $conn provides the connect to the database.
 * @param string $firstname user input for firstname - requires to be filled and not numeric characters.
 * @param string $lastname user input for lastname - requires to be filled and not numeric characters.
 * @param string $email user input for email - requires preg_match to be satisfied and checks if email already exists. 
 * @param string $password user input for password - hashed password, requires more than eight characters and preg_match to be satisifed (1 digit / 1 Capital / 1 Lower / 1 Symbol)
 * @return array $errors - Returns the errors array to inform the user about data validation. 
 */
function validateAccount($conn, $firstname, $lastname, $email, $password) {
    
    $errors = [];
        if (empty($firstname) || empty($lastname)) {
        $errors[] = "Name field's are required";
    }
 
    if (is_numeric($firstname) || is_numeric($lastname)) {
        $errors[] = "Name doesn't allow numeric characters";
    }

    $sql = "SELECT * FROM customer WHERE (email='$email');";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if($email==isset($row['email'])) {
            $errors[] = 'Email already exists';
        }
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*[ !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"])[0-9A-Za-z !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"]{8,50}$/", $password)) {
        $errors[] = 'Invalid Password';
        $errors[] = 'Make sure password contains: 1 digit, 1 capital, 1 lower and 1 special character';
        // Checks for:
        // 1 digit / 1 Capital / 1 lower / 1 special  

    }

    if (strlen(trim($password)) < 8) {
        $errors[] = 'Password needs to be more than eight characters';
        
    }

    if (password_verify($password, $hashed_password)) {
        $messages[] = 'Valid Password';
    } else {
        $errors[] = 'Invalid Password';
    
    }

    if (!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $email)) {
        $errors[] = 'Invalid Email Address';
    };

    return $errors;
}

function validateVerifiedPassword($password, $user) {
    $errors = [];

        if(password_verify($password, $user['password'])) {
            
            session_regenerate_id();
            $_SESSION['account_loggedin'] = TRUE;
            $_SESSION['account_name'] = $user['firstname'];
            $_SESSION['account_id'] = $user['id'];
            
            header('location: dashboard.php');
            exit;
        } else {
            $errors[] = 'Email and/or password is invalid, please try again';
    } 

    return $errors;
}

