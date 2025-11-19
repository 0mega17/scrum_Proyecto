const subirArchivo = document.querySelector("#subirArchivo");

subirArchivo.addEventListener("click", function (e) {
    e.preventDefault();

    const form = document.getElementById("frmTrabajos");
    const formData = new FormData(form);

    $.ajax({
        url: "../CONTROLLER/subirArchivo.php",
        type: "POST",
        data: formData,
        processData: false, 
        contentType: false,   
        dataType: "json",

        success: function (respuesta) {

            if (!respuesta.success) {
                Swal.fire({
                    title: '<span class="fs-2 fw-bold">¡Error!</span>',
                    text: respuesta.message,
                    icon: "error",
                });
                return;
            }

            Swal.fire({
                title: '<span class="fs-2 fw-bold">¡Éxito!</span>',
                text: respuesta.message,
                icon: "success",
            });

            form.reset();
        },

        error: function (xhr, status, error) {
            Swal.fire("Error", "Error de conexión con el servidor.", "error");
            console.error(error);
        }
    });
});
url: ""