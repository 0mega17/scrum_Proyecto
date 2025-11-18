<?php 

// aqui sera la logica para crear las fichas por parte de los admistradores :3 y todo nice :D 
 
    require_once './MODEL/model.php';
    header('Content-Type: application/json; charset=utf-8');
    $Mysql = new MySQL();
    $Mysql->conectar();
    session_start();
    if (
        $_SERVER["REQUEST_METHOD"] === "POST"  && isset($_POST['nombreFicha']) && !empty($_POST['nombreFicha'])
        && isset($_POST['areaFicha']) && !empty($_POST['areaFicha'] && isset($_POST['codigoFicha']) && !empty($_POST['codigoFicha']))
        
    ) {
        // recolectar los datos para crear el nuevo usuario se almacenan y despues se sanitizan para evitar el Sql injection :3 
        $nombreFicha = filter_input(INPUT_POST, 'nombreFicha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $areaFicha = filter_input(INPUT_POST, 'areaFicha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
       $codigoFicha = filter_input(INPUT_POST, 'codigoFicha', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $consultaSql = "insert into fichas (id,nombre_ficha,area)
         values ('$codigoFicha','$nombreFicha','$areaFicha')";
        $resultado = $Mysql->efectuarConsulta($consultaSql);
        if ($resultado) {
    
            // aqui se le manda el json con su valor 
           echo json_encode(
                [
                    "susses" => true,

                ]
            );
        } else {
            // lo mismo pero al reves para motrar si algo fallo :3
           echo json_encode(
                [
                    "susses" => false,
                ]
            );
        }
    }
$Mysql -> desconectar();
    







?>