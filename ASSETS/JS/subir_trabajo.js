const tblTrabajos = document.querySelector("#tablaTrabajos");

tblTrabajos.addEventListener("click", (e) => {
  if (e.target.classList.contains("btnSubirArchivo")) {
    let IDtrabajo = e.target.dataset.idtrabajo;
    let IDusuario = e.target.dataset.idusuario;

    Swal.fire({
      title: '<span class="text-success fw-bold">Subir trabajo</span>',
      html: `
                <form method="post" id="frmTrabajos" enctype="multipart/form-data">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <label class="fw-semibold form-label">Seleccione un archivo para la evidencia</label>
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
      confirmButtonText: "Agregar",
      cancelButtonText: "Cancelar",
      confirmButtonColor: "#198754",
      cancelButtonColor: "#d33",
      customClass: {
        confirmButton: "fw-bold",
        cancelButton: "fw-bold",
      },

      preConfirm: () => {
        const form = document.getElementById("frmTrabajos");
        const formData = new FormData(form);

        $.ajax({
          url: "../CONTROLLER/subirTrabajo.php",
          type: "POST",
          data: formData,
          processData: false,
          contentType: false,
          dataType: "json",

          success: function (respuesta) {
            if (!respuesta.success) {
              Swal.fire({
                title: '<span class="fs-2 fw-bold">¡Error!</span>',
                text: respuesta.message,
                icon: "error",
              });
              return;
            }

            Swal.fire({
              title: '<span class="fs-2 fw-bold">¡Éxito!</span>',
              text: respuesta.message,
              icon: "success",
              timer: 2000,
              timerProgressBar: true,
              showConfirmButton: false,
            }).then(() => {
              location.href = "./entregas.php";
            });

            form.reset();
          },
        });
      },
    });
  }
});
