let addnew_Task = document.getElementById("all_tasks");
let edit_Modal = document.getElementById("editModal");
$("#task_added,#task_updated,#error_inImage").hide();

let edits = document.getElementsByClassName("edit");
document
  .getElementById("all_tasks")
  .addEventListener("click", function (event) {
    let target = event.target.id;
    if (target) {
      target = parseInt(target);
      edit_Modal.style.display = "block";

      $.ajax({
        type: "POST",
        url: "controller/Task_details.php",
        data: {
          taskId: target,
        },
        success: function (data) {
          try {
            data = JSON.parse(data);
          } catch (error) {
            console.log(error);
          }

          task_ID.value = data["taskId"];
          titleEdit.value = data["taskTitle"];
          descEdit.value = data["taskDesc"];
          taskImage.value = data["taskImage"];
        },
        error: function (err) {
          alert(err);
        },
      });
    }
  });

$("#task_form,#task_update_form").submit(function (e) {
  e.preventDefault();
  var formData = new FormData(this);
  let isTaskUpdated = 0;
  for (var [key, value] of formData.entries()) {
    if (key == "task_ID") {
      $("#editModal").modal("hide");
      document
        .getElementById(`${value}`)
        .parentElement.parentElement.parentElement.remove();
      isTaskUpdated = 1;
    }
  }

  $.ajax({
    url: "controller/Add_Update_Task.php",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (data) {
      if (data == "0") {
        $("#error_inImage").toggle();
      } else {
        let title = formData.get("title"),
          desc = formData.get("desc");
        data = JSON.parse(data);
        let newTask = `
            <div class="col" style="flex: 0;padding: 0 !important;">
              <div class="card my-4" style="width: 330px;">
                <img
                  src="/todo/images/${data.img}" class="img-fluid rounded-start" alt="task image" style="height:230px;object-fit: fill;"
                />
                <div class="card-body bg-secondary text-white" style="text-align: center;">
                  <h4 class="card-title" style="height: 30px; overflow: auto;">
                    ${title}
                  </h4>
                  <p class="card-text" style="height: 100px;">
                    ${desc}
                  </p>
                  <p class="card-text">
                    <small class="text-muted" style="color: white !important;">
                      <b>Updated :- </b>${data.time}
                    </small>
                  </p>
                  <button
                    type="button" class="btn btn-dark edit" data-bs-toggle="modal" data-bs-target="#editModal"
                    id="${data.taskID}">
                    Edit
                  </button>
                </div>
              </div>
            </div>
        `;
        addnew_Task.insertAdjacentHTML("afterbegin", newTask);
        if (isTaskUpdated == 1) {
          $("#task_updated").toggle();
        } else {
          $("#task_added").toggle();
        }
      }
    },
    error: function (err) {
      alert(err);
    },
  });
  this.reset();
});
