<?php

/**
 * Class Token handles operations related to token management, such as
 * retrieving information using a token hash and resetting user tokens.
 */
class Token
{
    /**
     * Fetches customer data based on the provided token hash.
     *
     * @param  PDO  $conn  The database connection object.
     * @param  string  $token_hash  The hash of the reset token to search for.
     * @return array|false The customer data as an associative array, or false if no match is found.
     */
    public function tokenHash($conn, $token_hash)
    {
        $sql = "SELECT * FROM customer 
        WHERE reset_token_hash = :token_hash";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":token_hash", $token_hash, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    }

    /**
     * Resets the token for a specified user by updating the password
     * and clearing the reset token hash and its expiration time in the database.
     *
     * @param  PDO  $conn  The database connection object.
     * @param  string  $hashed_password  The new hashed password for the user.
     * @param  array  $user  An associative array containing user details, including the user ID.
     * @return string A confirmation message indicating the password update was successful.
     */
    public function resetToken($conn, $hashed_password, $user)
    {
        $sql = "UPDATE customer 
             SET password = :password, 
                 reset_token_hash = NULL, 
                 reset_token_expires_at = NULL
            WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(":password", $hashed_password, PDO::PARAM_STR);
        $stmt->bindParam(":id", $user['id'], PDO::PARAM_INT);

        $stmt->execute();

        return "Password updated. You can now sign in.";
    }

}