<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] == 'crear') {
        $codigo = $_POST['codigo'];
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $area = filter_var($_POST['area'], FILTER_SANITIZE_SPECIAL_CHARS);
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $verificacionCodigo = $mysql->efectuarConsulta("SELECT 1 FROM fichas WHERE codigo = '$codigo'");

        if (mysqli_num_rows($verificacionCodigo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El codigo ya se encuentra registrado"
            ]);
            exit();
        }
        $insertarFicha = $mysql->efectuarConsulta("INSERT INTO fichas (codigo, nombre, area, fecha_inicio, fecha_fin) VALUES ('$codigo', '$nombre', '$area', '$fechaInicio', '$fechaFin')");
        if ($insertarFicha) {
        echo json_encode([
            "status" => "success",
            "message" => "Ficha creada correctamente"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Hubo un problema al crear la ficha"
        ]);
    }
    }
}
$mysql->desconectar();
