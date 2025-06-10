<?php

/**
 * Provides a method to establish a connection to a MySQL database using PDO.
 */
class Connect
{
    /**
     * Establishes a database connection using the specified credentials and returns
     * the PDO instance. If a connection error occurs, an exception message is displayed, and the script exits.
     *
     * @return PDO Returns a PDO instance representing the database connection.
     */
    public function dbConnection(): PDO
    {
        $db_host = 'localhost';
        $db_name = 'login_sys';
        $db_user = 'tom_admin';
        $db_pass = 'BpZkYolbGK3Gc!LP';

        $dsn = 'mysql:host=' . $db_host . ";dbname=" . $db_name . ";charset=utf8";

        $conn = new PDO($dsn, $db_user, $db_pass);

        try {
            $db = new PDO($dsn, $db_user, $db_pass);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $db;
        
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit;
        } 
    }
}
