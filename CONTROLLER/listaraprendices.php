<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["idFicha"]) && !empty($_POST["idFicha"])) {
        require_once '../MODEL/model.php';

        // Conexion a la base de datos
        $mysql = new MySQL();
        $mysql->conectar();
        $idFicha = $_POST["idFicha"];


        // Fichas asociadas al instructor
        $consultafichas = $mysql->efectuarConsulta("SELECT a.id AS id_aprendiz,a.nombre AS nombre_aprendiz,e.estado AS estado_entrega,c.calificacion AS calificacion,c.comentario,c.fecha_calificacion FROM aprendices a INNER JOIN entregas e ON e.aprendices_id = a.id INNER JOIN calificaciones c ON c.entregas_id = e.id WHERE a.fichas_id = '$idFicha'");


        $aprendices = [];

        // Ciclo para llenar el arreglo
        while ($fila = $consultafichas->fetch_assoc()) {
            $aprendices[] = $fila;
        }


        // Envio de la informacion
        header('Content-Type: application/json');
        echo json_encode($aprendices);
    }
}
