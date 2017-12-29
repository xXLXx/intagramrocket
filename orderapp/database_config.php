<?php

$_HOST     = 'localhost';
$_USER_NAME= 'instag8_orderapp';
$_PASSWORD = 'esfera@123';
$_DATABASE = 'instag8_orderapp';
$newCon=mysqli_connect($_HOST, $_USER_NAME,$_PASSWORD,$_DATABASE);
if(mysqli_connect_errno())
{
	echo "connection failed";
}

?>