//agregar empleado
let btnCrear = document.querySelector("#crearTrabajo");
btnCrear.addEventListener("click", async () => {
  const IDinstructor = btnCrear.dataset.id;
  const formDataID = new FormData();
  formDataID.append("IDinstructor", IDinstructor);

  const request = await fetch("../CONTROLLER/listarFichas.php", {
    method: "POST",
    body: formDataID,
  });

  const fichas = await request.json();
  console.log(fichas);

  let opcionesFichas = [];

  fichas.forEach((ficha) => {
    let opcion = `<option value = "${ficha.id}"> ${ficha.codigo} - ${ficha.nombre} </option>`;
    opcionesFichas.push(opcion);
  });

  if (fichas.length == 0) {
    opcionesFichas = "<option disabled selected> Sin fichas </option>";
  }
  const hoy = new Date().toISOString().split("T")[0];

  Swal.fire({
    title: '<span class="text-success fw-bold">Crear trabajo</span>',
    html: `
    <form action="" method="post" id="frmTrabajos">
    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre de Actividad</label>
        <input type="text" class="form-control text-center" id="nombreActividad" name="nombreActividad" placeholder="Ingrese el nombre de la actividad" required>
    </div>
    <div class="mb-3">
  <label for="comments" class="form-label">Descripcion:</label>
  <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese la descripcion de la actividad" rows="5"></textarea>
    </div>
    <div class="row">
        <div class="col-sm-5">
 <div class="mb-3">
        <label for="fecha" class="form-label">Fecha Limite</label>
        <input type="date" class="form-control" min="${hoy}" value="${hoy}" id="fechaLimite" name="fechaLimite" required>
    </div>
        </div>

         <div class="col-sm-7">
<div class="mb-3">
     <label for="ficha" class="form-label">Ficha</label>
        <select class="form-select" id="ficha" name="ficha" ">
           ${opcionesFichas};
        </select>
    </div>
        </div>
    </div>
   
    <input type="hidden" class="form-control" id="IDinstructor" name="IDinstructor" value="${IDinstructor}" required>
</form>`,
    showCancelButton: true,
    confirmButtonText: "Agregar",
    cancelButtonText: "Cancelar",
    customClass: {
      confirmButton: "btn btn-success",
      cancelButton: "btn btn-danger",
    },
    preConfirm: () => {
      const form = document.getElementById("frmTrabajos");
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
      Swal.fire({
        title: "Exito",
        text: resultado.value.message,
        icon: "success",
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
      }).then(() => {
        location.reload();
      });
    }
  });
});
