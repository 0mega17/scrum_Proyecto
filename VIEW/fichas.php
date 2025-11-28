<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Fichas";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];


require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

if ($rol == 1) {
    $fichas = $mysql->efectuarConsulta("SELECT fichas.id,fichas.codigo,fichas.nombre,fichas.fecha_inicio,fichas.fecha_fin,areas.nombre_area FROM fichas INNER JOIN areas ON fichas.area_ficha = areas.id");
}
if ($rol == 2) {
    $fichas = $mysql->efectuarConsulta("SELECT fichas.id,fichas.codigo,fichas.nombre,fichas.fecha_inicio,fichas.fecha_fin,areas.nombre_area FROM fichas INNER JOIN areas ON fichas.area_ficha = areas.id JOIN fichas_has_instructores ON fichas_has_instructores.fichas_id = fichas.id WHERE fichas_has_instructores.instructores_id = $IDusuario");
}


$mysql->desconectar();

require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="container-fluid">


        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
            <div>
                <h1 class="h2">
                    <i class="fa-solid fa-layer-group text-primary"></i>
                    <?php echo ($rol == 1 ? "Gestion de fichas" : "Mis fichas") ?>
                </h1>
                <p class="text-muted">
                    <?php echo ($rol == 1 ? "Administrada todas las fichas del sistema" : "Visualiza todas las fichas a su cargo") ?>
                </p>
            </div>

            <div class="my-2">
                <?php if ($rol == 1) { ?>
                    <a href="./crearFicha.php" class="btn btn-success px-4 py-2 shadow-sm text-decoration-none">
                        <i class="fas fa-user-plus me-2"></i>
                        Crear ficha
                    </a>


                    <!-- //* boton para crear areas -->
                    <button class="btn btn-primary px-4 py-2 shadow-sm" id="btnCrearArea">
                        <i class="fa-solid fa-suitcase"></i>
                        Crear Área
                    </button>

                <?php } ?>
            </div>
        </div>


        <div class="card shadow-sm border-0">
            <div class="card-header bg-body-tertiary py-3">
                <div class="row">
                    <div class="col">
                        <h5 class="m-0">
                            <i class="fas fa-list me-2 text-secondary"></i>
                            Listado de fichas
                        </h5>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped nowrap align-middle" id="tblGeneral">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Codigo</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Area</th>
                                <th scope="col">Fecha de inicio</th>
                                <th scope="col">Fecha Fin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fila = $fichas->fetch_assoc()) { ?>
                                <tr>
                                    <td> <?php echo $fila['codigo'] ?> </td>
                                    <td>
                                        <span class="badge text-bg-secondary px-3 py-2">
                                            <i class="fas fa-graduation-cap me-1"></i>
                                            <?php echo $fila['nombre'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-info px-3 py-2">
                                            <i class="fa-solid fa-suitcase"></i>
                                            <?php echo $fila['nombre_area'] ?>
                                        </span>

                                    </td>
                                    <td>
                                        <span class="badge text-bg-success py-2 px-3">
                                            <?php echo $fila['fecha_inicio'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge text-bg-primary py-2 px-3">
                                            <?php echo $fila['fecha_fin'] ?>
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