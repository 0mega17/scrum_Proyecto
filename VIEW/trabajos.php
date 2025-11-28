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
    $consultaFicha = $mysql->efectuarConsulta("SELECT fichas_id FROM aprendices WHERE id = $idUsuario");
    $IDficha = $consultaFicha->fetch_assoc()["fichas_id"];
    $trabajos = $mysql->efectuarConsulta("
        SELECT 
            trabajos.id,
            trabajos.nombre AS nombre_trabajo,
            trabajos.descripcion,
            trabajos.fecha_publicacion,
            trabajos.fecha_limite,
            fichas.codigo,
            fichas.nombre AS nombre_ficha,
            instructores.nombre as nombre_instructor,
            (SELECT estado 
             FROM entregas 
             WHERE entregas.trabajos_id = trabajos.id 
             AND aprendices_id = $idUsuario 
             LIMIT 1) AS estado_entrega,
             (SELECT archivo FROM entregas 
             WHERE entregas.trabajos_id = trabajos.id
             AND aprendices_id = $idUsuario) as archivo_entrega
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
        JOIN instructores ON instructores.id = trabajos.instructores_id
        WHERE trabajos.fichas_id = $IDficha
        ORDER BY trabajos.id DESC
    ");
} else if ($rol == 2) {
    $trabajos = $mysql->efectuarConsulta("
        SELECT trabajos.nombre AS nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion,
            trabajos.fecha_limite, fichas.codigo, fichas.nombre AS nombre_ficha
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
        WHERE instructores_id = $idUsuario
        ORDER BY trabajos.id DESC
    ");
} else {
    $trabajos = $mysql->efectuarConsulta("
        SELECT trabajos.nombre AS nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion,
            trabajos.fecha_limite, fichas.codigo, fichas.nombre AS nombre_ficha, instructores.nombre as 
            nombre_instructor
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
        JOIN instructores ON instructores.id = trabajos.instructores_id
        ORDER BY trabajos.id DESC
    ");
}

$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container-fluid mt-2">


        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2 mb-1">
                    <i class="fas fa-tasks text-primary me-2"></i>
                    Gestión de Trabajos
                </h1>
                <p class="text-muted mb-0">
                    <?php if ($rol == 3): ?>
                        Consulta y entrega tus trabajos asignados
                    <?php elseif ($rol == 2): ?>
                        Administra los trabajos de tus fichas
                    <?php else: ?>
                        Vista general de todos los trabajos
                    <?php endif; ?>
                </p>
            </div>

            <?php if ($rol == 2): ?>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button
                        data-id="<?php echo $idUsuario ?>"
                        type="button"
                        id="crearTrabajo"
                        name="crearTrabajo"
                        class="btn btn-primary px-4 py-2 shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>
                        Crear Trabajo
                    </button>
                </div>
            <?php endif; ?>
        </div>

        <!-- Card con la tabla -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-body-tertiary py-3">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-secondary"></i>
                    Listado de Trabajos
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0" id="tblGeneral">
                        <thead class="table-light">
                            <tr class="p-1">
                                <?php if ($rol == 3 || $rol == 1): ?>
                                    <th class="fw-semibold">
                                        Instructor
                                    </th>
                                <?php endif; ?>
                                <th class="fw-semibold">
                                    Nombre
                                </th>
                                <th class="fw-semibold">
                                    Descripción
                                </th>
                                <th class="fw-semibold text-center">
                                    Publicación
                                </th>
                                <th class="fw-semibold text-center">
                                    Límite
                                </th>
                                <th class="fw-semibold">
                                    Ficha
                                </th>
                                <?php if ($rol == 3): ?>
                                    <th class="fw-semibold text-center">
                                        Acciones
                                    </th>
                                <?php endif; ?>
                            </tr>
                        </thead>

                        <tbody id="tablaTrabajos">
                            <?php while ($fila = $trabajos->fetch_assoc()): ?>
                                <tr>
                                    <?php if ($rol == 3 || $rol == 1): ?>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="p-1 bg-primary bg-opacity-10 me-2">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <span class="fw-medium"><?php echo $fila['nombre_instructor'] ?></span>
                                            </div>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <strong class="text-dark"><?php echo $fila['nombre_trabajo']; ?></strong>
                                    </td>
                                    <td>
                                        <span class="text-muted">
                                            <?php echo $fila['descripcion']; ?>

                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-dark p-2">
                                            <?php echo $fila['fecha_publicacion']; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $hoy = date("Y-m-d");
                                        $limite = $fila["fecha_limite"];
                                        $fueraDeTiempo = ($hoy > $limite);
                                        ?>
                                        <span class="badge <?php echo $fueraDeTiempo ? 'bg-danger' : 'bg-warning text-dark'; ?> p-2">
                                            <?php echo $fila['fecha_limite']; ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary bg-opacity-25 text-dark px-3 py-2">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            <?php echo $fila['codigo']; ?> - <?php echo $fila["nombre_ficha"]; ?>
                                        </span>
                                    </td>

                                    <?php if ($rol == 3): ?>
                                        <td class="text-center">
                                            <?php
                                            $estado = $fila["estado_entrega"] ?? null;
                                            ?>

                                            <?php if ($estado === null): ?>
                                                <?php if ($fueraDeTiempo): ?>
                                                    <span class="badge bg-danger px-3 py-2">
                                                        <i class="fa-solid fa-circle-xmark me-1"></i>
                                                        No entregado
                                                    </span>
                                                <?php else: ?>
                                                    <button
                                                        data-IDusuario="<?php echo $idUsuario; ?>"
                                                        data-IDtrabajo="<?php echo $fila["id"]; ?>"
                                                        class="btn btn-success btn-sm btnSubirArchivo px-3 shadow-sm">
                                                        <i class="fa-solid fa-upload me-1"></i>
                                                        Subir
                                                    </button>
                                                <?php endif; ?>

                                            <?php elseif ($estado === "Entregado"): ?>
                                                <?php if ($fueraDeTiempo): ?>
                                                    <button
                                                        onclick="editarTrabajo(<?= $fila['id'] ?>, <?= $idUsuario ?>)"
                                                        class="btn btn-secondary btn-sm px-3 shadow-sm" disabled>
                                                        <i class="fa-solid fa-pen-to-square me-1"></i>
                                                        Editar
                                                    </button>
                                                <?php else: ?>
                                                    <button
                                                        onclick="editarTrabajo(<?= $fila['id'] ?>, <?= $idUsuario ?>)"
                                                        class="btn btn-primary btn-sm px-3 shadow-sm">
                                                        <i class="fa-solid fa-pen-to-square me-1"></i>
                                                        Editar
                                                    </button>
                                                <?php endif; ?>

                                            <?php elseif ($estado === "Calificado"): ?>
                                                <span class="badge bg-success px-3 py-2">
                                                    <i class="fa-solid fa-check-circle me-1"></i>
                                                    Calificado
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
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
$archivoActual = "trabajos.php";
require_once './layout/footer.php';
?>