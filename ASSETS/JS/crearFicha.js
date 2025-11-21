$(document).ready(function () {
  $("#formCrearFicha").submit(function (e) {
    e.preventDefault();

      let datos = {
          codigo: $("#codigo").val(),
          nombre: $("#nombre").val(),
          area_ficha: $("#area_ficha").val(),
          fechaInicio: $("#fechaInicio").val(),
          fechaFin: $("#fechaFin").val()
    };

    $.ajax({
      url: "../controller/crearFichaController.php",
      type: "POST",
      data: { accion: "crear", ...datos },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Ficha creada",
            text: "Ficha creada exitosamente!",
            showConfirmButton: false,
            timer: 1200,
          }).then(() => {
            window.location.href = "fichas.php";
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: respuesta.message,
          });
        }
      },
    });
  });
});
