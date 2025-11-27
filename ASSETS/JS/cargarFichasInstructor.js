$(document).ready(function () {
  //* se activa la funcion para cargar las fichas del instructor
  //* el window.instructorActual se define en modalInstructor.js
  
  //* variable para almacenar la instancia de DataTable
  let tablaFichas = null;

  window.cargarFichas = function(instructorId) {
    $.ajax({
      url: "../CONTROLLER/obtenerFichasController.php",
      type: "POST",
      data: { accion: "obtenerFichas", instructorId: instructorId },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {
          $("#nombreInstructor").text(respuesta.instructor);
          $("#idInstructor").text(instructorId);
          $("#instructorInfo").show();
          $("#mensajeInicial").hide();
          $("#tablaFichas").show();

          //* Si la tabla ya está inicializada, destruirla completamente
          //* esto se hace para evitar errores al reinicializar la tabla con nueva data
          //* y que se le tega que dar f5 
          //! sin esto, no van a salir los cambios en la tabla al asignar o desasignar fichas
          if (tablaFichas !== null) {
            tablaFichas.destroy();
            tablaFichas = null;
          }

          let tableHTML = "";
          respuesta.fichas.forEach((ficha) => {
            //* se usan operadores ternarios para definir el badge de estado y el boton segun si la ficha está asignada o no
            const estadoBadge = ficha.asignada == 1 
              ? '<span class="badge bg-success px-3 py-2"><i class="fas fa-check-circle me-1"></i>Asignada</span>' 
              : '<span class="badge bg-secondary px-3 py-2"><i class="fas fa-circle me-1"></i>No asignada</span>';
            
              //* lo mismo para el boton
            const boton = ficha.asignada == 1
              ? `<button class="btn btn-danger btn-sm btn-desasignar shadow-sm" data-ficha-id="${ficha.id}">
                   <i class="fas fa-times-circle me-1"></i> Desasignar
                 </button>`
              : `<button class="btn btn-success btn-sm btn-asignar shadow-sm" data-ficha-id="${ficha.id}">
                   <i class="fas fa-check-circle me-1"></i> Asignar
                 </button>`;


                 //* se llena la tabla de esta forma porque es mas sencillo que manipular el DOM fila por fila
            tableHTML += `
              <tr>
                <td>${ficha.id}</td>
                <td>${ficha.codigo}</td>
                <td>
                  <span class="badge text-bg-success px-3 py-2">
                    <i class="fas fa-graduation-cap me-1"></i>
                    ${ficha.nombre}
                  </span>
                </td>
                <td>
                  <span class="badge text-bg-primary px-3 py-2">
                    <i class="fa-solid fa-suitcase"></i>
                    ${ficha.nombre_area}
                  </span>
                </td>
                <td>
                  <i class="fas fa-calendar-alt text-success me-1"></i>
                  <small>${ficha.fecha_inicio}</small>
                </td>
                <td>
                  <i class="fas fa-calendar-check text-danger me-1"></i>
                  <small>${ficha.fecha_fin}</small>
                </td>
                <td class="text-center">${estadoBadge}</td>
                <td class="text-center">${boton}</td>
              </tr>
            `;
          });
          //* se actualiza el contenido del cuerpo de la tabla con el HTML generado
          $("#tableFichasBody").html(tableHTML);
          
          //* Inicializar DataTable y guardar la instancia
          tablaFichas = $('#tablaFichasAsignar').DataTable({
            responsive: true,
            language: {
              url: 'https://cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json'
            },
            order: [[0, 'asc']],
            
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: respuesta.message,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al cargar las fichas",
        });
      },
    });
  };
});
