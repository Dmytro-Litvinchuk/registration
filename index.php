<?php

// Check logged user;
if (isset($_COOKIE[session_name()])) session_start();
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE) {
  header("location: welcome.php");
  exit;
}

require_once "config.php";

$fname_err = $lname_err = $uemail_err = $upassword_err = $email_err = $password_err = "";

/**
 * Registration.
 */
if (isset($_POST["registration"])) {

  // Validate email.
  if (empty(trim($_POST["u-email"]))) {
    $uemail_err = "You didn't enter email";
  }
  else {
    $sql = "SELECT id FROM reg WHERE email = :uemail";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":uemail", $param_uemail, PDO::PARAM_STR);
      // Set parameters
      $param_uemail = trim($_POST["u-email"]);

      if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $uemail_err = "This email is already taken";
        }
        else {
          $uemail = trim($_POST["u-email"]);
        }
      }
      else {
        echo "Ooops! Something went wrong. Please try again later";
      }
    }
    unset($stmt);
  }

  // Validate first name.
  if (empty(trim($_POST["fname"]))) {
    $fname_err = "You didn't enter first name";
  }
  else {
    $fname = trim($_POST["fname"]);
  }

  // Validate last name.
  if (empty(trim($_POST["lname"]))) {
    $lname_err = "You didn't enter last name";
  }
  else {
    $lname = trim($_POST["lname"]);
  }

  // Validate password.
  if (empty(trim($_POST["u-password"]))) {
    $upassword_err = "You didn't enter password";
  }
  else {
    $upassword = trim($_POST["u-password"]);
  }

  // Check erors.
  if (empty($uemail_err) && empty($upassword_err) && empty($fname_err) && empty($lname_err)) {
    $sql = "INSERT INTO reg (fname, lname, email, password) VALUES (:fname, :lname, :uemail, :upassword)";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
      $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
      $stmt->bindParam(":uemail", $param_uemail, PDO::PARAM_STR);
      $stmt->bindParam(":upassword", $param_upassword, PDO::PARAM_STR);

      // Set parameter
      $param_fname = $fname;
      $param_lname = $lname;
      $param_uemail = $uemail;
      $param_upassword = password_hash($upassword, PASSWORD_DEFAULT);

      if ($stmt->execute()) {
        echo "Congratulations!";
        // Variable to redirect to the form log in;
        $log = "";
      }
      else {
        echo "Something went wrong. Please try again later";
      }
    }
    unset($stmt);
  }
  unset($pdo);
}

/**
 * Authorization
 */
if (isset($_POST["login"])) {

  // Variable to redirect to the form log in;
  $log = "";
  // Check log.
  if (empty(trim($_POST["l-email"]))) {
    $email_err = "You didn't enter email";
  }
  else {
    $email = trim($_POST["l-email"]);
  }

  // Check pass.
  if (empty(trim($_POST["l-password"]))) {
    $password_err = "You didn't enter password";
  }
  else {
    $password = trim($_POST["l-password"]);
  }

  if (empty($password_err) && empty($email_err)) {

    $sql = "SELECT id, fname, lname, password FROM reg WHERE email = :email";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      $param_email = $email;

      if ($stmt->execute()) {

        if ($stmt->rowCount() == 1) {
          if ($row = $stmt->fetch()) {
            $id = $row["id"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $hashed_password = $row["password"];

            // Verification password;
            if (password_verify($password, $hashed_password)) {
              session_start();

              $_SESSION["loggedin"] = TRUE;
              $_SESSION["id"] = $id;
              $_SESSION["fname"] = $fname;
              $_SESSION["lname"] = $lname;

              header("location: welcome.php");

            }
            else {
              $password_err = "The password not valid";
            }
          }
        }
        else {
          $email_err = "No account found with that email";
        }
      }
      else {
        echo "Oops! Something wrong.";
      }
    }
    // Close statement;
    unset($stmt);
  }
  // Close connect.
  unset($pdo);
}

include_once "template.html";

