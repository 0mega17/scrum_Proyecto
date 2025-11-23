$(document).ready(function () {
  //* se activa la funcion para cargar las fichas del instructor
  //* el window.instructorActual se define en modalInstructor.js

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

          let tableHTML = "";
          respuesta.fichas.forEach((ficha) => {
            //* se usan operadores ternarios para definir el badge de estado y el boton segun si la ficha está asignada o no
            const estadoBadge = ficha.asignada == 1 
              ? '<span class="badge bg-success">Asignada</span>' 
              : '<span class="badge bg-secondary">No asignada</span>';
            
              //* lo mismo para el boton
            const boton = ficha.asignada == 1
              ? `<button class="btn btn-danger btn-sm btn-desasignar" data-ficha-id="${ficha.id}">
                   <i class="bi bi-x-circle"></i> Desasignar
                 </button>`
              : `<button class="btn btn-success btn-sm btn-asignar" data-ficha-id="${ficha.id}">
                   <i class="bi bi-check-circle"></i> Asignar
                 </button>`;


                 //* se llena la tabla de esta forma porque es mas sencillo que manipular el DOM fila por fila
            tableHTML += `
              <tr>
                <td>${ficha.id}</td>
                <td>${ficha.codigo}</td>
                <td>${ficha.nombre}</td>
                <td>${ficha.nombre_area}</td>
                <td>${ficha.fecha_inicio}</td>
                <td>${ficha.fecha_fin}</td>
                <td>${estadoBadge}</td>
                <td>${boton}</td>
              </tr>
            `;
          });
          //* se actualiza el contenido del cuerpo de la tabla con el HTML generado
          $("#tableFichasBody").html(tableHTML);
          
          //* Destruir DataTable existente si ya está inicializada
          if ($.fn.DataTable.isDataTable('#tablaFichasAsignar')) {
            $('#tablaFichasAsignar').DataTable().destroy();
          }
          
          //* Inicializar DataTable
          $('#tablaFichasAsignar').DataTable({
            responsive: true,
            language: {
              url: '//cdn.datatables.net/plug-ins/2.0.0/i18n/es-ES.json'
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
