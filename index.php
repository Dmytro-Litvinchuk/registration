<?php

// Check logged user;
if (isset($_COOKIE[session_name()])) {
  session_start();
}
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === TRUE) {
  header("location: welcome.php");
  exit;
}

require_once "config.php";
require_once "Validator.php";

// Registration.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["registration"])) {
  $flds = ["fname", "lname", "u-email", "u-password"];
  $validation = new RegisterValidator($_POST, $flds);
  $errors = $validation->validateForm();
  if (empty($errors)) {
    $sql = "SELECT id FROM reg WHERE email = :uemail";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":uemail", $param_uemail, PDO::PARAM_STR);
      // Set parameters
      $param_uemail = $validation->getValue("u-email");

      if ($stmt->execute()) {
        if ($stmt->rowCount() == 1) {
          $errors["u-email"] = "This email is already taken";
        }
      }
      else {
        echo "Ooops! Something went wrong. Please try again later";
      }
    }
    unset($stmt);
  }
  if (empty($errors)) {
    $sql = "INSERT INTO reg (fname, lname, email, password) VALUES (:fname, :lname, :uemail, :upassword)";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":fname", $param_fname, PDO::PARAM_STR);
      $stmt->bindParam(":lname", $param_lname, PDO::PARAM_STR);
      $stmt->bindParam(":uemail", $param_uemail, PDO::PARAM_STR);
      $stmt->bindParam(":upassword", $param_upassword, PDO::PARAM_STR);

      // Set parameter
      $param_fname = $validation->getValue("fname");
      $param_lname = $validation->getValue("lname");
      $param_uemail = $validation->getValue("u-email");
      $param_upassword = password_hash($validation->getValue("u-password"), PASSWORD_DEFAULT);

      if ($stmt->execute()) {
        // Message in template.
        $cong = "Congratulations!";
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

// Log in.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {

  // Variable to redirect to the form log in;
  $log = "";

  $fld = ["l-email", "l-password"];
  // Used class LoginValidator.
  $valid = new LoginValidator($_POST, $fld);
  $errors = $valid->validateForm();

  if (empty($errors)) {

    $sql = "SELECT id, fname, lname, password FROM reg WHERE email = :email";

    if ($stmt = $pdo->prepare($sql)) {

      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      $param_email = $valid->getValue("l-email");

      if ($stmt->execute()) {

        if ($stmt->rowCount() == 1) {
          if ($row = $stmt->fetch()) {
            $id = $row["id"];
            $fname = $row["fname"];
            $lname = $row["lname"];
            $hashed_password = $row["password"];

            // Verification password;
            if (password_verify($valid->getValue("l-password"), $hashed_password)) {
              session_start();
              $_SESSION["loggedin"] = TRUE;
              $_SESSION["id"] = $id;
              $_SESSION["fname"] = $fname;
              $_SESSION["lname"] = $lname;

              header("location: welcome.php");
            }
            else {
              $errors["l-password"] = "The password not valid";
            }
          }
        }
        else {
          $errors["l-errors"] = "No account found with that email";
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

include "template.html";