<?php
session_start();
if (isset($_SESSION["user"])) {
	$user = $_SESSION["user"];
	$role = $_SESSION["role"];
} else {
	header( 'Location: login.php' ) ;
}
?>