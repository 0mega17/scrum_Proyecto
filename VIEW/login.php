<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../ASSETS/CSS/bootstrap.min.css">
</head>

<body>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex align-items-center justify-content-center h-100">
                <div class="col-md-8 col-lg-7 col-xl-4">
                    <img src="../ASSETS/IMG/login.png"
                        class="img-fluid" alt="Phone image">
                </div>
                <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1 bg-body-tertiary p-5 rounded shadow border border-0">
                    <form id="frmLogin">
                        <div class="row my-3">
                            <h1 class="fw-bold">Login</h1>
                        </div>
                        <!-- Email input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control form-control-lg" />

                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control form-control-lg" />

                        </div>

                        <div class="mb-3">
                            <label class="form-label" for="">Rol</label>
                            <select class="form-select" id="rol" name="rol" aria-label="Default select example">
                                <option value="1">Administrador</option>
                                <option value="2">Instructor</option>
                                <option value="3">Aprendiz</option>
                            </select>

                        </div>


                        <!-- Submit button -->
                        <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg btn-block w-100 fw-bold fs-5" id="btn-acceder">Acceder</button>

                    </form>
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