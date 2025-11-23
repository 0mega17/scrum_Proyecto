<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["idFicha"]) && isset($_POST["idTrabajo"])) {

        require_once '../MODEL/model.php';
        $mysql = new MySQL();
        $mysql->conectar();

        $idFicha = $_POST["idFicha"];
        $idTrabajo = $_POST["idTrabajo"];

        $consulta = $mysql->efectuarConsulta("SELECT a.nombre AS nombre_aprendiz,e.estado AS estado_entrega,c.calificacion FROM aprendices a INNER JOIN entregas e ON e.aprendices_id = a.id AND e.trabajos_id = '$idTrabajo' INNER JOIN calificaciones c ON c.entregas_id = e.id WHERE a.fichas_id = '$idFicha'");

        $lista = [];

        while ($fila = $consulta->fetch_assoc()) {
            $lista[] = $fila;
        }

        echo json_encode($lista);
    }
}
