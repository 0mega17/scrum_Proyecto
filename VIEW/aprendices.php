<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
$pagina = "Aprendices";
$rol = $_SESSION["tipoUsuario"];
if ($rol == 3) {
    $ficha_id = $_SESSION["fichaID"];
}
$IDusuario = $_SESSION["IDusuario"];
require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();


$resultado = $mysql->efectuarConsulta("SELECT * FROM aprendices");

$mysql->desconectar();
// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container-fluid mt-2">

        <!-- Header Section-->
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2 mb-1">
                    <i class="fas fa-user-graduate text-primary me-2"></i>
                    Gestión de Aprendices
                </h1>
                <p class="text-muted mb-0">
                        Administra todos los aprendices del sistema
                </p>
            </div>

            <div class="mb-2 mb-md-0">
                <a href="./crear_aprendiz.php" class="btn btn-success px-4 py-2 shadow-sm text-decoration-none">
                    <i class="fas fa-user-plus me-2"></i>
                    Crear Aprendiz
                </a>
            </div>
        </div>

        <!-- Card con la tabla -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-secondary"></i>
                            Listado de Aprendices
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0 align-middle" id="tblGeneral">
                        <thead class="table-light">
                            <tr>
                                <th class="fw-semibold" scope="col">Documento</th>
                                <th class="fw-semibold" scope="col">Nombre Completo</th>
                                <th class="fw-semibold" scope="col">Email</th>
                                <th class="fw-semibold text-center" scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            while ($aprendiz = mysqli_fetch_assoc($resultado)):
                            ?>
                                <tr>
                                    <td>
                                        <?php echo $aprendiz['id'] ?>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>
                                            <div>
                                                <strong class="text-dark d-block"><?php echo $aprendiz['nombre'] ?></strong>
                                                <small class="text-muted">ID: <?php echo $aprendiz['id'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope me-1"></i>
                                        <?php echo $aprendiz['email'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $estado = $aprendiz['estado'];
                                        $estadoLower = strtolower($estado);
                                        $badgeClass = '';
                                        $iconClass = '';

                                        if ($estadoLower === 'activo') {
                                            $badgeClass = 'bg-success';
                                            $iconClass = 'fa-check-circle';
                                        } else if ($estadoLower === 'inactivo') {
                                            $badgeClass = 'bg-danger';
                                            $iconClass = 'fa-times-circle';
                                        } else {
                                            $badgeClass = 'bg-secondary';
                                            $iconClass = 'fa-question-circle';
                                        }
                                        ?>
                                        <span class="badge <?php echo $badgeClass; ?> px-3 py-2">
                                            <i class="fas <?php echo $iconClass; ?> me-1"></i>
                                            <?php echo $estado; ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer de la tabla -->
            <div class="card-footer bg-light py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            <?php if ($rol == 3): ?>
                                Mostrando aprendices de su ficha
                            <?php else: ?>
                                Mostrando todos los aprendices del sistema
                            <?php endif; ?>
                        </small>
                    </div>
                    <div class="col-auto">
                        <small class="text-muted">
                            <i class="fas fa-clock me-1"></i>
                            Actualizado: <?php echo date('d/m/Y H:i'); ?>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
require_once './layout/footer.php';
?>