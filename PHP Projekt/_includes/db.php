<?php
define("DB_HOST", 'localhost');
define("DB", 'EXAMPLE');
define("DB_USER", 'EXAMPLE');
define("DB_PASS", 'EXAMPLE');
define("CHARSET", 'utf8mb4');

function dbConnect()
{
    $dsn = "mysql:host=".DB_HOST.";dbname=".DB.";charset=".CHARSET;

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    return new PDO($dsn, DB_USER, DB_PASS, $options);
}