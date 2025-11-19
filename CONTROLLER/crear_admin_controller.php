<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] == 'crear') {
        $id = $_POST['id'];
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $_POST['email'];
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);



        $verificarEmail = "SELECT id FROM administradores WHERE email = '$email'";
        $resultadoVerificacion = $mysql->efectuarConsulta($verificarEmail);

        if ($resultadoVerificacion && mysqli_num_rows($resultadoVerificacion) > 0) {
            echo json_encode(["status" => "error", "message" => "El correo electrónico ya está registrado."]);
            exit;
        }


        $verificarId = "SELECT id FROM administradores WHERE id = '$id'";
        $resultadoId = $mysql->efectuarConsulta($verificarId);

        if ($resultadoId && mysqli_num_rows($resultadoId) > 0) {
            echo json_encode(["status" => "error", "message" => "El ID ya está registrado."]);
            exit;
        }

        $consulta = "INSERT INTO administradores (id,nombre, email, password, estado) VALUES ('$id','$nombre', '$email', '$password','Activo')";
        $resultado = $mysql->efectuarConsulta($consulta);
        if ($resultado) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear Instructor"]);
        }
    }
}
$mysql->desconectar();
