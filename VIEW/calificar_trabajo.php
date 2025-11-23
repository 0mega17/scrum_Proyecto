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

$aprendices = $mysql->efectuarConsulta("SELECT * FROM fichas");

$mysql->desconectar();


// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Calificaciones</h1>
    </div>
    <div>
        <button id="mostrarCalificacionesAprendices" data-id="<?= $_SESSION['IDusuario'] ?>" class="btn btn-primary">
            Ver calificaciones
        </button>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
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

</main>
<script>
    const idInstructor = <?php echo $IDusuario; ?>;
</script>
<?php
require_once './layout/footer.php';
?>