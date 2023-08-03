<?php
$mysqli = new mysqli('localhost', 'root', 'Renegade@007');
if ($mysqli->connect_error) {
    die('Connection Error: ' . $mysqli->connect_error);
}
echo 'Connected successfully to MySQL!';
$mysqli->close();
?>
