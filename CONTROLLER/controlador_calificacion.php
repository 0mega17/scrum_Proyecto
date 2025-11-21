<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once '../MODEL/model.php';
header('Content-Type: application/json');
$mysql = new MySQL();
$mysql->conectar();
$idUsuario =   $_SESSION["IDusuario"];
if (
    $_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['calificacion']) && !empty($_POST['calificacion'])
    && isset($_POST['comentario']) && isset($_POST['id'])
    && !empty($_POST['id'])
) {

    // aqui lo que se hace es capturar los datos que bienen del formulario de calificaciones para poder hacer el insert en la base de datos :3

    $comentario = filter_var($_POST['comentario'], FILTER_SANITIZE_SPECIAL_CHARS);
    $calificacion = $_POST['calificacion'];
    $idEntrega = $_POST['id'];
    // aqui se debe de hacer la validacion para que no deje hacer el insert si la 
    // calificacion no tiene descripcion :3 
    if (empty(trim($comentario))){
        echo json_encode([
            "validacion" => false,
            "mensaje" => "Debe de llenar el comentario de la calificacion"
        ]);
        exit();
    }
    $consultaCalificacion = "insert into calificaciones values ('','$calificacion','$comentario',  CURDATE() , '$idUsuario', '$idEntrega')";
    $resultado = $mysql->efectuarConsulta($consultaCalificacion);
    
    if ($resultado) {
        // si se hace correctamaente todo lo que pasa ahora es que se debe de hacer un update en la base de datos para que no
        // muestre
        echo json_encode([
            "validacion" => true,
            "mensaje" => "Calificacion realizada correctamente",
        ]);
    } else {
        echo json_encode([
            "validacion" => false,
            "mensaje" => "! No se pudo realizar la calificacion ¡",
        ]);
    }
}
