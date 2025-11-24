document.addEventListener('DOMContentLoaded', function() {
    const mensaje = document.getElementById('mensajeServidor').value;

    if(mensaje && mensaje.trim() !== '') {
        Swal.fire({
            title: '¡Atención!',
            text: mensaje,
            icon: mensaje.includes('incorrecta') ? 'error' : 'success',
            confirmButtonText: 'Aceptar',
            timer: 4000
        });
    }

    const checkbox = document.getElementById('cambiarPassword');
    const newPass = document.getElementById('newPassword');

    checkbox.addEventListener('change', function() {
        newPass.disabled = !this.checked;
    });
});
