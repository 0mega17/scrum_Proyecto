<?php
session_start();

if (!isset($_SESSION["IDusuario"])) {
    echo json_encode(["status" => "error", "message" => "No autorizado"]);
    exit;
}

$idAprendiz = $_SESSION["IDusuario"];

if (!isset($_POST["IDtrabajo"])) {
    echo json_encode(["status" => "error", "message" => "Falta el ID del trabajo"]);
    exit;
}

$IDtrabajo = $_POST["IDtrabajo"];

require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

$consulta = $mysql->efectuarConsulta("
    SELECT id, archivo
    FROM entregas
    WHERE trabajos_id = $IDtrabajo
      AND aprendices_id = $idAprendiz
    LIMIT 1
");

if ($consulta->num_rows == 0) {
    echo json_encode(["status" => "error", "message" => "No tienes entrega registrada"]);
    exit;
}

$entrega = $consulta->fetch_assoc();
$archivo = $entrega["archivo"];
$idEntrega = $entrega["id"];

$rutaArchivo = "../" . $archivo;

if (file_exists($rutaArchivo)) {
    unlink($rutaArchivo);
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
$nuevaRuta = 'ASSETS/uploads/' . $nombreArchivo;
$rutaAbsoluta = __DIR__ . '/../' . $nuevaRuta;

if (!file_exists("../ASSETS/uploads/")) {
    mkdir("../ASSETS/uploads/", 0777, true);
}

if (!move_uploaded_file($_FILES['uploadFile']['tmp_name'], $rutaAbsoluta)) {
    echo json_encode(["success" => false, "message" => "Error al guardar archivo."]);
    exit();
}

$consultaUpdate = $mysql->efectuarConsulta("UPDATE entregas 
        SET archivo = '$nuevaRuta', fecha_subida = NOW(), estado = 'Entregado'
        WHERE id = $idEntrega");


$mysql->desconectar();

if ($consultaUpdate) {
    echo json_encode(["status" => "ok"]);
}else{
    echo json_encode(["status" => "error"]); 
}
