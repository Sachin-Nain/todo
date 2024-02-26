<?php
// Code for displaying errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$no_error = false;
$same_email = false;
$password_error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['uname'];
    $password = $_POST['password'];
    $cpossword = $_POST['cpassword'];
    $email = $_POST['email'];

    $inp = file_get_contents(getcwd() . '/Data/Data.json');
    $tempArray = json_decode($inp, true);
    $users = $tempArray["users"];

    // checking if the user's email already exists or not.
    foreach ($users as $key => $value) {
        if ($value["email"] == $email) {
            $same_email = true;
            break;
        }
    }

    if (!$same_email && $password == $cpossword) {
        $no_error = true;

        $new_user = array("username" => "$user_name", "password" => "$password", "email" => "$email", "role" => "user");
        $user_id = $user_name . time();
        $users["$user_id"] = $new_user;
        $tasks = $tempArray["tasks"];
        $newUserTasks = json_encode($tasks);
        $updated_data = array("users" => $users, "tasks" => $tasks);
        $updated_data = json_encode($updated_data);
        file_put_contents("Data/Data.json", $updated_data);
    } else {
        $password_error = true;
    }
}

?>