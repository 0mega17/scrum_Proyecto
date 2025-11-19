<?php
header('Content-Type: application/json');

require_once '../MODEL/model.php';  // ← CORRECTO

$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (
        isset($_POST["nombreActividad"]) && !empty($_POST["nombreActividad"]) &&
        isset($_POST["fechaLimite"]) && !empty($_POST["fechaLimite"]) &&
        isset($_POST["aprendiz"]) && !empty($_POST["aprendiz"])
    ) {
        san
    }
}
