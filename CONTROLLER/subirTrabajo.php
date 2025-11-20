<?php
session_start();
header('Content-Type: application/json');
$idUsuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php'; 

$mysql = new MySQL();
$mysql->conectar();
 //OBTENER LA FECHA LIMITE DEL TRABAJO
    $resultado = $mysql->efectuarConsulta("
        SELECT fecha_limite 
        FROM trabajos 
        WHERE aprendices_id = $idUsuario
    ");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($row = $resultado->fetch_assoc()) {
        $fechaLimite = $row["fecha_limite"];
        $hoy = date("Y-m-d H:i:s");

        //VALIDAR FECHA
        if ($hoy > $fechaLimite) {
            echo json_encode([
                "success" => false,
                "message" => "La fecha límite ha pasado, no puedes subir el archivo."
            ]);
            exit();
        }
    }
    // Verificar si se envió archivo
    if (isset($_FILES['uploadFile']) && $_FILES['uploadFile']['error'] === UPLOAD_ERR_OK) {

        // Extensiones permitidas
        $extPermitidas = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg'];

        // Obtener extensión real
        $ext = strtolower(pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $extPermitidas)) {
            echo json_encode([
                "success" => false,
                "message" => "Tipo de archivo no permitido"
            ]);
            exit();
        }

        // Crear carpeta si no existe
        $carpeta = "uploads/";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Nuevo nombre único
        $nombreArchivo = uniqid() . "." . $ext;
        $destino = $carpeta . $nombreArchivo;

        // Mover archivo
        if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $destino)) {
            echo json_encode([
                "success" => false,
                "message" => "Error al subir el archivo"
            ]);
            exit();
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No se recibió ningún archivo"
        ]);
        exit();
    }

    // Insertar en BD
    $consulta = $mysql->efectuarConsulta("UPDATE trabajos SET archivo = '$nombreArchivo', estadoCalificacion = 'Entregado' WHERE aprendices_id = $idUsuario");

    if ($consulta) {
        echo json_encode([
            "success" => true,
            "message" => "Archivo subido correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Error al guardar el registro"
        ]);
    }

    $mysql->desconectar();
}
