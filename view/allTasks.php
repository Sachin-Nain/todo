<?php

$inp = file_get_contents(getcwd() . '/Data/Data.json');
$tempArray = json_decode($inp, true);
$tasks = $tempArray["tasks"];
$users = $tempArray["users"];

foreach ($tasks as $task) {
    if ($task["taskStatus"] == 1) {

        if (strlen($task["taskDetails"]) > 120) {
            $details = mb_strimwidth($task["taskDetails"], 0, 110);
            $details .= '<a href="#" style="text-decoration: none;color: black;"> ... Read more</a>';
        } else {
            $details = $task["taskDetails"];
        }

        $userName = $users[$task["uId"]]["username"];
        
        if ($_SESSION["role"] == "admin" || $task["uId"] == $_SESSION["loggedin"]) { ?>
            <div class="col" style="flex: 0;padding: 0 !important;">
                <div class="card my-4" style="width: 330px;">
                    <img src="/todo/images/<?php echo $task["taskImage"]; ?>" class="img-fluid rounded-start" alt="task image"
                        style="height:230px;object-fit: fill;">
                    <div class="card-body bg-secondary text-white" style="text-align: center;">
                        <h4 class="card-title" style="height: 30px; overflow: auto;">
                            <?php echo ucfirst($task["taskName"]); ?>
                        </h4>
                        <p class="card-text" style="height: 100px;">
                            <?php echo $details; ?>
                        </p>
                        <?php if ($_SESSION["role"] == "user") { ?>
                            <p class="card-text"><small class="text-muted" style="color: white !important"><b>Updated :- </b>
                                    <?php echo $task["updateTime"]; ?>
                                </small></p>
                            <button type="button" class="btn btn-dark edit" data-bs-toggle="modal" data-bs-target="#editModal"
                                id="<?php echo $task["taskId"]; ?>">Edit</button>
                        <?php } else { ?>
                            <p class="card-text"><small class="text-muted" style="color: white !important"><b>Created by :- </b>
                                    <?php echo ucfirst($userName); ?>
                                </small></p>
                            <button type="button" class="btn btn-dark delete" data-bs-toggle="modal" data-bs-target="#deleteModal"
                                id="<?php echo $task["taskId"]; ?>">Delete</button>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php }
    }
}
?>