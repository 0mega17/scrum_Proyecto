<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
$pagina = "Entregas";
$idUsuario = $_SESSION["IDusuario"];
$rol = $_SESSION["tipoUsuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

if ($rol == 3) {
    $IDficha = $_SESSION["fichaID"];
    $entregas = $mysql->efectuarConsulta("SELECT trabajos.nombre, entregas.id, entregas.archivo, entregas.fecha_subida, entregas.estado FROM entregas JOIN trabajos ON trabajos.id = entregas.trabajos_id WHERE entregas.aprendices_id = $idUsuario");
} else if ($rol == 2) {
    $trabajos = $mysql->efectuarConsulta("SELECT trabajos.nombre as nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion, trabajos.fecha_limite, fichas.codigo, fichas.nombre as nombre_ficha FROM trabajos JOIN fichas ON fichas.id = trabajos.fichas_id WHERE instructores_id = $idUsuario");
} else {
    $trabajos = $mysql->efectuarConsulta("SELECT trabajos.nombre as nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion, trabajos.fecha_limite, fichas.codigo, fichas.nombre as nombre_ficha FROM trabajos JOIN fichas ON fichas.id = trabajos.fichas_id");
}


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-5">
        <!-- TABLA INDEPENDIENTE -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header py-3 text-center">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-table text-success me-2"></i>
                    Listado de entregas de trabajos
                </h4>
                <?php if ($rol == 2) { ?>
                    <div class="text-center mt-4">
                        <button
                            data-id="<?php echo $idUsuario ?>"
                            type="submit"
                            id="crearTrabajo"
                            name="crearTrabajo"
                            class="btn btn-success fw-bold px-5 py-2 rounded-pill shadow">
                            <i class="fa-solid fa-upload me-2"></i> Crear Trabajo
                        </button>
                    </div>

                <?php } ?>
            </div>

            <div class="card-body table-responsive">

                <table class="table table-striped table-bordered shadow-sm" id="tblGeneral">
                    <thead class="table-dark">
                        <tr>
                            <th>Trabajo</th>
                            <th>Fecha_subida</th>
                            <th>Estado</th>
                            <th>Entrega</th>
                        </tr>
                    </thead>

                    <tbody id="tablaTrabajos">
                        <?php while ($fila = $entregas->fetch_assoc()): ?>
                            <tr>

                                <td><?php echo $fila['nombre']; ?></td>
                                <td><?php echo $fila['fecha_subida']; ?></td>
                                <td><?php echo $fila['estado']; ?></td>              
                                <td><a href="../<?php echo $fila['archivo']; ?>"
                                        target="_blank"
                                        class="btn btn-primary btn-sm">
                                        Ver archivo
                                    </a></td>
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