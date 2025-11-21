<?php

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}
$pagina = "Crear instructores";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];
require_once '../MODEL/model.php';

$mysql = new MySQL();

$mysql->conectar();
$areas = $mysql->efectuarConsulta("SELECT * FROM areas");

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';
?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear nuevo instructor</h1>
    </div>

    <form id="formCrearInstructores">
        <h4 class="mb-4"><i class="bi bi-person-circle me-2"></i> <small>Datos del instructor</small></h4>

        <div class="mb-3">
            <label for="id" class="form-label">Identificacion</label>
            <input type="text" class="form-control" id="id" placeholder="Identificacion" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
        </div>
        <div class="mb-3">
        <select class="form-control" name="area_instructor" id="area_instructor">
            <option value="">Seleccione un área</option>
            <?php
            while ($row = $areas->fetch_assoc()) {
                echo '<option value="' . $row['id'] . '">' . $row['nombre_area'] . '</option>';
            }
            ?>
        </select>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-3">
            <i class="bi bi-person-plus me-2"></i>Crear Instructor
        </button>
    </form>
</main>

<?php
require_once './layout/footer.php';
?>