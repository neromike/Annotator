<?php
if (isset($_COOKIE["user"])) {
	$user = $_COOKIE["user"];
} else {
	header( 'Location: login.php' ) ;
}
?>