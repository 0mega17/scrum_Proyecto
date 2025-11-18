$(document).ready(function () {
  $("#formCrearInstructores").submit(function (e) {
    e.preventDefault();

    let datos = {
      nombre: $("#nombre").val(),
      email: $("#email").val(),
      password: $("#password").val(),
    };

    $.ajax({
      url: "../controllers/crear_instructores_controller.php",
      type: "POST",
      data: { accion: "crear", ...datos },
      dataType: "json",
      success: function (respuesta) {
        if (respuesta.status === "success") {
          Swal.fire({
            icon: "success",
            title: "instructore creado",
            text: "instructore creado exitosamente!",
            showConfirmButton: false,
            timer: 1200,
          }).then(() => {
            window.location.href = "index.php";Ñ
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