<?php
$usr = 'dolibarrmysql';
$pass = 'changeme';
$host = 'localhost';
$dbname = 'dolibarr';

$db = new mysqli($host, $usr, $pass, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
