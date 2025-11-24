function editarTrabajo(IDtrabajo, IDusuario) {
    console.log(IDtrabajo);
    console.log(IDusuario);
  Swal.fire({
    title: `<span class="text-primary fw-bold">Editar trabajo</span>`,
    html: `
                <form method="post" id="frmTrabajos" enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <label class="fw-semibold form-label">Seleccione un archivo para editar la evidencia</label>
                            <input
                                type="file"
                                class="form-control shadow-sm"
                                id="uploadFile"
                                name="uploadFile"
                                accept=".pdf, .docx, .doc, .xlsx, .png, .jpg, .jpeg">
                        </div>
                        <input type="hidden" id="IDtrabajo" name="IDtrabajo" value="${IDtrabajo}" />
                        <input type="hidden" id="IDusuario" name="IDusuario" value="${IDusuario}" />
                    </div>
                </form>
            `,
    showCancelButton: true,
    confirmButtonText: "Actualizar",
    cancelButtonText: "Cancelar",
    confirmButtonColor: "#198754",
    cancelButtonColor: "#d33",
    customClass: {
      confirmButton: "fw-bold",
      cancelButton: "fw-bold",
    },
  }).then((result) => {
    let frmEditar = document.querySelector("#frmTrabajos");
    let formData = new FormData(frmEditar);
    if (result.isConfirmed) {
      fetch("../CONTROLLER/editarEntrega.php", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.status === "ok") {
            Swal.fire({
              icon: "success",
              title: "Edicion completada",
              text: "El trabajo fue editado correctamente.",
            }).then(() => {
              location.href = "./entregas.php"
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: data.message || "No se pudo editar el archivo.",
            });
          }
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un problema con la petición.",
          });
        });
    }
  });
}
