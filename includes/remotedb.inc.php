<?php
try
{
  // Connect to the MySQL server and select the pos database
	$pdo = new PDO('mysql:host=198.54.124.235;dbname=veroyori_pos', 'veroyori_veroyor', 'veroyori2017');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.'.$e;
  include 'error.html.php';
  exit();
}
