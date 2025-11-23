<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["IDinstructor"]) && !empty($_POST["IDinstructor"])) {
        require_once '../MODEL/model.php';

        // Conexion a la base de datos
        $mysql = new MySQL();
        $mysql->conectar();
        $IDinstructor = $_POST["IDinstructor"];


        // Fichas asociadas al instructor
        $consultafichas = $mysql->efectuarConsulta("SELECT fichas.id, fichas.codigo, fichas.nombre FROM fichas_has_instructores JOIN fichas ON fichas.id = fichas_has_instructores.fichas_id WHERE instructores_id = $IDinstructor");


        $fichas = [];

        // Ciclo para llenar el arreglo
        while ($fila = $consultafichas->fetch_assoc()) {
            $fichas[] = $fila;
        }


        // Envio de la informacion
        header('Content-Type: application/json');
        echo json_encode($fichas);
    }
}
