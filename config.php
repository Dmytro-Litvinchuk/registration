<?php
$username = "root";
$password = "example";
try {
  $pdo = new PDO('mysql:host=localhost;dbname=registration', $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'ERROR: ' . $e->getMessage();
}

