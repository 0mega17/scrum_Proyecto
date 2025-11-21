<?php
// Obtener el nombre del archivo
$archivoActual = basename($_SERVER["PHP_SELF"]);

?>
<div
    class="sidebar border border-right col-md-3 col-lg-2 p-0 bg-body-tertiary">
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
                    <a href="./editar_perfil.php" class="nav-link">
                        <img
                            src="../assets/img/profile.png"
                            class="user-image rounded-circle img-fluid w-50"
                            alt="User Image" />

                    </a>

                </li>
                <li class="nav-item">
                    <a
                        class="nav-link d-flex align-items-center gap-2"
                        href="index.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#house-fill"></use>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <?php if ($rol == 1) { ?>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="instructores.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg>
                            Instructores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="administradores.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg>
                            Administradores
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="aprendices.php">
                            <svg class="bi" aria-hidden="true">
                                <use xlink:href="#people"></use>
                            </svg>
                            Aprendices
                        </a>
                    </li>

                <?php } ?>


                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="./trabajos.php">
                        <i class="bi bi-clipboard2-data-fill"></i>
                        Trabajos
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="./entregas.php">
                        <i class="bi bi-bag-check-fill"></i>
                        Entregas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="fichas.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#people"></use>
                        </svg>
                        fichas
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 active" aria-current="page" href="asignarTrabajo.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#people"></use>
                        </svg>
                        asignar trabajo
                    </a>
                </li>
            </ul>
            <hr class="my-3" />
            <ul class="nav flex-column mb-auto">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2" href="#">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#gear-wide-connected"></use>
                        </svg>
                        Configuración
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center gap-2 btnLogout" href="../CONTROLLER/log_out.php">
                        <svg class="bi" aria-hidden="true">
                            <use xlink:href="#door-closed"></use>
                        </svg>
                        Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>