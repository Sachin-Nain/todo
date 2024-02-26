<?php
// Code for displaying errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$some_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['uname'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $inp = file_get_contents(getcwd() . '/Data/Data.json');
    $tempArray = json_decode($inp, true);
    $users = $tempArray["users"];

    foreach ($users as $key => $value) {
        if ($value["username"] == $user_name && $value["password"] == $password && $value["email"] == $email) {
            session_start();
            $_SESSION["loggedin"] = $key;
            $_SESSION["role"] = $value["role"];
            header("Location: /todo/Home.php");
            exit();
        }
    }
    $some_error = true;
}

?>