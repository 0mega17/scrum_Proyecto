<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["idFicha"])) {

        require_once '../MODEL/model.php';
        $mysql = new MySQL();
        $mysql->conectar();

        $idFicha = $_POST["idFicha"];

        $consulta = $mysql->efectuarConsulta("
            SELECT id, nombre AS nombre_trabajo
            FROM trabajos
            WHERE fichas_id = '$idFicha'
        ");

        $trabajos = [];

        while ($fila = $consulta->fetch_assoc()) {
            $trabajos[] = $fila;
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($trabajos);
    }
}
