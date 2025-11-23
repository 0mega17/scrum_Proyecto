$(document).ready(function () {
  // Evento para asignar ficha
  $(document).on("click", ".btn-asignar", function () {
    const fichaId = $(this).data("ficha-id");


    //* validar que se haya seleccionado un instructor
    if (!window.instructorActual) {
      Swal.fire({
        icon: "warning",
        title: "Atención",
        text: "Por favor, seleccione un instructor primero",
      });
      return;
    }

    $.ajax({
      url: "../CONTROLLER/asignarFichaController.php",
      type: "POST",
      data: {
        accion: "asignar",
        instructorId: window.instructorActual,
        fichaId: fichaId,
      },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Éxito",
            text: respuesta.message,
            showConfirmButton: false,
            timer: 1200,
          }).then(() => {
             //* window.cargarFichas se define en cargarFichasInstructor.js
             //* lo que hace es recargar las fichas del instructor actual para reflejar el cambio
            window.cargarFichas(window.instructorActual);
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
          text: "Error al asignar la ficha",
        });
      },
    });
  });
});
