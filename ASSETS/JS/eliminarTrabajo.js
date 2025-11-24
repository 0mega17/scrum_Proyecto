function eliminarTrabajo(idTrabajo) {

    Swal.fire({
        title: "¿Estás seguro?",
        text: "Esto eliminará tu archivo entregado y podrás subir otro.",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {

        if (result.isConfirmed) {

            fetch("../CONTROLLER/eliminarEntrega.php", { 
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "idTrabajo=" + idTrabajo
            })
            .then(response => response.json())
            .then(data => {

                if (data.status === "ok") {
                    Swal.fire({
                        icon: "success",
                        title: "Eliminado",
                        text: "El trabajo fue eliminado correctamente.",
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: data.message || "No se pudo eliminar el archivo.",
                    });
                }

            })
            .catch(err => {
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema con la petición.",
                });
            });

        }

    });

}
