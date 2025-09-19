<?php
require_once __DIR__ . '/../app/helpers/SQLHandler.php';
require_once __DIR__ . '/config.php';

/**
 * Establish a database connection using configuration parameters.
 */
$CONNECTION = new SQLHandler(
    host: CONFIG::$DATABASE::$DBHOST, 
    dbname: CONFIG::$DATABASE::$DBNAME, 
    username: CONFIG::$DATABASE::$DBUSER, 
    password: CONFIG::$DATABASE::$DBPASSWORD, 
    port: CONFIG::$DATABASE::$DBPORT
);

/**
 * Get the PDO connection or throw an exception if the connection failed.
 */
$tempcursor = $CONNECTION->getConnection();

if ($tempcursor instanceof PDOException) {
    throw $tempcursor;
}