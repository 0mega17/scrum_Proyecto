<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST["nombre"]) && !empty($_POST["nombre"])
        &&  isset($_POST["email"]) && !empty($_POST["email"])
    ) {
        require_once '../MODEL/model.php';

        $mysql = new MySQL();

        $mysql->conectar();

        $idUsuario = $_SESSION['IDusuario'];

        $nombre = filter_var(trim($_POST["nombre"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $ID = filter_var(trim($_POST["ID"]), FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $rol = filter_var($_POST["rol"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un email válido"
            ]);
            exit();
        }

        $verificacionEmail = $mysql->efectuarConsulta("SELECT 1 FROM $rol WHERE email = '$email' AND id != $idUsuario");

        if (mysqli_num_rows($verificacionEmail) > 0) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese un email que no esté repetido"
            ]);
            exit();
        }

        $passwordBD = $mysql->efectuarConsulta("SELECT password FROM $rol WHERE id = $idUsuario");
        $passwordBD = $passwordBD->fetch_assoc()["password"];

        $newPassword = $passwordBD;
        $cambiarPassword = false; 

        if (
            isset($_POST["oldPassword"]) && !empty($_POST["oldPassword"])
            &&  isset($_POST["newPassword"]) && !empty($_POST["newPassword"])
        ) {
            $cambiarPassword = true;
            $newPassword = password_hash($_POST["newPassword"], PASSWORD_BCRYPT);
        }

        if (empty($_POST["oldPassword"])) {
            echo json_encode([
                "success" => false,
                "message" => "Ingrese su contraseña actual para actualizar su perfil"
            ]);
            exit();
        }
        if (!password_verify($_POST["oldPassword"], $passwordBD)) {
            echo json_encode([
                "success" => false,
                "message" => "La contraseña actual es incorrecta"
            ]);
            exit();
        } else {
            $update = $mysql->efectuarConsulta("UPDATE $rol SET nombre='$nombre', email='$email', password='$newPassword' WHERE id=$idUsuario");

            if ($update) {
                echo json_encode([
                    "success" => true,
                    "message" => "Perfil actualizado exitosamente"
                ]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Ocurrió un error al actualizar el perfil"
                ]);
            }
        }
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Faltan campos por rellenar, Intentelo de nuevo"
        ]);
        exit();
    }

    $mysql->desconectar();
}
