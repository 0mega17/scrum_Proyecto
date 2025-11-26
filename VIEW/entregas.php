<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
date_default_timezone_set("America/Bogota");
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
    <div class="container-fluid mt-2">


        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2 mb-1">
                    <i class="fas fa-inbox text-success me-2"></i>
                    Gestión de Entregas
                </h1>
                <p class="text-muted mb-0">
                    <?php if ($rol == 1): ?>
                        Vista general de todas las entregas del sistema
                    <?php elseif ($rol == 3): ?>
                        Consulta el estado de tus entregas y calificaciones
                    <?php endif; ?>
                </p>
            </div>
        </div>

        <!-- Card con la tabla -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-body-tertiary py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            <i class="fas fa-clipboard-list me-2 text-secondary"></i>
                            Listado de Entregas
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle nowrap" id="tblGeneral">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold">
                                    Instructor
                                </th>
                                <th class="fw-semibold">
                                    Trabajo
                                </th>
                                <th class="fw-semibold text-center">
                                    Fecha Entrega
                                </th>
                                <th class="fw-semibold text-center">
                                    Estado
                                </th>
                                <?php if ($rol == 1): ?>
                                    <th class="fw-semibold">
                                        Aprendiz
                                    </th>
                                <?php endif; ?>
                                <th class="fw-semibold text-center">
                                    Archivo
                                </th>
                                <th class="fw-semibold text-center">
                                    Calificación
                                </th>
                            </tr>
                        </thead>

                        <tbody id="tablaTrabajos">
                            <?php
                            while ($fila = $entregas->fetch_assoc()):
                            ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-pill p-1 bg-primary bg-opacity-10 me-2">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <span class="fw-medium"><?php echo $fila['nombre_instructor'] ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <strong class="text-dark"><?php echo $fila['nombre']; ?></strong>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark px-3 py-2">

                                            <?php echo date('d/m/Y', strtotime($fila['fecha_subida'])); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $estadoClass = '';
                                        $estadoIcon = '';
                                        switch ($fila['estado']) {
                                            case 'Entregado':
                                                $estadoClass = 'bg-success';
                                                $estadoIcon = 'fa-check-circle';
                                                break;
                                            case 'Calificado':
                                                $estadoClass = 'bg-primary';
                                                $estadoIcon = 'fa-star';
                                                break;
                                            default:
                                                $estadoClass = 'bg-secondary';
                                                $estadoIcon = 'fa-clock';
                                        }
                                        ?>
                                        <span class="badge <?php echo $estadoClass; ?> px-3 py-2">
                                            <i class="fas <?php echo $estadoIcon; ?> me-1"></i>
                                            <?php echo $fila['estado']; ?>
                                        </span>
                                    </td>

                                    <?php if ($rol == 1): ?>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-success bg-opacity-10 me-2">
                                                    <i class="fas fa-user-graduate text-success"></i>
                                                </div>
                                                <span><?php echo $fila['nombre_aprendiz'] ?></span>
                                            </div>
                                        </td>
                                    <?php endif; ?>

                                    <td class="text-center">
                                        <a href="../<?php echo $fila['archivo']; ?>"
                                            target="_blank"
                                            class="btn btn-primary btn-sm shadow-sm"
                                            data-bs-toggle="tooltip"
                                            title="Descargar archivo">
                                            <i class="fa-solid fa-file-download me-1"></i>
                                            Ver Archivo
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($fila["calificado"] == 0): ?>
                                            <span class="badge bg-warning text-dark px-3 py-2">
                                                <i class="fas fa-hourglass-half me-1"></i>
                                                Sin calificar
                                            </span>
                                        <?php else: ?>
                                            <button
                                                onclick="verCalificacion(<?php echo $fila['id'] ?>)"
                                                class="btn btn-info btn-sm shadow-sm btnCalificacion"
                                                title="Ver calificación">
                                                <i class="fa-solid fa-eye me-1"></i>
                                                Ver Nota
                                            </button>
                                        <?php endif; ?>
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