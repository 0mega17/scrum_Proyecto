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
    <div class="container-fluid mt-2">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2 mb-1">
                    <i class="fas fa-user-tag text-primary me-2"></i>
                    Asignar Fichas a Instructores
                </h1>
                <p class="text-muted mb-0">
                    Administra las fichas asignadas a cada instructor
                </p>
            </div>
            
            <div class="mb-2 mb-md-0">
                <button class="btn btn-primary px-4 py-2 shadow-sm" id="btnCambiarInstructor">
                    <i class="fas fa-exchange-alt me-2"></i>
                    Cambiar Instructor
                </button>
            </div>
        </div>

        <div id="instructorInfo" class="alert alert-info border-0 shadow-sm d-flex align-items-center" style="display: none;">
            <i class="fas fa-user-circle fa-2x me-3"></i>
            <div>
                <strong class="d-block">Instructor seleccionado:</strong>
                <span id="nombreInstructor" class="text-dark"></span>
            </div>
        </div>

        <div id="tablaFichas" class="card shadow-sm border-0" style="display: none;">
            <div class="card-header bg-body-tertiary py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-secondary"></i>
                            Fichas Disponibles
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table id="tablaFichasAsignar" class="table table-striped mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold" scope="col">ID</th>
                                <th class="fw-semibold" scope="col">Código</th>
                                <th class="fw-semibold" scope="col">Nombre</th>
                                <th class="fw-semibold" scope="col">Área</th>
                                <th class="fw-semibold" scope="col">Fecha Inicio</th>
                                <th class="fw-semibold" scope="col">Fecha Fin</th>
                                <th class="fw-semibold text-center" scope="col">Estado</th>
                                <th class="fw-semibold text-center" scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tableFichasBody">
                            <!-- //? se va a llenar con dom -->
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>

        <!-- //* mensaje inicial que sale de fondo -->
        <div id="mensajeInicial" class="text-center mt-5 py-5">
            <i class="fas fa-user-tag" style="font-size: 5rem; color: #6c757d; opacity: 0.3;"></i>
            <p class="mt-4 text-muted fs-5">Selecciona un instructor para ver y asignar fichas</p>
            <p class="text-muted">
                <i class="fas fa-arrow-up me-1"></i>
                Haz clic en el botón "Cambiar Instructor" para comenzar
            </p>
        </div>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>
