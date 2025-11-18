<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
require_once '../models/MySQL.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {

    if ($_POST['accion'] == 'crear') {
        $nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_SPECIAL_CHARS);
        $email = $_POST['email'];
        $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $verificarEmail = "SELECT id FROM usuario WHERE email = '$email'";
        $resultadoVerificacion = $mysql->efectuarConsulta($verificarEmail);

        if ($resultadoVerificacion && mysqli_num_rows($resultadoVerificacion) > 0) {
            echo json_encode(["status" => "error", "message" => "El correo electrónico ya está registrado."]);
            exit;
        }

        $consulta = "INSERT INTO Instructores (nombre, email, contrasena) VALUES ('$nombre', '$email', '$password')";
        $resultado = $mysql->efectuarConsulta($consulta);
        if ($resultado) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al crear Instructor"]);
        }
   
    }
}
$mysql->desconectar();
