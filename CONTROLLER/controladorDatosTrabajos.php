<?php
header('Content-Type: application/json');
require_once '../MODEL/model.php';
$sql = new MySQL;
$sql->conectar();
$consultaSql = "select trabajos.id ,trabajos.nombre, trabajos.archivo, aprendices.nombre as nombre_aprendis from trabajos inner join aprendices on
 trabajos.aprendices_id = aprendices.id where estadoCalificacion = 'entregado'";
$resultado = $sql->efectuarConsulta($consultaSql);

while ($fila = $resultado->fetch_assoc()) {
    $datos[] = $fila;
}
echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
$sql->desconectar();
