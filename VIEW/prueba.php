<?php
session_start();
if (!isset($_SESSION["acceso"]) || $_SESSION["acceso"] == false || $_SESSION["tipoUsuario"] != 3) {
    header("location: login.php");
    exit;
}

require_once '../MODEL/model.php';

$mysql = new MySQL();
$mysql->conectar();

$idAprendiz = $_SESSION["IDusuario"];

$consulta = $mysql->efectuarConsulta("
    SELECT id, nombre, archivo, calificacion, comentario
    FROM trabajos
    WHERE aprendices_id = '$idAprendiz'
");

$mysql->desconectar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Trabajos</title>
    <link rel="stylesheet" href="../ASSETS/CSS/bootstrap.min.css">
</head>

<body class="p-4">

<div class="container mt-4">
    <h3 class="mb-4">Mis Trabajos</h3>

    <div class="card shadow-sm p-3">

        <?php if ($consulta->num_rows == 0) { ?>
            <div class="alert alert-info text-center">
                No tienes trabajos asignados por ahora.
            </div>
        <?php } else { ?>

            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Observación</th>
                        <th>Archivo</th>
                    </tr>
                </thead>
                <tbody>

                <?php while ($t = $consulta->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($t['nombre']) ?></td>

                        <td>
                            <?php if ($t['calificacion'] !== null || $t['comentario'] !== null) { ?>
                                <div>
                                    <strong>Calificación:</strong> 
                                    <?= $t['calificacion'] !== null ? $t['calificacion'] : '<span class="text-muted">Sin calificar</span>' ?>
                                </div>
                                <div>
                                    <strong>Comentario:</strong> 
                                    <?= $t['comentario'] !== null ? htmlspecialchars($t['comentario']) : '<span class="text-muted">Sin comentario</span>' ?>
                                </div>
                            <?php } else { ?>
                                <span class="text-muted">Aún no hay observaciones</span>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if (!empty($t['archivo'])) { ?>
                                <a href="RUTA_DE_TUS_ARCHIVOS/<?= $t['archivo'] ?>" class="btn btn-sm btn-primary" download>
                                    Descargar
                                </a>
                            <?php } else { ?>
                                <span class="text-muted">No disponible</span>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>

                </tbody>
            </table>

        <?php } ?>

    </div>

    <a href="../VIEW/index.php" class="btn btn-secondary mt-3">Volver</a>

</div>

<script src="../ASSETS/JS/bootstrap.bundle.min.js"></script>
</body>
</html>