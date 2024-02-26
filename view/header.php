<?php
session_start();
$loggedIN_user = false;

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
  $loggedIN_user = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="resources/bootstrap.min.css" media="all" type="text/css" rel="stylesheet" />
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
  <style>
    @font-face {
      font-family: myFirstFont;
      src: url(resources/my_font.ttf);
    }

    * {
      font-family: myFirstFont;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/todo/Login.php">TODO</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/todo/Home.php">Home</a>
          </li>
        </ul>
        <?php if ($loggedIN_user) { ?>
          <a class="nav-link header-button" href="/todo/Login.php">Login</a>
          <a class="nav-link header-button" href="/todo/Signup.php">Signup</a>
        <?php } ?>
        <?php if (!$loggedIN_user) { ?>
          <a class="nav-link header-button" href="/todo/Logout.php">LogOut</a>
        <?php } ?>
      </div>
    </div>
  </nav>