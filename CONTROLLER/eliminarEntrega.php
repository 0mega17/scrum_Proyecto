<?php
session_start();

if (!isset($_SESSION["IDusuario"])) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}

$idAprendiz = $_SESSION["IDusuario"];

if (!isset($_POST["idTrabajo"])) {
    echo json_encode(["status" => "error", "message" => "Falta el ID del trabajo"]);
    exit;
}

$idTrabajo = $_POST["idTrabajo"];

require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

$consulta = $mysql->efectuarConsulta("
    SELECT id, archivo
    FROM entregas
    WHERE trabajos_id = $idTrabajo
      AND aprendices_id = $idAprendiz
    LIMIT 1
");

if ($consulta->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "No tienes entrega registrada"]);
    exit;
}

$entrega = $consulta->fetch_assoc();
$archivo = $entrega["archivo"];
$idEntrega = $entrega["id"];

$rutaArchivo = "../uploads/" . $archivo;

if (file_exists($rutaArchivo)) {
    unlink($rutaArchivo);
}

$mysql->efectuarConsulta("DELETE FROM entregas WHERE id = $idEntrega");

$mysql->desconectar();

echo json_encode(["status" => "ok"]);
