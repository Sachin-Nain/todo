<?php
// Code for displaying errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$inp = file_get_contents('../Data/Data.json');
$tempArray = json_decode($inp, true);
$tasks = $tempArray["tasks"];
$task_ID = $_POST['task_ID'];
$count = 0;

foreach ($tasks as $key => $value) {
    if ($value["taskId"] == $task_ID) {
        $updated_task = $value;
        $updated_task["taskStatus"] = 0;
        break;
    }
    $count++;
}
array_splice($tasks, $count, 1);
array_push($tasks, $updated_task);
$all_task = json_encode($tasks);
$users = $tempArray["users"];
$newUser = json_encode($users);
$updated_data = array("users" => $users, "tasks" => $tasks);
$updated_data = json_encode($updated_data);
file_put_contents("../Data/Data.json", $updated_data);

?>