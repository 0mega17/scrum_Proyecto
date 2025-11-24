<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
$pagina = "Instructores";
$rol = $_SESSION["tipoUsuario"];
if ($rol == 3) {
    $ficha_id =  $_SESSION["fichaID"];
}

$IDusuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

if ($rol == 3) {
    $instructores = $mysql->efectuarConsulta("SELECT * FROM instructores JOIN fichas_has_instructores ON 
    fichas_has_instructores.instructores_id = instructores.id WHERE fichas_id = $ficha_id");
} else {
    $instructores = $mysql->efectuarConsulta("SELECT * FROM instructores");
}


$mysql->desconectar();


// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';



?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Instructores</h1>
    </div>

    <div class="my-2">
        <button class="btn btn-success">
            <a class="nav-link" href="./crear_instructores.php"> Crear instructor</a>
        </button>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped table-bordered shadow-sm table-sm nowrap" id="tblGeneral">
            <thead>
                <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($fila = $instructores->fetch_assoc()) { ?>
                    <tr>
                        <td> <?php echo $fila['id'] ?> </td>
                        <td> <?php echo $fila['nombre'] ?> </td>
                        <td> <?php echo $fila['email'] ?> </td>
                        <td> <?php echo $fila['estado'] ?> </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>