$(document).ready(function () {
  $("#formCrearApreniz").submit(function (e) {
    e.preventDefault();

      let datos = {
          id: $("#id").val(),
          nombre: $("#nombre").val(),
          area: $("#area").val(),
          email: $("#email").val(),
          password: $("#password").val(),
          ficha: $("#ficha").val()
    };

    $.ajax({
      url: "../controller/crear_aprenidez_controller.php",
      type: "POST",
      data: { accion: "crear", ...datos },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Aprendiz creado",
            text: "Aprendiz creado exitosamente!",
            showConfirmButton: false,
            timer: 1200,
          }).then(() => {
            window.location.href = "index.php";
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
