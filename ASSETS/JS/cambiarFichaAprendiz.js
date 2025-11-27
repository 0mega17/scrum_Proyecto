$(document).ready(function () {
  $(".btnCambiarFicha").on("click", function () {
    //? aqui se leen los datos del boton
    let aprendizId = $(this).data("id");
    let aprendizNombre = $(this).data("nombre");
    let fichaActual = $(this).data("ficha");

    $.ajax({
      url: "../CONTROLLER/cambiarFichaAprendiz.php?action=obtenerFichas",
      method: "GET",
      dataType: "json",
      success: function (response) {
        if (response.success && response.fichas.length > 0) {
          //* crear opciones para el select
          //* codigo y id de la ficha
          let options = {};
          response.fichas.forEach((ficha) => {
            options[ficha.id] = ficha.codigo;
          });

          Swal.fire({
            title: "Cambiar Ficha",
            html: `<p>Seleccione la nueva ficha para <strong>${aprendizNombre}</strong></p>`,
            input: "select",
            inputOptions: options,
            inputValue: fichaActual,
            inputPlaceholder: "Seleccione una ficha",
            showCancelButton: true,
            confirmButtonText: "Cambiar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#0d6efd",
            cancelButtonColor: "#6c757d",
            inputValidator: (value) => {
              if (!value) {
                return "Debe seleccionar una ficha";
              }
            },
            customClass: {
              confirmButton: "btn btn-primary me-2",
              cancelButton: "btn btn-secondary",
            },
            buttonsStyling: false,
          }).then((result) => {
            if (result.isConfirmed) {
              let nuevaFichaId = result.value;

              $.ajax({
                url: "../CONTROLLER/cambiarFichaAprendiz.php",
                method: "POST",
                data: {
                  aprendizId: aprendizId,
                  fichaId: nuevaFichaId,
                },
                dataType: "json",
                success: function (response) {
                  if (response.success) {
                    Swal.fire({
                      icon: "success",
                      title: "¡Éxito!",
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1200,
                    }).then(() => {
                      location.reload();
                    });
                  } else {
                    Swal.fire({
                      icon: "error",
                      title: "Error",
                      text: response.message,
                      showConfirmButton: false,
                      timer: 1200,
                    });
                  }
                },
                error: function () {
                  Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Error al procesar la solicitud",
                    showConfirmButton: false,
                    timer: 1200,
                  });
                },
              });
            }
          });
        } else {
          Swal.fire({
            icon: "warning",
            title: "Advertencia",
            text: "No hay fichas disponibles",
            showConfirmButton: false,
            timer: 1200,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: "Error al cargar las fichas",
          showConfirmButton: false,
          timer: 1200,
        });
      },
    });
  });
});
