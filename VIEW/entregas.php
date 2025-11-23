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

if ($rol == 1) {
    $entregas = $mysql->efectuarConsulta("SELECT aprendices.nombre as nombre_aprendiz, instructores.nombre as nombre_instructor, trabajos.nombre, entregas.id, entregas.archivo, entregas.fecha_subida, entregas.estado, (SELECT COUNT(*) FROM calificaciones WHERE calificaciones.entregas_id = entregas.id) as calificado FROM entregas JOIN trabajos ON trabajos.id = entregas.trabajos_id JOIN instructores ON instructores.id = trabajos.instructores_id JOIN aprendices ON aprendices.id = entregas.aprendices_id ORDER BY entregas.id DESC");
}

if ($rol == 3) {
    $IDficha = $_SESSION["fichaID"];
    $entregas = $mysql->efectuarConsulta("SELECT instructores.nombre as nombre_instructor, trabajos.nombre, entregas.id, entregas.archivo, entregas.fecha_subida, entregas.estado, (SELECT COUNT(*) FROM calificaciones WHERE calificaciones.entregas_id = entregas.id) as calificado FROM entregas JOIN trabajos ON trabajos.id = entregas.trabajos_id JOIN instructores ON instructores.id = trabajos.instructores_id WHERE entregas.aprendices_id = $idUsuario ORDER BY entregas.id DESC");
}


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-2">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
            <h1 class="fs-2 fw-semibold">Listado de entregas</h1>
        </div>

        <div class="table-responsive small">

            <table class="table table-striped table-bordered table-sm shadow-sm nowrap" id="tblGeneral">
                <thead class="">
                    <tr>
                        <th>Instructor</th>
                        <th>Trabajo</th>
                        <th>Fecha_subida</th>
                        <th>Estado</th>
                        <?php if ($rol == 1) { ?>
                            <th>Aprendiz</th>
                        <?php } ?>
                        <th>Entrega</th>
                        <th>Calificacion</th>
                    </tr>
                </thead>

                <tbody id="tablaTrabajos">
                    <?php while ($fila = $entregas->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $fila['nombre_instructor'] ?></td>
                            <td><?php echo $fila['nombre']; ?></td>
                            <td><?php echo $fila['fecha_subida']; ?></td>
                            <td><?php echo $fila['estado']; ?></td>
                            <?php if ($rol == 1) { ?>
                                <td><?php echo $fila['nombre_aprendiz'] ?></td>
                            <?php } ?>
                            <td><a href="../<?php echo $fila['archivo']; ?>"
                                    target="_blank"
                                    class="btn btn-primary btn-sm fw-bold">
                                    Ver archivo
                                </a></td>
                            <td>
                                <?php if ($fila["calificado"] == 0) { ?>
                                    <span class="badge text-bg-warning text-black p-2 rounded-pill">Sin calificar</span>
                                <?php } else { ?>
                                    <button onclick="verCalificacion(<?php echo $fila['id'] ?>)" class="btn btn-info btn-sm btnCalificacion">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                <?php } ?>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                </tbody>

            </table>

        </div>

    </div>
    </div>

    </div>
</main>
<?php
require_once './layout/footer.php';
?>