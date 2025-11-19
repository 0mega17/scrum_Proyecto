<?php
header('Content-Type: application/json');

require_once '../MODEL/model.php';  // ← CORRECTO

$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['nombre']) && !empty($_POST['nombre'])) {

        // Sanitizar
        $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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
        $consulta = $mysql->efectuarConsulta("
            INSERT INTO trabajos()
        ");

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
}
