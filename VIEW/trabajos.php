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
    $trabajos = $mysql->efectuarConsulta("SELECT trabajos.id, trabajos.nombre as nombre_trabajo, trabajos.descripcion, trabajos.fecha_publicacion, trabajos.fecha_limite, fichas.codigo, fichas.nombre as nombre_ficha,
    (SELECT COUNT(*) FROM entregas WHERE entregas.trabajos_id = trabajos.id AND aprendices_id = $idUsuario) as entregado FROM trabajos JOIN fichas ON fichas.id = trabajos.fichas_id WHERE trabajos.fichas_id = $IDficha");
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
                    Listado de trabajos
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
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Fecha publicacion</th>
                            <th>Fecha limite</th>
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
                                <td><?php echo $fila['codigo']; ?> - <?php echo $fila["nombre_ficha"] ?></td>
                                <?php if ($rol == 3) { ?>
                                    <?php if ($fila["entregado"] == 0) { ?>
                                        <td>
                                            <button
                                                data-IDusuario="<?php echo $idUsuario ?>"
                                                data-IDtrabajo="<?php echo $fila["id"] ?>"
                                                id="btnSubirArchivo" class="btn btn-primary btn-sm btnSubirArchivo fw-bold">Subir</button>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <button
                                                data-IDusuario="<?php echo $idUsuario ?>"
                                                data-IDtrabajo="<?php echo $fila["id"] ?>"
                                                id="btnSubirArchivo" class="btn btn-warning btn-sm btnSubirArchivo fw-bold">Editar</button>
                                        </td>
                                    <?php } ?>
                                <?php } ?>
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