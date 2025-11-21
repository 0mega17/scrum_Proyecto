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
              <td>${datos.archivo}</td>
              <td>
                    <textarea name="comentario" rows="3" style="width: 100%;"></textarea>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-success btn-sm me-2 btnAprobrar">A</button>
                <button type="button" class="btn btn-danger btn-sm btnDesaprovar">D</button>
            </td>         `;
          datosCalificacion.appendChild(fila);
      });
    });
});
