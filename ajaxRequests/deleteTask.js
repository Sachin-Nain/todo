$("#task_deleted").hide();
document.getElementById("all_tasks").addEventListener("click", function (event) {
  let target = event.target.id;
  if (target) {
    target = parseInt(target);
    console.log(target);
    task_ID.value = target;
  }
});

$("#delete_task").submit(function (e) {
  e.preventDefault();

  var formData = new FormData(this);
  for (var [key, value] of formData.entries()) {
    if (key == "task_ID") {
      $("#deleteModal").modal("hide");
      target = value;
    }
  }

  $.ajax({
    type: "POST",
    url: "controller/Delete_task.php",
    data: {
      task_ID: target,
    },
    success: function (data) {
      target = ""+target;
      document.getElementById(`${target}`).parentElement.parentElement.parentElement.remove();
      $("#task_deleted").toggle();
      console.log(data);
    },
    error: function (err) {
      alert(err);
    },
  });
});
