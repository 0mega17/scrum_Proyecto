<?php
session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$pagina = "Aprendices";
$rol = $_SESSION["tipoUsuario"];
if ($rol == 3) {
    $ficha_id =  $_SESSION["fichaID"];
}
$IDusuario = $_SESSION["IDusuario"];


require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();

if ($rol == 3) {
    $resultado = $mysql->efectuarConsulta("SELECT * FROM aprendices WHERE fichas_id = $ficha_id");
} else {
    $resultado = $mysql->efectuarConsulta("SELECT * FROM aprendices");
}


$mysql->desconectar();


// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';



?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1">
        <h1 class="h2">Aprendices</h1>
    </div>

    <div class="my-2">
        <button class="btn btn-success">
            <a class="nav-link" href="./crear_aprendiz.php"> Crear aprendiz</a>
        </button>
    </div>

    <div class="table-responsive small">
        <table class="table table-striped shadow-sm table-sm nowrap" id="tblGeneral">
            <thead>
                <tr>
                    <th scope="col">Documento</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Email</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($aprendice = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td> <?php echo $aprendice['id'] ?> </td>
                        <td> <?php echo $aprendice['nombre'] ?> </td>
                        <td> <?php echo $aprendice['email'] ?> </td>
                        <td> <?php echo $aprendice['estado'] ?> </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</main>

<?php
require_once './layout/footer.php';
?>