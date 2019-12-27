<?php
// Check logged.
if (isset($_COOKIE[session_name()])) session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== TRUE) {
  header("location: index.php");
  exit;
}

// Exit user.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["exit"])) {
  // Unset all variables.
  session_unset();
  session_destroy();
  header("location: index.php");
  exit;
}

include_once "welcome.html";