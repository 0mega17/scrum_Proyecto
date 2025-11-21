<?php
session_start();
header('Content-Type: application/json');
$idUsuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();
$mysql->conectar();
//OBTENER LA FECHA LIMITE DEL TRABAJO
$IDusuario = $_POST["IDusuario"];
$IDtrabajo = $_POST["IDtrabajo"];
$resultado = $mysql->efectuarConsulta("SELECT fecha_limite FROM trabajos WHERE id = $IDtrabajo");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if ($row = $resultado->fetch_assoc()) {
        // Asignacion de zona horaria para la fecha correcta
        date_default_timezone_set('America/Bogota');
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
        // Al momento de subir un archivo se verifica su formato 
        $permitidos = [
            'application/pdf' => ".pdf",
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ".docx",
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ".xlsx",
            'image/jpeg' => '.jpg',
            'image/png' => '.png'
        ];
        $tipo = mime_content_type($_FILES['uploadFile']['tmp_name']);


        // En caso de que no cumpla con los formatos mande el ALERTA
        if (!array_key_exists($tipo, $permitidos)) {
            echo json_encode([
                "success" => false,
                "message" => "Tipo de archivo no permitido"
            ]);
            exit();
        } else {
            // Si no agregue el archivo
            $ext = $permitidos[$tipo];
            $nombre_unico = 'archivo_' . date('Ymd_Hisv') . $ext;
            $ruta = 'assets/uploads/' . $nombre_unico;
            $rutaAbsoluta = __DIR__ . '/../' . $ruta;
        }

        // Crear carpeta si no existe
        $carpeta = "../ASSETS/uploads/";
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // En caso de pase las validaciones se sube la imagen al proyecto
        if (move_uploaded_file($_FILES['uploadFile']['tmp_name'], $rutaAbsoluta)) {
            // Insertar en BD
            try {
                $consulta = $mysql->efectuarConsulta("INSERT INTO entregas(archivo, fecha_subida, estado, aprendices_id, trabajos_id) VALUES('$ruta', NOW(), 'Entregado', $IDusuario, $IDtrabajo)");
            } catch (Exception $ex) {
                echo $ex;
            }


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
        } else {
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

    $mysql->desconectar();
}
