<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//* se verificar que sea administrador
if (!isset($_SESSION["acceso"]) || $_SESSION["acceso"] == false || $_SESSION["tipoUsuario"] != 1) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    
    //* obtener la lista de instructores para el select
    if ($_POST['accion'] == 'obtenerInstructores') {

        $consultaInstructores = "SELECT id, nombre, email FROM instructores WHERE estado = 'Activo' ORDER BY nombre";
        $resultadoInstructores = $mysql->efectuarConsulta($consultaInstructores);
        
        $instructores = [];

        //* se hace el array para llenar el select
        while ($instructor = mysqli_fetch_assoc($resultadoInstructores)) {
            $instructores[] = $instructor;
        }
        
        echo json_encode(['status' => 'success', 'instructores' => $instructores]);
    }
}

$mysql->desconectar();
?>
