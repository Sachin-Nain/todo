<?php session_start(); ?>
<?php include("./view/header.php") ?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<?php if ($_SESSION["role"] == "user") { ?>
    <!--Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit your task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="task_update_form">
                        <div class="mb-3" style="display:none;">
                            <label for="task_ID" class="form-label">Task ID</label>
                            <input type="text" class="form-control" id="task_ID" name="task_ID" aria-describedby="emailHelp"
                                readonly>
                        </div>
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="title"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3" style="display:none;">
                            <label for="taskImage" class="form-label">Task Image</label>
                            <input type="text" class="form-control" id="taskImage" name="taskImage"
                                aria-describedby="emailHelp">
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Leave a comment here" name="desc" id="descEdit"
                                style="height: 100px"></textarea>
                            <label for="desc">Description</label>
                        </div>
                        <div class="mb-3">
                            <input type="file" accept="image/*" name="newfileToUpload" id="newfileToUpload">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-success alert-dismissible fade show" role="alert" id="task_added">
        <strong>Congratulations,</strong> Your task is added successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="task_updated">
        <strong>Congratulations,</strong> Your task is updated successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error_inImage">
        <strong>Oops,</strong> Your uploaded file is not a valid image format. Please choose the right one.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <div class="my-4 mx-4">
        <form id="task_form" method="post" enctype="multipart/form-data"
            style="display: grid; grid-template-columns: 30% 50% auto;grid-gap: 2rem; align-items: center;">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" name="desc" id="desc"
                    style="height: 90px"></textarea>
                <label for="desc">Description</label>
            </div>
            <div style="text-align: center;">
                <button type="submit" class="btn btn-primary" style="width: 25%;">Save</button>
            </div>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown"
                    aria-expanded="false" onclick="showOptions()">
                    Upload File
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                    <li><button class="dropdown-item" type="button" onclick="uploadFromDevice()">From Device</button>
                    </li>
                    <li><button class="dropdown-item" type="button" onclick="uploadFromLink()">From link</button></li>
                </ul>
            </div>
            <div>
                <div style="display: flex; margin: auto;">
                    <div class="input-group" id="imglink" style="display: none; margin: auto;">
                        <span class="input-group-text" id="basic-addon3">https://</span>
                        <input type="text" class="form-control" id="imgurl" name="imgurl" aria-describedby="basic-addon3">
                    </div>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
                        style="display: none; margin-left: 5%;" id="uploadbtn" onclick="preivewImg()">
                        Upload
                    </button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Uploaded Image</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body" style="height: 400px;">
                                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/Sachin-Tendulkar_%28cropped%29.jpg"
                                        class="rounded mx-auto d-block" alt="task image"
                                        style="width: 90%; height: 100%; object-fit: fill;" id="modalImg" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="imgfile" style="display: none; margin: auto;">
                    <input type="file" accept="image/*" name="fileToUpload" id="fileToUpload">
                </div>
            </div>
        </form>
    </div>

    <div class="bg-secondary my-2 py-2 text-white text-center">
        <h3>List of your tasks</h3>
    </div>
<?php } else { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="task_deleted">
        <strong>Congratulations,</strong> Your task is deleted successfully.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <!--Delete Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete this task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="delete_task">
                        <div class="mb-3" style="display:none;">
                            <label for="task_ID" class="form-label">Task ID</label>
                            <input type="text" class="form-control" id="task_ID" name="task_ID" aria-describedby="emailHelp"
                                readonly>
                        </div>
                        <p>Are you sure, You want to delete this task.</p>
                        <button type="submit" class="btn btn-primary">Delete Task</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container-fluid">
    <div class="row" id="all_tasks" style="display: flex; justify-content: space-evenly;">
        <?php include "./view/allTasks.php" ?>
    </div>
</div>

<script type="text/javascript" src="ajaxRequests/add_updateTask.js"></script>
<script type="text/javascript" src="ajaxRequests/deleteTask.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script>

<script>
    function showOptions() {
        document.getElementById("imglink").style.display = "none";
        document.getElementById("imgfile").style.display = "none";
        document.getElementById("uploadbtn").style.display = "none";
    }
    function uploadFromDevice() {
        document.getElementById("imgfile").style.display = "block";
    }
    function uploadFromLink() {
        document.getElementById("imglink").style.display = "flex";
        document.getElementById("uploadbtn").style.display = "flex";
    }
    function preivewImg() {
        let imageLink = document.getElementById("imgurl").value;
        document.getElementById("modalImg").src = `https://${imageLink}`;
    }

</script>

</body>

</html>