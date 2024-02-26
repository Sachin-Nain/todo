<?php
// Code for displaying errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] != true) {
    header("location: Login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $desc = $_POST['desc'];
    $imgurl = isset($_POST['imgurl']) ? $_POST['imgurl'] : "";
    $img = isset($_POST['taskImage']) ? $_POST['taskImage'] : "";
    $task_id = isset($_POST['task_ID']) ? $_POST['task_ID'] : "";
    $task_id = (int) $task_id;
    $previous_img = 0;

    // Image uploaded
    if (!$task_id) {
        if (!$imgurl) {
            $info = pathinfo($_FILES['fileToUpload']['name']);
            $ext = isset($info['extension']) ? $info['extension'] : ""; // get the extension of the file
            if ($ext) {
                $newname = time() . '.' . $ext;
                $target_file = '../images/' . $newname;

                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if (
                    $check == false || (
                        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif"
                    )
                ) {
                    echo "0";
                    return;
                }
                move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
            } else {
                $newname = "default_taskImage.png";
            }
        } else {
            $url = 'https://' . $imgurl;
            $newname = time() . '.png';
            $img = '../images/' . $newname;
            // Function to write image into file 
            file_put_contents($img, file_get_contents($url));
        }
    } else {
        $info = pathinfo($_FILES['newfileToUpload']['name']);
        if ($info["basename"]) {
            $ext = $info['extension'];
            $newname = time() . '.' . $ext;
            $target_file = '../images/' . $newname;
            move_uploaded_file($_FILES["newfileToUpload"]["tmp_name"], $target_file);
        } else {
            $newname = $img;
            $previous_img = 1;
        }
    }

    $inp = file_get_contents('../Data/Data.json');
    $tempArray = json_decode($inp, true);
    $tasks = $tempArray["tasks"];

    $date = date_default_timezone_set('Asia/Kolkata');
    $today = date("F j, Y, g:i a T");
    $count = 0;

    if ($task_id) {
        foreach ($tasks as $key => $value) {
            if ($value["taskId"] == $task_id) {
                $created_time = $value["createdTime"];
                if (!$previous_img && $value["taskImage"] != "default_taskImage.png") {
                    unlink("../images/" . $value["taskImage"]);
                }
                break;
            }
            $count++;
        }
        array_splice($tasks, $count, 1);
        $new_task = array("uId" => $_SESSION["loggedin"], "taskId" => $task_id, "taskName" => "$title", "taskDetails" => "$desc", "taskImage" => $newname, "taskStatus" => 1, "createdTime" => $created_time, "updateTime" => $today);
    } else {
        $new_task = array("uId" => $_SESSION["loggedin"], "taskId" => time(), "taskName" => "$title", "taskDetails" => "$desc", "taskImage" => $newname, "taskStatus" => 1, "createdTime" => $today, "updateTime" => $today);
    }

    array_unshift($tasks, $new_task);
    $all_task = json_encode($tasks);
    $users = $tempArray["users"];
    $newUser = json_encode($users);
    $updated_data = array("users" => $users, "tasks" => $tasks);
    $updated_data = json_encode($updated_data);
    file_put_contents("../Data/Data.json", $updated_data);

    if (strlen($new_task["taskDetails"]) > 120) {
        $details = mb_strimwidth($new_task["taskDetails"], 0, 110);
        $details .= '<a href="#" style="text-decoration: none;color: black;"> ... Read more</a>';
    } else {
        $details = $new_task["taskDetails"];
    }
    $response = array("img" => $new_task["taskImage"], "time" => $new_task["updateTime"] , "taskID" => $new_task["taskId"]);
    echo json_encode($response);
    return;
} ?>