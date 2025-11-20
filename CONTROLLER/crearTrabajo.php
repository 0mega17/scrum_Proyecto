<?php
header('Content-Type: application/json');

require_once '../MODEL/model.php';  
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST["nombreActividad"]) && !empty($_POST["nombreActividad"]) &&
        isset($_POST["descripcion"]) && !empty($_POST["descripcion"]) &&
        isset($_POST["fechaLimite"]) && !empty($_POST["fechaLimite"]) &&
        isset($_POST["ficha"]) && !empty($_POST["ficha"])
    ) {

        // Capturar los datos
        $IDinstructor = filter_var($_POST["IDinstructor"], FILTER_SANITIZE_NUMBER_INT);
        $nombreActividad = filter_var(trim($_POST["nombreActividad"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $descripcion = filter_var(trim($_POST["descripcion"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $fechaLimite = filter_var(trim($_POST["fechaLimite"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ficha = filter_var(trim($_POST["ficha"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        // Insertar en la BD
        $insertTrabajos = $mysql->efectuarConsulta("INSERT INTO trabajos(nombre, descripcion, fecha_publicacion, fecha_limite, instructores_id, fichas_id) VALUES('$nombreActividad', '$descripcion', NOW(), '$fechaLimite', $IDinstructor, $ficha)");


        if($insertTrabajos){
            echo json_encode([
                "success" => true,
                "message" => "Trabajo agregado exitosamente"
            ]);
        }
    }else{
        echo json_encode([
            "success" => false,
            "message" => "Todos los campos son obligatorios"
        ]);
    }
}
