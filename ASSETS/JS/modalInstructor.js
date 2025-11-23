$(document).ready(function () {

  //* es una variable global para almacenar el instructor actual
  //* para evitar seleccionar el instructor cada vez que se asigne o desasigne una ficha
  window.instructorActual = null;

  //* modal para seleccionar instructor 
  window.mostrarModalInstructor = function() {
    $.ajax({
      url: "../CONTROLLER/obtenerInstructoresController.php",
      type: "POST",
      data: { accion: "obtenerInstructores" },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {

          //* seleccionar instructor 
          let optionsHTML = '<option value="">Seleccione un instructor</option>';
          //* como funciona: pues lo que hace es recorrer el array de instructores que viene en la respuesta JSON
          //* y por cada instructor crea una opción en el select con su id como valor y su nombre y email como texto
          //* listo el pollo
          respuesta.instructores.forEach((instructor) => {
            optionsHTML += `<option value="${instructor.id}">${instructor.nombre} - ${instructor.email}</option>`;
          });


          Swal.fire({
            title: "Seleccionar Instructor",
            html: `
              <div style="text-align: left; padding: 10px;">
                <label for="selectInstructor" style="font-weight: bold; margin-bottom: 10px; display: block;">
                  Instructor:
                </label>
                <select id="selectInstructor" class="swal2-input" style="width: 90%; padding: 10px;">
                  ${optionsHTML}
                </select>
              </div>
            `,
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Seleccionar",
            confirmButtonColor: "#198754",
            preConfirm: () => {
              const instructorId = document.getElementById("selectInstructor").value;
              if (!instructorId) {
                Swal.showValidationMessage("Por favor, seleccione un instructor");
                return false;
              }
              return instructorId;
            },
          }).then((result) => {
            if (result.isConfirmed) {
              window.instructorActual = result.value;
              window.cargarFichas(result.value);
            }
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al cargar los instructores",
        });
      },
    });
  };

  // Mostrar modal al cargar la página
  window.mostrarModalInstructor();
});
