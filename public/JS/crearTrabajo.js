//agregar empleado
let btnCrear = document.querySelector("#crearTrabajo");
btnCrear.addEventListener("click", () => {
  Swal.fire({
    title: '<span class="text-success fw-bold">Crear usuario</span>',
    html: `
    <form action="" method="post" id="formAgregarEmpleado">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de Actividad</label>
        <input type="text" class="form-control" id="nombreActividad" name="nombreActividad" required>
    </div>
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha Limite</label>
        <input type="date" class="form-control" id="fechaLimite" name="fechaLimite" required>
    </div>
    <div class="mb-3">
        <label for="nombre" class="form-label">Aprendiz</label>
        <input type="text" class="form-control" id="aprendiz" name="aprendiz" required>
    </div>
</form>`,
    showCancelButton: true,
    confirmButtonText: "Agregar",
    cancelButtonText: "Cancelar",
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger",
    },
    preConfirm: () => {
      const form = document.getElementById("formAgregarEmpleado");
      const formData = new FormData(form);
      return $.ajax({
        url: "../CONTROLLER/crearTrabajo.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
      }).then((respuesta) => {
        if (!respuesta.success) {
          Swal.showValidationMessage(respuesta.message);
        }
        return respuesta;
      });
    },
  }).then((resultado) => {
    if (resultado.isConfirmed && resultado.value.success) {
      Swal.fire("Exito", resultado.value.message, "success").then(() => {
        location.reload();
      });
    }
  });
});
