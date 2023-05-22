<?php require_once('config.php'); ?>
<?php 

session_start();

session_destroy();
$baseUrl = BASE_URL;
header("Location: $baseUrl./index.php");

?>