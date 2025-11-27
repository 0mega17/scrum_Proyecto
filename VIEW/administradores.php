<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Administradores";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];


require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

$aprendices = $mysql->efectuarConsulta("SELECT * FROM administradores");

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
                    <i class="fa-brands fa-black-tie text-primary"></i>
                    Gestion de Administradores
                </h1>
                <p class="text-muted">Gestiona todos los administradores del sistema</p>
            </div>

            <div class="mb-2 mb-md-0">
                <a href="./crear_administradores.php" class="btn btn-success px-4 py-2 shadow-sm text-decoration-none">
                    <i class="fas fa-user-plus me-2"></i>
                    Crear administrador
                </a>
            </div>
        </div>


        <div class="card shadow-sm border-0">
            <div class="card-header bg-body-tertiary py-3">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="mb-0">
                            <i class="fas fa-list me-2 text-secondary"></i>
                            Listado de administradores
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
                                <th class="fw-semibold" scope="col">Nombre</th>
                                <th class="fw-semibold" scope="col">Email</th>
                                <th class="fw-semibold" scope="col">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = $aprendices->fetch_assoc()) { ?>
                                <tr>
                                    <td> <?php echo $fila['id'] ?> </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 me-3">
                                                <i class="fas fa-user text-primary"></i>
                                            </div>

                                            <div>
                                                <strong class="d-block text-dark"> <?php echo $fila['nombre'] ?></strong>
                                                <small class="text-muted">ID: <?php echo $fila["id"] ?></small>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <i class="fas fa-envelope me-1"></i>
                                        <?php echo $fila['email'] ?>
                                    </td>
                                    <td class="text-center">
                                        <?php
                                        $estado = $fila['estado'];
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
                            <?php } ?>
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