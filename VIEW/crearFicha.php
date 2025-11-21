<?php

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

require_once '../MODEL/model.php';
$pagina = "Crear Ficha";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

$mysql = new MySQL();

$mysql->conectar();


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear Nueva Ficha</h1>
    </div>

    <form id="formCrearFicha" method="POST">
        <h4 class="mb-4">Datos de la ficha</h4>

        <div class="mb-3">
            <label for="codigo" class="form-label">Codigo</label>
            <input type="text" class="form-control" id="codigo" name="codigo" placeholder="Codigo" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
        </div>

        <div class="mb-3">
            <label for="area" class="form-label">Area</label>
            <input type="text" class="form-control" id="area" name="area" placeholder="Area" required>
        </div>

        <div class="mb-3">
            <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
            <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Fecha Inicio" required>
        </div>
        <div class="mb-3">
            <label for="fecha_fin" class="form-label">Fecha Fin</label>
            <input type="date" class="form-control" id="fechaFin" name="fechaFin" placeholder="Fecha Fin" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">
            <i class="fa-duotone fa-regular fa-plus"></i>Crear Ficha
        </button>
    </form>
</main>
<?php
require_once './layout/footer.php';
?>