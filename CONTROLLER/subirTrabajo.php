<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["IDusuario"])) {
    echo json_encode(["success" => false, "message" => "No hay sesión activa"]);
    exit();
}

$idUsuario = $_SESSION["IDusuario"];

require_once '../MODEL/model.php';

$mysql = new MySQL();
$mysql->conectar();

$IDusuario = $_POST["IDusuario"];
$IDtrabajo = $_POST["IDtrabajo"];

$consultaFecha = $mysql->efectuarConsulta("SELECT fecha_limite FROM trabajos WHERE id = $IDtrabajo");

if ($row = $consultaFecha->fetch_assoc()) {
    date_default_timezone_set('America/Bogota');
    $fechaLimite = $row["fecha_limite"];
    $hoy = date("Y-m-d");

    if ($hoy > $fechaLimite) {
        echo json_encode([
            "success" => false,
            "message" => "La fecha límite ya pasó."
        ]);
        exit();
    }
}

if (!isset($_FILES['uploadFile']) || $_FILES['uploadFile']['error'] != 0) {
    echo json_encode(["success" => false, "message" => "No se recibió archivo."]);
    exit();
}

$permitidos = [
    'application/pdf' => ".pdf",
    'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => ".docx",
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => ".xlsx",
    'image/jpeg' => '.jpg',
    'image/png' => '.png'
];

$tipo = mime_content_type($_FILES['uploadFile']['tmp_name']);

if (!isset($permitidos[$tipo])) {
    echo json_encode(["success" => false, "message" => "Tipo de archivo no permitido"]);
    exit();
}

$ext = $permitidos[$tipo];
$nombreArchivo = 'archivo_' . date('Ymd_His') . $ext;
$ruta = 'ASSETS/uploads/' . $nombreArchivo;
$rutaAbsoluta = __DIR__ . '/../' . $ruta;

if (!file_exists("../ASSETS/uploads/")) {
    mkdir("../ASSETS/uploads/", 0777, true);
}

if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $rutaAbsoluta)) {
    echo json_encode(["success" => false, "message" => "Error al guardar archivo."]);
    exit();
}

// Comprobar si ya existe entrega
$existe = $mysql->efectuarConsulta("
    SELECT id FROM entregas 
    WHERE aprendices_id = $IDusuario AND trabajos_id = $IDtrabajo
");

if ($existe->num_rows > 0) {
    $data = $existe->fetch_assoc();
    $idEntrega = $data["id"];

    $sql = "
        UPDATE entregas 
        SET archivo = '$ruta', fecha_subida = NOW(), estado = 'Entregado'
        WHERE id = $idEntrega
    ";
} else {
    $sql = "
        INSERT INTO entregas(archivo, fecha_subida, estado, aprendices_id, trabajos_id)
        VALUES('$ruta', NOW(), 'Entregado', $IDusuario, $IDtrabajo)
    ";
}

$res = $mysql->efectuarConsulta($sql);

if ($res) {
    echo json_encode(["success" => true, "message" => "Archivo guardado correctamente"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al registrar la entrega"]);
}

$mysql->desconectar();
