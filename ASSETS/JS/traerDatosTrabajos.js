document.addEventListener("DOMContentLoaded", () => {
  let cuerpoTabla = document.getElementById("datosTrabajos");

  fetch("../CONTROLLER/controladorDatosTrabajos.php")
    .then((respuesta) => respuesta.json())
    .then((datos) => {
      cuerpoTabla.innerHTML = "";

      datos.forEach((datosTrabajo) => {
        let fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${datosTrabajo.nombre}</td>
            <td>${datosTrabajo.archivo}</td>
            <td><input 
  type="number" 
  class="calificacion form-control" 
  placeholder="Calificacion del trabajo" 
  min="1" 
  max="5" 
  required
></td>
            <td><textarea id="comentario" name="comentario" rows="4" cols="50" placeholder="Escribe tu comentario aquí..."></textarea></td>
            <td>${datosTrabajo.nombre_aprendis}</td>
            <td>
            <button class="btn btn-success btn-sm btnEnviar" data-id="${datosTrabajo.id}" >
              Enviar
            </button>
            </td>
            
          `;

        cuerpoTabla.appendChild(fila);
      });

      document.querySelectorAll(".btnEnviar").forEach((boton) => {
        boton.addEventListener("click", function () {
          let fila = this.closest("tr");
          let calificacion = fila.querySelector(".calificacion").value;
          let comentario = fila.querySelector(".calificacion").value;
          let id = parseInt(this.dataset.id);

          fetch("../CONTROLLER/controladorCalificarTrabajo.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `calificacion=${calificacion}&comentario=${comentario}&id=${id}`,
          })
            .then((respuesta) => respuesta.json())
            .then((respuesta) => {
              if (respuesta.validacion) {
                  Swal.fire({
                      icon: "success",
                      title: "instructore creado",
                      text: respuesta.mensaje,
                      showConfirmButton: false,
                      timer: 1200,
                  }).then(()=>{
                      location.reload();
                  });
              } else {
                    Swal.fire({
                      icon: "error",
                      title: "Error",
                      text: respuesta.mensaje,
                      showConfirmButton: false,
                      timer: 1200,
                    });
              }
            });
        });
      });
    })
    .catch((error) => {});
});
