function verCalificacion(IDentrega) {
  $.ajax({
    url: "../CONTROLLER/verCalificaciones.php",
    type: "POST",
    data: { IDentrega: IDentrega },
    dataType: "json",
    success: function (res) {
      if (res.success) {
        console.log(res);

        const esAprobado = res.calificaciones.calificacion === "Aprobado";
        const badgeClass = esAprobado ? "bg-success" : "bg-danger";

        let tabla = `
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-body-tertiary py-3">
              <h4 class="mb-0 fw-bold">
                Detalle de Calificación
              </h4>
              <p class="mb-0 text-muted"> 
              Visualiza el estado de calificacion actual de su trabajo
              </p>
            </div>
            
            <div class="card-body p-4">
              <div class="text-center mb-4">
              <h6 class="fw-semibold text-uppercase">
              <i class="fa-solid fa-clipboard"></i>
              Calificacion:  </h6>
                <p class="badge ${badgeClass} px-4 py-2 fs-5 w-100">
                   ${res.calificaciones.calificacion}
                </p>
                
              </div>
              
              <!-- Información principal -->
              <div class="row g-3 mb-3">
                <div class="col-md-6">
                  <div class="border-start border-4 ps-3">
                    <small class="fw-semibold d-block mb-1 text-uppercase">                      <i class="fa-solid fa-calendar"></i>
                    Fecha de Calificación</small>
                    <p class="mb-0 fw-semibold text-dark">
                      ${res.calificaciones.fecha_calificacion}
                    </p>
                  </div>
                </div>
                
                <div class="col-md-6">
                  <div class="border-start border-end border-4 ps-3">
                    <small class="fw-semibold text-uppercase d-block mb-1">
                         <i class="fas fa-user"></i>
                         Instructor</small>
                    <p class="mb-0 fw-semibold text-dark">
                      ${res.calificaciones.nombre}
                    </p>
                  </div>
                </div>
              </div>
              
              <!-- Comentario -->
              <div class="mt-4">
                <div class="border-start border-end border-4 ps-3">
                  <h6 class="fw-semibold text-uppercase mb-2">
                    <i class="fa-solid fa-comments"></i>
                    Comentario del Instructor
                  </h6>
                  <p class="mb-0 text-dark">
                  
                    ${res.calificaciones.comentario}
                  </p>
                </div>
              </div>
            </div>
          </div>
        `;

        Swal.fire({
          html: tabla,
          showConfirmButton: true,
          confirmButtonText: "Volver al listado",
          width: 700,
          padding: "1rem",
          customClass: {
            confirmButton: "btn btn-primary fw-bold ",
          },
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: res.message,
          confirmButtonColor: "#dc3545",
        });
      }
    },
    error: function () {
      Swal.fire({
        icon: "error",
        title: "Error de Conexión",
        text: "No se pudo obtener la información de la calificación.",
        confirmButtonColor: "#dc3545",
      });
    },
  });
}
