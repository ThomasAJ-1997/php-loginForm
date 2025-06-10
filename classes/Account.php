<?php

/**
 * The Account class represents a user account and provides functionalities for
 * registering, validating, and managing user credentials.
 */
class Account
{

    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public array $errors;
    public array $messages;

    /**
     * Constructor to initialize the class with user information and default values.
     *
     * @param  string  $firstname  The first name of the user.
     * @param  string  $lastname  The last name of the user.
     * @param  string  $email  The email address of the user.
     * @param  string  $password  The password for the user account.
     * @return void
     */
    public function __construct(string $firstname, string $lastname, string $email, string $password)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
        $this->errors = [];
        $this->messages = [];
    }

    /**
     * Registers a new user account by inserting user details into the database.
     *
     * @param  PDO  $conn  The database connection instance.
     * @param  string  $firstname  The user's first name.
     * @param  string  $lastname  The user's last name.
     * @param  string  $email  The user's email address.
     * @param  string  $hashed_password  The hashed password for the user's account.
     * @return void
     */
    public function registerAccount(PDO $conn, $firstname, $lastname, $email, $hashed_password): void
    {
        // SQL query
        $sql = "INSERT INTO customer (firstname, lastname, email, password)
            VALUES (:firstname, :lastname, :email, :password)";

        // Prepare statement
        $stmt = $conn->prepare($sql);

        //Bind params

        $stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashed_password, PDO::PARAM_STR);
        $stmt->execute();
    }

    /**
     * Retrieves account details from the database based on the provided email.
     *
     * @param  PDO  $conn  The database connection object.
     * @param  string  $email  The email address of the account to retrieve.
     * @return array|false  The account details if found, or false if not found.
     */
    public function getAccountEmail(PDO $conn, string $email): bool|array
    {
        $user = "SELECT * FROM customer
             WHERE email = :email";

        $stmt = $conn->prepare($user);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * Validates account details including firstname, lastname, email, and password.
     * Performs checks such as required fields, length validation, email format, password strength,
     * and ensures email uniqueness in the database.
     *
     * @param  PDO  $conn  The PDO database connection object.
     * @param  string  $firstname  The first name of the user to be validated.
     * @param  string  $lastname  The last name of the user to be validated.
     * @param  string  $email  The email address of the user to be validated.
     * @param  string  $password  The password of the user to be validated.
     * @return array              An array of error messages, if any validation fails.
     */
    public function validateAccount(PDO $conn, $firstname, $lastname, $email, $password): array
    {
        $this->errors = [];

        if (empty($firstname) || empty($lastname)) {
            $this->errors[] = "First name and last name are required.";
        }

        if (strlen($firstname) > 50 || strlen($lastname) > 50) {
            $this->errors[] = "First name and last name must be less than 50 characters.";
        }

        if (is_numeric($firstname) || is_numeric($lastname)) {
            $this->errors[] = "Name doesn't allow numeric characters";
        }

        $sql = "SELECT * FROM customer WHERE email = :email;";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $existingEmail = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingEmail) {
            $this->errors[] = "Email already registered";
        }

        if (!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $email)) {
            $this->errors[] = 'Invalid Email Address';
        };

        $hashed_password = password_hash($this->password, PASSWORD_DEFAULT);

        if (!preg_match("/^(?=.*\d)(?=.*[A-Za-z])(?=.*[A-Z])(?=.*[a-z])(?=.*[ !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"])[0-9A-Za-z !#$%&'\(\) * +,-.\/[\\] ^ _`{|}~\"]{8,50}$/", $password)) {
            $this->errors[] = 'Invalid Password';
            $this->errors[] = 'Make sure password contains: 1 digit, 1 capital, 1 lower and 1 special character';
            // Checks for:
            // 1 digit / 1 Capital / 1 lower / 1 special

        }

        if (strlen(trim($password)) < 8) {
            $this->errors[] = 'Password needs to be more than eight characters';

        }

        if (password_verify($password, $hashed_password)) {
            $messages[] = 'Valid Password';
        } else {
            $this->errors[] = 'Invalid Password';

        }

        if (!preg_match("/^[^@]+@[^@]+\.[a-z]{2,6}$/i", $email)) {
            $this->errors[] = 'Invalid Email Address';
        };

        return $this->errors;
    }

    /**
     * Validates a user's password and initializes a session if the password is correct.
     *
     * @param  string  $password  The password provided by the user for verification.
     * @param  array  $user  The user's data, including the stored hashed password and other account details.
     * @return array  An array of error messages if the validation fails, or an empty array on success.
     */
    public function validateVerifiedPassword($password, $user): array
    {
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











}