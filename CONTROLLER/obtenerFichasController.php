<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

//* se verificar que sea administrador
if (!isset($_SESSION["acceso"]) || $_SESSION["acceso"] == false || $_SESSION["tipoUsuario"] != 1) {
    echo json_encode(['status' => 'error', 'message' => 'No autorizado']);
    exit;
}

require_once '../MODEL/model.php';
$mysql = new MySQL();
$mysql->conectar();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['accion'])) {
    
    //* necesario obtener las fichas con su estado de asignación para un instructor
    if ($_POST['accion'] == 'obtenerFichas') {
        $instructorId = filter_var($_POST['instructorId'], FILTER_SANITIZE_NUMBER_INT);
        
        //* necesario obtener la información del instructor
        $queryInstructor = "SELECT nombre FROM instructores WHERE id = '$instructorId'";
        $resultInstructor = $mysql->efectuarConsulta($queryInstructor);
        
        if ($resultInstructor && mysqli_num_rows($resultInstructor) > 0) {
            $instructor = mysqli_fetch_assoc($resultInstructor);
            
            //* necesario obtener todas las fichas con estado de asignación
            //? cunado existe un registro en la tabla fichas_has_instructores , se marca como asignada (1), si no asignada (0)
            //? esto sirve para saber si la ficha ya está asignada al instructor seleccionado 
            //?------------------------
            //? se pone left join porque queremos todas las fichas, aunque no estén asignadas al instructor
            //? va a mostrar todas las fichas, incluyendo las que no están asignadas es decir que no etan en la tabla fichas_has_instructores
            //! sin eso solo se obtendrían las fichas que ya están asignadas

            $consultasFicha = "
                SELECT 
                    ficha.id, 
                    ficha.codigo, 
                    ficha.nombre, 
                    ficha.fecha_inicio, 
                    ficha.fecha_fin, 
                    area.nombre_area,
                    IF(fichas_has_instructores.fichas_id IS NOT NULL, 1, 0) as asignada
                FROM fichas ficha
                JOIN areas area ON ficha.area_ficha = area.id
                LEFT JOIN fichas_has_instructores ON ficha.id = fichas_has_instructores.fichas_id AND fichas_has_instructores.instructores_id = '$instructorId'
                ORDER BY ficha.codigo
            ";
            
            $resultFichas = $mysql->efectuarConsulta($consultasFicha);
            $fichas = [];
            
            //* aqui va llenando el array de fichas con su estado de asignación
            while ($ficha = mysqli_fetch_assoc($resultFichas)) {
                $fichas[] = $ficha;
            }
            
            //* aqui se devuelve toda la información, basicamente es lo que se muestra en la tabla de asignación
            echo json_encode([
                'status' => 'success',
                'instructor' => $instructor['nombre'],
                'fichas' => $fichas
            ]);

            //* es una validaación para el caso que no se encuentre el instructor, algo que es imposible pero se pone just in case
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Instructor no encontrado']);
        }
    }
}

$mysql->desconectar();
?>
