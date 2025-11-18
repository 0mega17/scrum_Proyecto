<!-- <?php

// session_start();


// if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] != 'administrador' || $_SESSION['activo'] != "activo") {
//   header("Location: login.php");
//   exit();
// }
?> -->
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Instructores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  
</head>

<body>
    <div class="dashboard-container">

        <div class="sidebar">
            <div>
                <h5 class="mb-4 d-flex align-items-center"><i class="bi bi-book-half me-2"></i>Proyecto Scrum</h5>
                <nav class="nav flex-column">
                </nav>
            </div>

            <button class="btn btn-danger w-100 mt-3 btnLogout">
                <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                </a></button>
        </div>



        <div class="content">
            <div class="content-header mb-4">
                <div>
                    <h2 class="fw-bold text-success mb-0">Crear Nuevo Instructores</h2>
                    <p class="text-muted">Complete los datos para registrar un nuevo Instructores.</p>
                </div>
                <div class="user-info">
                </div>
            </div>


            <form id="formCrearInstructores">
                <h4 class="mb-4"><i class="bi bi-person-circle me-2"></i> Datos del Instructores</h4>

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre" required>
                </div>

                
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" placeholder="ejemplo@correo.com" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" placeholder="Contraseña" required>
                </div>


                <button type="submit" class="btn btn-success w-100 mt-3">
                    <i class="bi bi-person-plus me-2"></i>Crear Usuario
                </button>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="../assets/js/scripts.js"></script> -->
</body>
</html>