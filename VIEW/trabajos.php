<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
$pagina = "Trabajos";
$idUsuario = $_SESSION["IDusuario"];
$rol = $_SESSION["tipoUsuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

if ($rol == 3) {
    $trabajos = $mysql->efectuarConsulta("SELECT * FROM trabajos INNER JOIN aprendices ON trabajos.aprendices_id = aprendices.id  WHERE aprendices.id = $idUsuario");
} else {
    $trabajos = $mysql->efectuarConsulta("SELECT * FROM trabajos");
}


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-5">
        <?php if ($rol == 3) { ?>
            <!-- FORMULARIO INDEPENDIENTE -->
            <div class="card shadow-lg border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 text-center">
                    <h4 class="fw-bold mb-0">
                        <i class="fa-solid fa-file-arrow-up text-primary me-2"></i>
                        Subir Archivo
                    </h4>
                </div>

                <div class="card-body bg-light">

                    <form method="post" id="frmTrabajos" enctype="multipart/form-data">

                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <label class="fw-semibold">Seleccione un archivo</label>
                                <input
                                    type="file"
                                    class="form-control shadow-sm"
                                    id="uploadFile"
                                    name="uploadFile"
                                    accept=".pdf, .docx, .doc, .xlsx, .png, jpg, jpeg">
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button
                                type="submit"
                                id="subirArchivo"
                                class="btn btn-warning px-5 py-2 rounded-pill shadow">
                                <i class="fa-solid fa-upload me-2"></i> Subir
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        <?php } ?>



        <!-- TABLA INDEPENDIENTE -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-white py-3 text-center">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-table text-success me-2"></i>
                    Archivos Subidos
                </h4>
                <?php if ($rol == 2) { ?>
                    <div class="text-center mt-4">
                        <button
                            type="submit"
                            id="crearTrabajo"
                            name="crearTrabajo"
                            class="btn btn-warning px-5 py-2 rounded-pill shadow">
                            <i class="fa-solid fa-upload me-2"></i> Crear Trabajo
                        </button>
                    </div>
            </div>
        <?php } ?>

        <div class="card-body table-responsive">

            <table class="table table-striped table-bordered shadow-sm">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Archivo</th>
                        <th>Calificacion</th>
                        <th>Comentario</th>
                        <th>Fecha Limite</th>
                    </tr>
                </thead>

                <tbody id="tablaTrabajos">
                    <?php while ($fila = $trabajos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><a href="../CONTROLLER/uploads/<?php echo $fila['archivo']; ?>"
                                    target="_blank"
                                    class="btn btn-primary btn-sm">
                                    Ver archivo
                                </a></td>
                            <td><?php echo $fila['calificacion']; ?></td>
                            <td><?php echo $fila['comentario']; ?></td>
                            <td><?php echo $fila['fecha_limite']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

        </div>
        </div>
    </div>
    </div>

    </div>
</main>
<?php
require_once './layout/footer.php';
?>