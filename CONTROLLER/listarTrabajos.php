<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["idFicha"])) {

        require_once '../MODEL/model.php';
        $mysql = new MySQL();
        $mysql->conectar();

        $idFicha = intval($_POST["idFicha"]);
        $IDinstructor = intval($_SESSION["IDusuario"]); // instructor logueado

        $consulta = $mysql->efectuarConsulta("
            SELECT id, nombre AS nombre_trabajo
            FROM trabajos
            WHERE fichas_id = $idFicha
              AND instructores_id = $IDinstructor
        ");

        $trabajos = [];

        while ($fila = $consulta->fetch_assoc()) {
            $trabajos[] = $fila;
        }

        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($trabajos);
        exit;
    }
}

echo json_encode([]); // si POST llega mal
exit;
