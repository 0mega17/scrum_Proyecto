function verCalificacion(IDentrega) {
  $.ajax({
    url: "../CONTROLLER/verCalificaciones.php",
    type: "POST",
    data: { IDentrega: IDentrega },
    dataType: "json",
    success: function (res) {
      if (res.success) {
        console.log(res);
        let tabla = `
                   <div class = "card rounded-4 mt-1">
                      <div class = "card-header border border-0 bg-primary">
                      <h4 class="title-header fw-bold text-light"> Detalle de la calificación del trabajo </h4>
                      </div>

                      <div class="card-body p-2 mt-2">
                          <div class="row">
                             <div class="col-sm-4">
                             <h5 class ="fw-bold"> Calificacion: </h5>
                              <p class="fw-bold ${res.calificaciones.calificacion == "Aprobado" ? "text-success" : "text-danger"}">${res.calificaciones.calificacion}</p>
                            </div>
                             <div class="col-sm-4">
                             <h5 class ="fw-bold"> Fecha de calificacion: </h5>
                              <p>${res.calificaciones.fecha_calificacion}</p>
                            </div>
                             <div class="col-sm-4">
                             <h5 class ="fw-bold"> Instructor: </h5>
                              <p>${res.calificaciones.nombre}</p>
                            </div>
                          </div>

                          <div class="row my-2">
                            <div class="col-sm-12">
                            <h5 class ="fw-bold"> Comentario: </h5>
                              <p>${res.calificaciones.comentario}</p>
                            </div>
                          </div>
                      </div>

                   </div>
                `;


        Swal.fire({
          html: tabla,
          icon: "info",
          confirmButtonText: "Cerrar",
          width: 900,
        });
      } else {
        Swal.fire("Error", res.message, "error");
      }
    },
    error: function () {
      Swal.fire(
        "Error",
        "No se pudo obtener la información de la venta.",
        "error"
      );
    },
  });
}
