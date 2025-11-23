<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null || $_SESSION["tipoUsuario"] != 1) {
    header('location: ./login.php');
}

$pagina = "Asignar Fichas a Instructores";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];



require_once '../MODEL/model.php';



$mysql = new MySQL();

$mysql->conectar();

$nombreInstructores = $mysql->efectuarConsulta("SELECT nombre FROM instructores");


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Asignar Fichas a Instructores</h1>
        <button class="btn btn-primary" id="btnCambiarInstructor">
            <i class="bi bi-arrow-repeat"></i> Cambiar Instructor
        </button>
    </div>

    <div id="instructorInfo" class="alert alert-info" style="display: none;">
        <strong>Instructor seleccionado:</strong> <span id="nombreInstructor"></span>
    </div>

    <div id="tablaFichas" style="display: none;">
        <div class="table-responsive">
            <table id="tablaFichasAsignar" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Área</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tableFichasBody">
                    <!-- //? se va a llenar con dom -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- //* mesaje inicial que sale de fondo -->
    <div id="mensajeInicial" class="text-center mt-5">
        <i class="bi bi-person-badge" style="font-size: 4rem; color: #6c757d;"></i>
        <p class="mt-3 text-muted">Selecciona un instructor para ver y asignar fichas</p>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>
