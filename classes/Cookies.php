<?php

/**
 * Class Cookies
 *
 * Represents a utility to manage user cookie preferences for email
 * and remember-me functionality.
 */
class Cookies
{

    public string $remember;
    public string $email;

    /**
     * Constructor method to initialize the object with provided parameters.
     *
     * @param  mixed  $remember  Indicates whether to remember the user or not.
     * @param  mixed  $email  The email address of the user.
     * @return void
     */
    public function __construct($remember, $email)
    {
        $this->remember = $remember;
        $this->email = $email;
    }

    /**
     * Handles setting or unsetting cookies based on the provided parameters.
     *
     * @param  mixed  $remember  The value indicating whether to remember the user.
     * @param  string  $email  The email address to be associated with the remember functionality.
     *
     * @return mixed Returns the updated value of the remember parameter.
     */
    public function checkCookies($remember, $email)
    {

        if (isset($_POST['remember'])) {
            $remember = $_POST['remember'];
            setcookie("remember_email", $email, time() + 36000*24*365);
            setcookie("remember", $remember, time() + 36000*24*365);

        } else {
            setcookie("remember_email", $email, time() - 360000 );setcookie("remember", $remember, time() - 3600);
        }

        return $remember;
    }

}