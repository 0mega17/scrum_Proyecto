<?php
session_start();
header('Content-Type: application/json');

// Verificar que el usuario esté autenticado y sea administrador
if (!isset($_SESSION["acceso"]) || $_SESSION["acceso"] == false || $_SESSION["tipoUsuario"] != 1) {
    echo json_encode([
        'success' => false,
        'message' => 'No tienes permisos para realizar esta acción'
    ]);
    exit();
}

require_once '../MODEL/model.php';

//* se obtienen la fichas para el select del modal
if (isset($_GET['action']) && $_GET['action'] === 'obtenerFichas') {
    $mysql = new MySQL();
    $mysql->conectar();
    
    $resultado = $mysql->efectuarConsulta("SELECT id, codigo FROM fichas ORDER BY codigo");
    
    $fichas = [];
    while ($ficha = $resultado->fetch_assoc()) {
        $fichas[] = $ficha;
    }
    
    $mysql->desconectar();  
    
    echo json_encode([
        'success' => true,
        'fichas' => $fichas
    ]);
    exit();
}

//* funcion para actualizar la fihca del aprendiz
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aprendizId = isset($_POST['aprendizId']) ? $_POST['aprendizId'] : 0;
    $nuevaFichaId = isset($_POST['fichaId']) ? $_POST['fichaId'] : 0;
    
    if ($aprendizId <= 0 || $nuevaFichaId <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Datos inválidos'
        ]);
        exit();
    }
    
    $mysql = new MySQL();
    $mysql->conectar();
    
    $consulta = "UPDATE aprendices SET fichas_id = $nuevaFichaId WHERE id = $aprendizId";
    $resultado = $mysql->efectuarConsulta($consulta);
    
    if ($resultado) {

        $fichaResult = $mysql->efectuarConsulta("SELECT nombre FROM fichas WHERE id = $nuevaFichaId");
        $ficha = $fichaResult->fetch_assoc();
        
        echo json_encode([
            'success' => true,
            'message' => 'Ficha actualizada correctamente',
            'nombreFicha' => $ficha['nombre']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar la ficha'
        ]);
    }
    
    $mysql->desconectar();
    exit();
}

echo json_encode([
    'success' => false,
    'message' => 'Método no permitido'
]);
?>
