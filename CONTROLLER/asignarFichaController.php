<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION["acceso"]) || $_SESSION["acceso"] == false || $_SESSION["tipoUsuario"] != 1) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    
    //* asignar ficha a instructor
    if ($_POST['accion'] == 'asignar') {
        $instructorId = filter_var($_POST['instructorId'], FILTER_SANITIZE_NUMBER_INT);
        $fichaId = filter_var($_POST['fichaId'], FILTER_SANITIZE_NUMBER_INT);
        
        //* se verifica si ya está asignada la ficha al intru
        $verificarAsignacion = "SELECT * FROM fichas_has_instructores WHERE fichas_id = '$fichaId' AND instructores_id = '$instructorId'";
        $resultadoVerificacion = $mysql->efectuarConsulta($verificarAsignacion);
        
        if (mysqli_num_rows($resultadoVerificacion) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'La ficha ya está asignada a este instructor']);
        } else {
            $insertarFichaInstructor = "INSERT INTO fichas_has_instructores (fichas_id, instructores_id) VALUES ('$fichaId', '$instructorId')";
            $resultadoInsercion = $mysql->efectuarConsulta($insertarFichaInstructor);
            
            if ($resultadoInsercion) {
                echo json_encode(['status' => 'success', 'message' => 'Ficha asignada correctamente']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error al asignar la ficha']);
            }
        }
    }
}

$mysql->desconectar();
?>
