<?php
// Obtener el nombre del archivo
$archivoActual = basename($_SERVER["PHP_SELF"]);
$rol = $_SESSION["tipoUsuario"];
?>
<div
    class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary d-md-block">
    <div
        class="offcanvas-md offcanvas-end bg-body-tertiary"
        tabindex="-1"
        id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                Gestion de notas - Proyecto SCRUM
            </h5>
            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="offcanvas"
                data-bs-target="#sidebarMenu"
                aria-label="Close"></button>
        </div>
        <div
            class="offcanvas-body d-md-flex flex-column p-0 pt-lg-3 overflow-y-auto">
            <ul class="nav flex-column">
                <li class="nav-item text-center">
                    <a href="./editar_perfil.php" class="nav-link d-flex flex-column justify-content-center align-items-center">
                        <img
                            src="../assets/img/profile.png"
                            class="user-image rounded-circle img-fluid w-50"
                            alt="User Image" />
                        <span class="badge rounded-pill text-bg-primary"><?php echo $usuario["nombre"] ?> - <?php echo $rolTxt ?></span>
                        <?php if ($rol == 3) { ?>
                            <span class="fw-bold"><?php echo $usuario["nombreFicha"] ?> </span>
                            <small class=""><?php echo $usuario["codigo"] ?> </small>
                        <?php } ?>
                    </a>

                </li>
                <li class="nav-item">
                    <a
                        class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "index.php" ? "active" : "") ?>"
                        href="index.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#house-fill"></use>
                        </svg>
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a
                        class="nav-link d-flex align-items-center gap-2"
                        href="editar_perfil.php">
                        <i class="bi bi-person-fill-gear"></i>
                        Perfil
                    </a>
                </li>

                <?php if ($rol == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "instructores.php" ? "active" : "") ?>" aria-current="page" href="instructores.php">
                            <i class="bi bi-people-fill"></i>
                            Instructores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "administradores.php" ? "active" : "") ?>" aria-current="page" href="administradores.php">
                            <i class="bi bi-people-fill"></i>
                            Administradores
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active <?php echo ($archivoActual == "aprendices.php" ? "active" : "") ?>" aria-current="page" href="aprendices.php">
                            <i class="bi bi-people-fill"></i>
                            Aprendices
                        </a>
                    </li>

                <?php } ?>

                <?php if ($rol == 1 || $rol == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "fichas.php" ? "active" : "") ?>" aria-current="page" href="fichas.php">
                            <i class="bi bi-collection-fill"></i>
                            Fichas
                        </a>
                    </li>
                <?php } ?>

                <?php if ($rol == 3 || $rol == 2 || $rol == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "trabajos.php" ? "active" : "") ?>" aria-current="page" href="./trabajos.php">
                            <i class="bi bi-clipboard2-data-fill"></i>
                            Trabajos
                        </a>
                    </li>
                <?php } ?>

                <?php if ($rol == 3 || $rol == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "entregas.php" ? "active" : "") ?>" aria-current="page" href="./entregas.php">
                            <i class="bi bi-bag-check-fill"></i>
                            Entregas
                        </a>
                    </li>
                <?php } ?>


                <?php if ($rol == 2) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "calificar_trabajo.php" ? "active" : "") ?>" aria-current="page" href="calificar_trabajo.php">
                            <i class="bi bi-folder-symlink-fill"></i>
                            Calificaciones
                        </a>
                    </li>
                <?php } ?>

                <?php if ($rol == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 <?php echo ($archivoActual == "asignarFichas.php" ? "active" : "") ?>" aria-current="page" href="asignarFichas.php">
                            <i class="bi bi-bookmark-plus-fill"></i>
                            </svg>
                            Asignar Fichas
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <hr class="my-3" />
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 btnLogout" href="../CONTROLLER/log_out.php">
                        <i class="bi bi-door-closed-fill"></i>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>