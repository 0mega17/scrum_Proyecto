<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Asignar Trabajos";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

$aprendices = $mysql->efectuarConsulta("SELECT * FROM fichas");

$mysql->desconectar();


// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Calificaciones</h1>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">Aprendiz</th>
                    <th scope="col">Trabajo</th>
                    <th scope="col">Archivo</th>
                    <th scope="col">Comentario</th>
                    <th scope="col">Calificacion</th>
                </tr>
            </thead>
            <tbody id="datosCalificaciones">

            </tbody>
        </table>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>