<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'note_project';
$db = mysqli_connect($servername, $username, $password, $dbname);
if (!$db){
    die('connection failed:' . mysqli_connect_error());
}

echo 'connection success';