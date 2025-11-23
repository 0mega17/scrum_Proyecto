<?php 

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["IDentrega"]) && !empty($_POST["IDentrega"])){
        require_once '../model/model.php';

        $mysql = new MySQL();
        $mysql->conectar();

        $IDentrega = intval($_POST["IDentrega"]);

        $consultaCalificaciones = $mysql->efectuarConsulta("SELECT calificaciones.calificacion, calificaciones.comentario, calificaciones.fecha_calificacion, instructores.nombre FROM calificaciones JOIN instructores ON instructores.id = calificaciones.instructores_id WHERE calificaciones.entregas_id = $IDentrega");

        $calificaciones = $consultaCalificaciones->fetch_assoc();

        $mysql->desconectar();
        echo json_encode([
            "success" => true,
            "calificaciones" => $calificaciones
        ]);
    }
}



?>