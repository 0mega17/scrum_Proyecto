<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
    exit;
}

$pagina = "Editar perfil";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();
$mysql->conectar();

switch ($rol) {
    case 1:
        $rolTabla = "administradores";
        break;
    case 2:
        $rolTabla = "instructores";
        break;
    default:
        $rolTabla = "aprendices";
        break;
}

$usuario = $mysql->efectuarConsulta("SELECT * FROM $rolTabla WHERE id = $IDusuario")->fetch_assoc();

$mensaje = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $oldPassword = $_POST['oldPassword'] ?? '';
    $newPassword = $_POST['newPassword'] ?? '';

    if (!empty($oldPassword) && !empty($newPassword)) {
        if (password_verify($oldPassword, $usuario['password'])) {
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
            $mysql->efectuarConsulta("UPDATE $rolTabla SET nombre='$nombre', email='$email', password='$newPasswordHash' WHERE id=$IDusuario");
            $mensaje = "Perfil y contraseña actualizados correctamente.";
        } else {
            $mensaje = "La contraseña actual es incorrecta.";
        }
    } else {
        $mysql->efectuarConsulta("UPDATE $rolTabla SET nombre='$nombre', email='$email' WHERE id=$IDusuario");
        $mensaje = "Perfil actualizado correctamente.";
    }

    $usuario = $mysql->efectuarConsulta("SELECT * FROM $rolTabla WHERE id=$IDusuario")->fetch_assoc();
}

$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-center mt-3">
        <div class="card shadow-lg border-0" style="max-width: 650px; width: 100%; border-radius: 1rem;">
            <div class="card-body p-4">
                <h3 class="text-center fw-bold mb-4">Detalles del Perfil</h3>

                <?php if($mensaje): ?>
                    <input type="hidden" id="mensajeServidor" value="<?php echo $mensaje; ?>">
                <?php endif; ?>

                <form method="post" action="">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
                    </div>

                    <hr class="my-4">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contraseña actual</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Ingrese su contraseña actual">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword" disabled placeholder="Ingresa una nueva contraseña">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="cambiarPassword">
                                <label class="form-check-label" for="cambiarPassword">¿Deseas cambiar tu contraseña?</label>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="rol" value="<?php echo $rolTabla; ?>">

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 me-2">Guardar</button>
                        <a href="./index.php" class="btn btn-success px-4">Volver</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
document.getElementById('cambiarPassword').addEventListener('change', function() {
    document.getElementById('newPassword').disabled = !this.checked;
});
</script>

<?php require_once './layout/footer.php'; ?>
