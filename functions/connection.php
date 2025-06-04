<?php


/**
 * Get connection to MySQL Database
 * 
 * @return object Connection to a MySQL server, and returns $conn.
 */

function dbConnection() {
   $db_host = 'localhost';
   $db_name = 'login_sys';
   $db_user = 'tom_admin';
   $db_pass = 'BpZkYolbGK3Gc!LP';

   $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
   if (mysqli_connect_error()) {
       echo 'Database connection failed';
       echo mysqli_connect_error();
       exit;
   } 

   return $conn;
}