<?php
if (isset($_COOKIE[session_name()])) session_start();
// Check logged.
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE){
  header("location: index.php");
  exit;
}

// Exit user.
if (isset($_POST["exit"])) {
  unset($_SESSION["loggedin"]);
  unset($_SESSION["id"]);
  unset($_SESSION["fname"]);
  unset($_SESSION["lname"]);

  session_destroy();
  header("location: index.php");
  exit;
}

include_once "welcome.html";