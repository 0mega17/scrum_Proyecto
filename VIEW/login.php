<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../ASSETS/CSS/bootstrap.min.css">
</head>

<body>
    <section class="vh-100 d-flex align-items-center" style="background: #f1f3f5;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4">

                    <div class="card shadow-lg border-0 rounded-4 p-4">
                        <div class="text-center mb-4">
                            <img src="../ASSETS/IMG/login.png" class="img-fluid" style="max-width: 120px;" alt="Login image">
                            <h2 class="fw-bold mt-3">Iniciar sesión</h2>
                            <p class="text-muted">Accede a tu cuenta</p>
                        </div>

                        <form id="frmLogin">

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email"
                                        class="form-control form-control-lg"
                                        id="email" name="email"
                                        placeholder="ejemplo@correo.com">
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Contraseña</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                    <input type="password"
                                        class="form-control form-control-lg"
                                        id="password" name="password"
                                        placeholder="••••••••">
                                </div>
                            </div>

                            <!-- Rol -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold">Rol</label>
                                <select class="form-select form-select-lg" id="rol" name="rol">
                                    <option value="1">Administrador</option>
                                    <option value="2">Instructor</option>
                                    <option value="3">Aprendiz</option>
                                </select>
                            </div>

                            <!-- Submit -->
                            <button type="submit"
                                class="btn btn-primary btn-lg w-100 fw-bold"
                                id="btn-acceder">
                                Acceder
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>



    <script src="../ASSETS/JS/login.js"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- Sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>