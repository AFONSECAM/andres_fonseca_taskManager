//Abrir modal de edición con valores
function showEditModal(task) {
  const modal = new bootstrap.Modal(document.getElementById("editModal"));
  document.getElementById("editTaskId").value = task.id;
  document.getElementById("editTitle").value = task.title;
  document.getElementById("editDescription").value = task.description;
  document.getElementById("editDueDate").value = task.due_date;
  document.getElementById("editPriority").value = task.priority;
  document.getElementById("editCompleted").checked = task.completed == 1;
  modal.show();
}

//Código para confirmar eliminación
document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".delete-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "¿Está seguro?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#dc3545",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  //Código para confirmar cambio de estado
  document.querySelectorAll(".changeStatus-form").forEach((form) => {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      Swal.fire({
        title: "¿Está seguro?",
        text: "Se cambiara el estado de la tarea",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ffc107",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Sí, cambiar",
        cancelButtonText: "Cancelar",
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  const flash = document.body.dataset.flash;
  const flashType = document.body.dataset.flashType;

  if (flash) {
    Swal.fire({
      icon: flashType || "info",
      title: flashType === "success" ? "¡Éxito!" : "Aviso",
      text: flash,
      confirmButtonColor: flashType === "error" ? "#dc3545" : "#198754",
    });
  }
});
