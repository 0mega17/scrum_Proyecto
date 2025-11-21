$(document).ready(function () {
  $("#btnCrearArea").click(function (e) {
    e.preventDefault();

    Swal.fire({
      title: "Crear Nueva Área",
      //* formulario para ingresar el nombre del área
      html: `
        <input type="text" id="nombreArea" class="swal2-input" placeholder="Ingrese el nombre del área" style="width: 80%;">
      `,
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      confirmButtonText: "Agregar",
      confirmButtonColor: "#198754",    
      preConfirm: () => {
        const nombreArea = document.getElementById("nombreArea").value.trim();
        
        //* validar que no esté vacio
        if (!nombreArea) {
          Swal.showValidationMessage("Por favor, ingrese el nombre del área");
          return false;
        }
        
        //* validar que solo contenga letras y espacios 
        const soloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
        if (!soloLetras.test(nombreArea)) {
          Swal.showValidationMessage("El nombre del área solo debe contener letras");
          return false;
        }
        
        return nombreArea;
      },
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "../CONTROLLER/crearArea.php",
          type: "POST",
          data: { accion: "crear", nombreArea: result.value },
          dataType: "json",
          success: function (respuesta) {
            if (respuesta.status === "success") {
              Swal.fire({
                icon: "success",
                title: "Área creada",
                text: respuesta.message,
                showConfirmButton: false,
                timer: 1200,
              }).then(() => {
                location.reload();
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
              text: "Error al crear el área",
            });
          },
        });
      }
    });
  });
});
