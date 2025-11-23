document.addEventListener("DOMContentLoaded", () => {
  let datosCalificacion = document.querySelector("#datosCalificaciones");
  fetch("../CONTROLLER/datos_calificaciones.php")
    .then((respuesta) => respuesta.json())
    .then((datos) => {
      datosCalificacion.innerHTML = "";
      datos.forEach((datos) => {
        let fila = document.createElement("tr");
        fila.innerHTML = `
              <td>${datos.nombre_aprendiz}</td>
              <td>${datos.nombre_trabajo}</td>
              <td>
              <a href="../${datos.archivo}"
                      target="_blank"
                      class="btn btn-primary btn-sm fw-bold">
                                Ver archivo
                        </a>
              <td>
                    <textarea class ="comentario" name="comentario" rows="3" style="width: 100%;"></textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm me-2 btnAprobar" data-id = "${datos.id}">A</button>
                <button type="button" class="btn btn-danger btn-sm btnDesaprovar" data-id = "${datos.id}">D</button>
            </td>         `;
        datosCalificacion.appendChild(fila);
      });

      function enviarCalificacion(calificacion, boton) {
        let comentario = boton.closest("tr").querySelector(".comentario").value;
        let id = parseInt(boton.dataset.id);
        fetch("../CONTROLLER/controlador_calificacion.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: `calificacion=${calificacion}&comentario=${comentario}&id=${id} `,
        })
          .then((respuesta) => respuesta.json())
          .then((datos) => {
            // aqui debe de salir la alerta  para cer que se
            if (datos.validacion) {
              Swal.fire({
                icon: "success",
                title: "¡Calificación realizada!",
                text: datos.mensaje,
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
              }).then(() => {
                location.reload();
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Ocurrió un error",
                text: datos.mensaje,
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: false,
              });
            }
          });
      }
      document.querySelectorAll(".btnAprobar").forEach((boton) => {
        boton.addEventListener("click", function () {
          enviarCalificacion("Aprobado", this);
        });
      });

      document.querySelectorAll(".btnDesaprovar").forEach((boton) => {
        boton.addEventListener("click", function () {
          enviarCalificacion("Desaprobado", this);
        });
      });
    });
});
