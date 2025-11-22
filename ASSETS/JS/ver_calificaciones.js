
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
                    <table class="table mt-2" style="width:100%;text-align:left;">
                        <thead>
                            <tr>
                                <th>Comentario</th>
                                <th>Calificacion</th>
                                <th>Fecha calificacion</th>
                                <th>Instructor</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

        tabla += `
                        <tr>
                            <td>${res.calificaciones.comentario}</td>
                            <td class= "fw-bold ${res.calificaciones.calificacion == "Aprobado" ? "text-success" : "text-danger"}">${res.calificaciones.calificacion}</td>
                            <td>${res.calificaciones.fecha_calificacion}</td>
                            <td>${res.calificaciones.nombre}</td>
                        </tr>
                    `;

        tabla += `
                        </tbody>
                    </table>
                  
                `;

        Swal.fire({
          title: "Detalle de la calificacion",
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
