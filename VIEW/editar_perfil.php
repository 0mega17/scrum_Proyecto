<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();
$mysql->conectar();

// Obtener datos del usuario según el rol
if ($rol == 1) {
    $usuario = $mysql->efectuarConsulta("SELECT * FROM administradores WHERE id = $IDusuario");
    $rolTxt = "Administrador";
    $rolTxtInp = "administradores";
} elseif ($rol == 2) {
    $usuario = $mysql->efectuarConsulta("SELECT * FROM instructores WHERE id = $IDusuario");
    $rolTxt = "Instructor";
    $rolTxtInp = "instructores";
} else {
    $usuario = $mysql->efectuarConsulta("SELECT * FROM aprendices WHERE id = $IDusuario");
    $rolTxt = "Aprendiz";
    $rolTxtInp = "aprendices";
}

$usuario = $usuario->fetch_assoc();
$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <div class="d-flex justify-content-center mt-3">
        <div class="card shadow-lg border-0" style="max-width: 650px; width: 100%; border-radius: 1rem;">
            <div class="card-body p-4">

                <h3 class="text-center fw-bold mb-4">Detalles del Perfil</h3>

                <form method="post">

                    <!-- Nombre -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                               value="<?php echo $usuario['nombre']; ?>">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               value="<?php echo $usuario['email']; ?>">
                    </div>

                    <hr class="my-4">

                    <!-- Contraseñas -->
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Contraseña actual</label>
                            <input type="password" class="form-control" id="oldPassword" name="oldPassword"
                                   placeholder="Ingrese su contraseña actual">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nueva contraseña</label>
                            <input type="password" class="form-control" id="newPassword" name="newPassword"
                                   disabled placeholder="Ingresa una nueva contraseña">

                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="cambiarPassword">
                                <label class="form-check-label" for="cambiarPassword">
                                    ¿Deseas cambiar tu contraseña?
                                </label>
                            </div>
                        </div>

                    </div>

                    <input type="hidden" id="rol" name="rol" value="<?php echo $rolTxtInp; ?>">

                    <!-- Botones -->
                    <div class="text-end mt-4">
                        <button type="button" class="btn btn-primary px-4 me-2" id="btnGuardar">Guardar</button>
                        <a href="./index.php" class="btn btn-success px-4">Volver</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</main>


<?php require_once './layout/footer.php'; ?>
