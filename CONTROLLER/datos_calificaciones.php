<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

 
        require_once '../MODEL/model.php';
        header('Content-Type: application/json');
        $mysql = new MySQL();
        $mysql->conectar();

        $consaultaDatosEntrega = "select entregas.id ,aprendices.nombre as nombre_aprendiz, trabajos.nombre as nombre_trabajo, entregas.archivo from entregas
inner join aprendices on aprendices.id = entregas.aprendices_id inner join trabajos on trabajos.id = entregas.trabajos_id 
where entregas.estado = 'Entregado'
";
        $resultado = $mysql->efectuarConsulta($consaultaDatosEntrega);
        $entregas = [];


        while ($fila = $resultado->fetch_assoc()) {
            $entregas[] = $fila;
        }
        echo json_encode($entregas);


