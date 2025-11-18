
document
  .getElementById("formularioCrearFicha")
  .addEventListener("submit", function (algo) {
    algo.preventDefault();
 
    let datos = new FormData(this);

    fetch("../CONTROLLER/controladorCrearFicha.php", {
      method: "POST",
      body: datos,

    })
  
      .then(function (respuesta) {
        return respuesta.json();
      })
      .then(function (json) {
     
        if (json.susses === true) {
          Swal.fire({
            title: "¡Ficha creada!",
            text: "El registro fue exitoso",
            icon: "success",
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#3085d6",
          }).then(() => {
            window.location.href = "login.php";
          });

          document.getElementById("formularioCrearFicha").reset();
        } else if (json.susses === false) {
          Swal.fire({
            title: "Error",
            text: "Ocurrió un error al crear la ficha",
            icon: "error",
            confirmButtonText: "Reintentar",
            confirmButtonColor: "#d33",
          });
        }
      });
  });
