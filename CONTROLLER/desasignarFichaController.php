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
    
    //* desasignar ficha de instructor
    if ($_POST['accion'] == 'desasignar') {
        $instructorId = filter_var($_POST['instructorId'], FILTER_SANITIZE_NUMBER_INT);
        $fichaId = filter_var($_POST['fichaId'], FILTER_SANITIZE_NUMBER_INT);
        
        $eliminarAsignacion = "DELETE FROM fichas_has_instructores WHERE fichas_id = '$fichaId' AND instructores_id = '$instructorId'";
        $resultadoEliminacion = $mysql->efectuarConsulta($eliminarAsignacion);
        
        if ($resultadoEliminacion) {
            echo json_encode(['status' => 'success', 'message' => 'Ficha desasignada correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al desasignar la ficha']);
        }
    }
}

$mysql->desconectar();
?>
