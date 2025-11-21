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

$fichas = $mysql->efectuarConsulta("SELECT * FROM fichas");

$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Fichas</h1>
    </div>
    <div class="my-2">
        <?php if ($rol == 1) { ?>
        <button class="btn btn-success">
            <a class="nav-link" href="./crearFicha.php"> Crear Ficha</a>
        </button>
        <?php } ?>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">codigo</th>
                    <th scope="col">nombre</th>
                    <th scope="col">area</th>
                    <th scope="col">Fecha de inicio</th>
                    <th scope="col">Fecha Fin</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $fichas->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $fila['id'] ?> </td>
                        <td> <?php echo $fila['codigo'] ?> </td>
                        <td> <?php echo $fila['nombre'] ?> </td>
                        <td> <?php echo $fila['area'] ?> </td>
                        <td> <?php echo $fila['fecha_inicio'] ?> </td>
                        <td> <?php echo $fila['fecha_fin'] ?> </td>
                    </tr>



                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>