<?php

$pagina = "Dashboard";

session_start();
if ($_SESSION["acceso"] == false || $_SESSION["acceso"] == null) {
    header('location: ./login.php');
}

$rol = $_SESSION["tipoUsuario"];
$IDusuario = $_SESSION["IDusuario"];


require_once './layout/header.php';
require_once './layout/nav_bar.php';

?>

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

    <!-- Titulo Principal -->
    <div class="pt-4 pb-3 mb-4 border-bottom">
        <h1 class="fw-bold" style="letter-spacing: -0.5px;">Panel Principal</h1>
        <p class="text-muted mb-0">Resumen general del sistema y sus funcionalidades principales.</p>
    </div>
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <h2 class="fw-bold mb-3" style="font-size: 1.8rem;">Sistema de Gestion de Trabajos y Entregas</h2>

            <p class="text-muted" style="font-size: 1.05rem; line-height: 1.6;">
                Este sistema fue desarrollado para optimizar la gestion academica entre instructores y aprendices,
                brindando una plataforma clara, sencilla y eficiente para administrar trabajos, entregas, calificaciones
                y fichas. Su enfoque es mejorar la organizacion y reducir el tiempo invertido en procesos manuales.
            </p>

            <div class="mt-4">
                <h4 class="fw-semibold mb-2" style="font-size: 1.3rem;">Proposito del Sistema</h4>

                <div class="p-3 bg-light rounded-3 border">
                    <ul class="mb-0">
                        <li>Permitir a los instructores publicar trabajos de manera organizada.</li>
                        <li>Hacer que los aprendices puedan subir evidencias de forma facil y segura.</li>
                        <li>Vincular instructores y aprendices a sus respectivas fichas.</li>
                        <li>Almacenar, clasificar y gestionar archivos de entregas.</li>
                        <li>Mostrar tareas entregadas, pendientes o vencidas de forma clara.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="fw-semibold mb-2" style="font-size: 1.3rem;">Integrantes del Proyecto</h4>

                <div class="p-3 bg-light rounded-3 border">
                    <ul class="mb-0">
                        <li><b>Daniel Felipe Navarro</b></li>
                        <li><b>Juan Sebastian Trujillo</b></li>
                        <li><b>Stiven Monsalves</b></li>
                        <li><b>Yerson Estiven</b></li>
                        <li><b>Santiago Gaviria</b></li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="fw-semibold mb-2" style="font-size: 1.3rem;">Funcionalidades Principales</h4>

                <div class="p-3 bg-light rounded-3 border">
                    <ul class="mb-0">
                        <li>Inicio y cierre de sesion por roles.</li>
                        <li>Creacion y administracion de instructores y aprendices.</li>
                        <li>Gestion de fichas o cursos.</li>
                        <li>Asignacion de aprendices y instructores a fichas.</li>
                        <li>Subida de trabajos antes de la fecha limite.</li>
                        <li>Edicion de entregas no calificadas.</li>
                        <li>Edicion de perfil para aprendices.</li>
                        <li>Visualizacion de trabajos segun las fichas asignadas al instructor.</li>
                        <li>Calificacion de trabajos (A o D).</li>
                        <li>Registro de comentarios del instructor.</li>
                        <li>Interfaz simple, clara y responsiva.</li>
                        <li>Consulta de calificaciones y comentarios.</li>
                    </ul>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="fw-semibold mb-2" style="font-size: 1.3rem;">Estado Actual del Proyecto</h4>

                <div class="p-3 bg-light rounded-3 border">
                <p class="fw-semibold text-success" style="font-size: 1.05rem;">Todo fino, todo correcto.</p>
                </div>
            </div>
        </div>
    </div>

</main>
<?php
require_once './layout/footer.php';
?>