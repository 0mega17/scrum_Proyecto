$(document).ready(function () {
  $("#formCrearInstructores").submit(function (e) {
    e.preventDefault();

    let datos = {
      id: $("#id").val(),
      nombre: $("#nombre").val(),
      area: $("#area").val(),
      email: $("#email").val(),
      password: $("#password").val(),
    };

    $.ajax({
      url: "../controller/crear_instructores_controller.php",
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
            window.location.href = "instructores.php";
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
