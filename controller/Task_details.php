<?php

$inp = file_get_contents('../Data/Data.json');
$tempArray = json_decode($inp, true);
$tasks = $tempArray["tasks"];
$taskId = $_POST["taskId"];

foreach ($tasks as $task) {
    if ($task["taskId"] == $taskId) {
        $task_data = array("taskId" => $taskId, "taskTitle" => $task["taskName"], "taskDesc" => $task["taskDetails"], "taskImage" => $task["taskImage"]);
        echo json_encode($task_data);
    }
}

?>