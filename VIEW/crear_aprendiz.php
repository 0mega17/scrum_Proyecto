<?php

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

require_once '../MODEL/model.php';
$pagina = "Crear aprendiz";
$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];

$mysql = new MySQL();

$mysql->conectar();

$fichas = $mysql->efectuarConsulta("select id,codigo from fichas");


$mysql->desconectar();

// LAYOUT HTML
require_once './layout/header.php';
require_once './layout/nav_bar.php';


?>
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Crear Nuevo Aprendiz</h1>
    </div>

    <form id="formCrearApreniz">
        <h4 class="mb-4"><i class="bi bi-person-circle me-2"></i> Datos del Aprendiz</h4>


        <!-- //* se le puso pattern para validar solo números -->
        <div class="mb-3">
            <label for="id" class="form-label">Identificacion</label>
            <input type="number" class="form-control" id="id" placeholder="Identificacion" pattern="[0-9]+" title="Solo se permiten números" maxlength="15" required>
            <small class="form-text text-muted">Solo números, sin símbolos ni espacios</small>
        </div>

        <!-- //* se le puso pattern para validar solo letras y espacios -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+" title="Solo se permiten letras y espacios" maxlength="100" required>
            <small class="form-text text-muted">Solo letras y espacios</small>
        </div>

        <!-- //* se le puso pattern para validar formato de correo -->
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" pattern="[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z]+" title="Solo letras, números, @ y punto. Ejemplo: usuario@correo.com" required>
            <small class="form-text text-muted">Solo letras, números, @ y punto (sin símbolos especiales)</small>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
        </div>

        <div>
            <option class="form-label" value="">Elige una ficha...</option>

            <select name="ficha" class="form-select" id="ficha" required>
                <?php while ($ficha = mysqli_fetch_assoc($fichas)): ?>
                    <option value="<?php echo $ficha['id']; ?>"><?php echo $ficha['codigo']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>




        <button type="submit" class="btn btn-success w-100 mt-3">
            <i class="bi bi-person-plus me-2"></i>Crear Aprendiz
        </button>
    </form>
</main>
<?php
require_once './layout/footer.php';
?>