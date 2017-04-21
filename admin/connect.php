<?php
$db_hostname='mysql.hostinger.ru';
$db_username= 'u944219881_dogs';
$db_password ='rfnzeirf97';
$db_database='u944219881_dogs';

$db_server = mysqli_connect($db_hostname, $db_username,$db_password);
if (!$db_server) die("Unable to connect to MYSQL:" . mysqli_error());
mysqli_select_db($db_server, $db_database)
or die("Unable to select database:".mysqli_error());
$charset = 'SET NAMES utf8'; 
mysqli_query($db_server, $charset); 
?>