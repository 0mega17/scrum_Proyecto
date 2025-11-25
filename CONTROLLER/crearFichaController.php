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
        $area = filter_var($_POST['area_ficha'], FILTER_SANITIZE_SPECIAL_CHARS);
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];

        if($codigo<0){
            echo json_encode([
                "success" => false,
                "message" => "El codigo no puede ser negativo"
            ]);
            exit();
        }

        if ($fechaFin < $fechaInicio) {
            echo json_encode([
                "success" => false,
                "message" => "La fecha de fin no puede ser anterior a la fecha de inicio"
            ]);
            exit();
        }

        $verificacionCodigo = $mysql->efectuarConsulta("SELECT 1 FROM fichas WHERE codigo = '$codigo'");

        if (mysqli_num_rows($verificacionCodigo) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "El codigo ya se encuentra registrado"
            ]);
            exit();
        }
        $insertarFicha = $mysql->efectuarConsulta("INSERT INTO fichas (codigo, nombre,fecha_inicio, fecha_fin,area_ficha) VALUES ('$codigo', '$nombre','$fechaInicio', '$fechaFin','$area')");
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
