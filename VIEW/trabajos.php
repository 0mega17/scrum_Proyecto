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
    $IDficha = $_SESSION["fichaID"];
    $trabajos = $mysql->efectuarConsulta("
        SELECT 
            trabajos.id,
            trabajos.nombre AS nombre_trabajo,
            trabajos.descripcion,
            trabajos.fecha_publicacion,
            trabajos.fecha_limite,
            fichas.codigo,
            fichas.nombre AS nombre_ficha,
            (SELECT estado 
             FROM entregas 
             WHERE entregas.trabajos_id = trabajos.id 
             AND aprendices_id = $idUsuario 
             LIMIT 1) AS estado_entrega
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
        WHERE trabajos.fichas_id = $IDficha
    ");
} else if ($rol == 2) {
    $trabajos = $mysql->efectuarConsulta("
        SELECT trabajos.nombre AS nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion,
            trabajos.fecha_limite, fichas.codigo, fichas.nombre AS nombre_ficha
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
        WHERE instructores_id = $idUsuario
    ");
} else {
    $trabajos = $mysql->efectuarConsulta("
        SELECT trabajos.nombre AS nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion,
            trabajos.fecha_limite, fichas.codigo, fichas.nombre AS nombre_ficha
        FROM trabajos
        JOIN fichas ON fichas.id = trabajos.fichas_id
    ");
}

$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container mt-5">

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header py-3 text-center">
                <h4 class="fw-bold mb-0">
                    <i class="fa-solid fa-clipboard"></i> Listado de Trabajos
                </h4>

                <?php if ($rol == 2) { ?>
                    <div class="text-center mt-4">
                        <button
                            data-id="<?php echo $idUsuario ?>"
                            type="submit"
                            id="crearTrabajo"
                            name="crearTrabajo"
                            class="btn btn-success fw-bold px-4 py-2 rounded-pill shadow btn-sm">
                            <i class="fa-solid fa-upload me-2"></i> Crear Trabajo
                        </button>
                    </div>
                <?php } ?>
            </div>

            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped shadow-sm table-sm nowrap" id="tblGeneral">
                        <thead class="table-light">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Fecha publicación</th>
                                <th>Fecha límite</th>
                                <th>Ficha</th>

                                <?php if ($rol == 3) { ?>
                                    <th>Acciones</th>
                                <?php } ?>
                            </tr>
                        </thead>

                        <tbody id="tablaTrabajos">
                            <?php while ($fila = $trabajos->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo $fila['nombre_trabajo']; ?></td>
                                    <td><?php echo $fila['descripcion']; ?></td>
                                    <td><?php echo $fila['fecha_publicacion']; ?></td>
                                    <td><?php echo $fila['fecha_limite']; ?></td>
                                    <td><?php echo $fila['codigo']; ?> - <?php echo $fila["nombre_ficha"]; ?></td>

                                    <?php if ($rol == 3): ?>
                                        <td class="text-center">

                                            <?php
                                            $estado = $fila["estado_entrega"] ?? null;
                                            $hoy = date("Y-m-d");
                                            $limite = $fila["fecha_limite"];
                                            $fueraDeTiempo = ($hoy > $limite);
                                            ?>

                                            <?php if ($estado === null): ?>

                                                <?php if ($fueraDeTiempo): ?>
                                                    <button class="btn btn-secondary btn-sm fw-bold" disabled>
                                                        No entregado
                                                    </button>
                                                <?php else: ?>
                                                    <button
                                                        data-IDusuario="<?php echo $idUsuario; ?>"
                                                        data-IDtrabajo="<?php echo $fila["id"]; ?>"
                                                        class="btn btn-primary btn-sm btnSubirArchivo fw-bold mb-1">
                                                        Subir
                                                    </button>
                                                <?php endif; ?>

                                            <?php elseif ($estado === "Entregado"): ?>

                                                <div class="d-flex flex-column flex-sm-row gap-1 justify-content-center">
                                                    <span class="btn btn-warning btn-sm fw-bold" style="cursor: default;">
                                                        Trabajo entregado
                                                    </span>

                                                    <button
                                                        onclick="eliminarTrabajo(<?= $fila['id'] ?>)"
                                                        class="btn btn-danger btn-sm fw-bold">
                                                        Eliminar
                                                    </button>
                                                </div>

                                            <?php elseif ($estado === "Calificado"): ?>

                                                <button class="btn btn-success btn-sm fw-bold" disabled>
                                                    Calificado
                                                </button>

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
