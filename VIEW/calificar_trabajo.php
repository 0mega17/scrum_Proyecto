<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Asignar Trabajos";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();


$mysql->desconectar();


// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container-fluid">


        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2 fw-semibold">Calificar trabajos</h1>
                <p class="text-muted">
                    Apartado para asignar las notas y ver las calificaciones
                </p>
            </div>

            <div class="mb-3">
                <button id="mostrarCalificacionesAprendices" data-id="<?= $_SESSION['IDusuario'] ?>" class="btn btn-primary">
                    Ver calificaciones
                </button>
            </div>
        </div>


        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h5 class="mb-0">
                            Listado de trabajos para calificar
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped align-middle" id="tblGeneral">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Aprendiz</th>
                                <th scope="col">Trabajo</th>
                                <th scope="col">Archivo</th>
                                <th scope="col">Comentario</th>
                                <th scope="col">Calificacion</th>
                            </tr>
                        </thead>
                        <tbody id="datosCalificaciones">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modalCalificaciones" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Calificaciones de aprendices</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- SELECT DE FICHAS -->
                        <label>Seleccione una ficha:</label>
                        <select id="selectFichaModal" class="form-select mb-3">
                            <option selected disabled>Seleccione...</option>
                        </select>

                        <!-- SELECT DE TRABAJOS -->
                        <label>Seleccione un trabajo:</label>
                        <select id="selectTrabajoModal" class="form-select mb-3">
                            <option selected disabled>Seleccione...</option>
                        </select>

                        <!-- TABLA DE APRENDICES -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Aprendiz</th>
                                    <th>Calificación</th>
                                </tr>
                            </thead>
                            <tbody id="tablaAprendices">
                            </tbody>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const idInstructor = <?php echo $IDusuario; ?>;
</script>
<?php
require_once './layout/footer.php';
?>