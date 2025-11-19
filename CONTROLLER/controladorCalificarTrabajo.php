<?php
require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
$calificacion = $_POST['calificacion'];
$comentario = $_POST['comentario'];
$id = $_POST['id'];
if($calificacion >=3){
        $consultaSql = "update trabajos set calificacion = $calificacion,
comentario = '$comentario', estadoCalificacion = 'aprobado' where id = $id";

} else {
        $consultaSql = "update trabajos set calificacion = $calificacion,
comentario = '$comentario', estadoCalificacion = 'desaprovado' where id = $id";
}

$resultado = $mysql->efectuarConsulta($consultaSql);
if($resultado){
    echo json_encode(
        [
            "validacion" => true,
            "mensaje" => "¡ Trabajo calificado !",
        ]
        );
} else{
    echo json_encode(
        [
            "validacion" => false,
            "mensaje" => "¡ Ocurrio un error !",
        ]
        );
}

}


?>