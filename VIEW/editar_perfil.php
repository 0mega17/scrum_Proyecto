<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Editar perfil";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();



if ($rol == 1) {
    // Realizar la consulta para verificar que existe el usuario
    $usuario = $mysql->efectuarConsulta("SELECT * FROM administradores WHERE id = $IDusuario");
    $rolTxt = "Administrador";
    $rolTxtInp = "administradores";
} else if ($rol == 2) {
    // Realizar la consulta para verificar que existe el usuario
    $usuario = $mysql->efectuarConsulta("SELECT * FROM instructores WHERE id = $IDusuario");
    $rolTxt = "Instructor";
    $rolTxtInp = "instructores";
} else if ($rol == 3) {
    // Realizar la consulta para verificar que existe el usuario
    $usuario = $mysql->efectuarConsulta("SELECT * FROM aprendices WHERE id = $IDusuario");
    $rolTxt = "Aprendiz";
    $rolTxtInp = "aprendices";
}

$usuario = $usuario->fetch_assoc();


require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

$aprendices = $mysql->efectuarConsulta("SELECT * FROM aprendices");

$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';



?>

<div class="col-md-4 mb-4 d-flex justify-content-center mt-5">
    <div class="card mt-3 text-center" style="width: 18rem;">
        <div class="card-body d-flex flex-column align-items-center">
            <img src="../assets/img/profile.png"
                class="rounded-circle shadow mb-3"
                alt="User Image"
                style="width: 150px; height: 150px; object-fit: cover;">
            <h3 class="card-title mb-0">
                <?php echo $usuario["nombre"]; ?>
            </h3>
            <small> <?php echo $rolTxt ?></small>
        </div>
    </div>
</div>
<div class="col-md-5 align-self-center mt-5">
    <div class="profile-card">
        <h3 class="fw-bold-card">Detalles Perfil</h3>
        <form method="post">
            <!-- Información Personal -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Identificacion</label>
                    <input disabled type="text" class="form-control" id="IDusuario" name="IDusuario" value="<?php echo $usuario['id']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email'] ?>">
                </div>
            </div>

            <!-- Separador visual -->
            <hr class="my-4">

            <!-- Cambio de contraseña -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Contraseña actual</label>
                    <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Ingrese su contraseña actual">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nueva Contraseña</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" disabled placeholder="Ingresa una nueva contraseña">
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="cambiarPassword">
                        <label class="form-check-label" for="cambiarPassword">
                            ¿Deseas cambiar tu contraseña?
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <input type="hidden" value="<?php echo $rolTxtInp ?>" class="form-control" id="rol" name="rol"">
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class=" d-flex justify-content-end m-4">
                <button type="button" class="btn btn-primary me-2" id="btnGuardar">Guardar</button>
                <a href="./index.php" class="btn btn-success">Volver a Inicio</a>
            </div>
        </form>

    </div>
</div>
<?php
require_once './layout/footer.php';
?>