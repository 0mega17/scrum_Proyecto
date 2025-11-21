<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] == 'crear') {
        $nombreArea = filter_var($_POST['nombreArea'], FILTER_SANITIZE_SPECIAL_CHARS);

        //* verificar si el área ya existe
        $verificarArea = "SELECT id FROM areas WHERE nombre_area = '$nombreArea'";
        $resultadoVerificacion = $mysql->efectuarConsulta($verificarArea);

        if ($resultadoVerificacion && mysqli_num_rows($resultadoVerificacion) > 0) {
            echo json_encode(["status" => "error", "message" => "El área ya está registrada."]);
            exit;
        }

        //* insertar nueva área
        $consulta = "INSERT INTO areas (nombre_area) VALUES ('$nombreArea')";
        $resultado = $mysql->efectuarConsulta($consulta);
        
        if ($resultado) {
            echo json_encode(["status" => "success", "message" => "Área creada correctamente"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear el área"]);
        }
    }
}
$mysql->desconectar();
?>
