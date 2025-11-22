$(document).ready(function () {


  //* evento del boton desasignar ficha
  $(document).on("click", ".btn-desasignar", function () {
    const fichaId = $(this).data("ficha-id");

    //* validar que se haya seleccionado un instructor
    //* por si un peludo se quiere saltar el paso de seleccionar instructor
    if (!window.instructorActual) {
      Swal.fire({
        icon: "warning",
        title: "Atención",
        text: "Por favor, seleccione un instructor primero",
      });
      return;
    }

    Swal.fire({
      title: "¿Está seguro?",
      text: "Se desasignará esta ficha del instructor",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Sí, desasignar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../CONTROLLER/desasignarFichaController.php",
          type: "POST",
          data: {
            accion: "desasignar",
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
                //* recargar fichas del instructor actual
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
              text: "Error al desasignar la ficha",
            });
          },
        });
      }
    });
  });
});
