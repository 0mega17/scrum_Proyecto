  </div>
  </div>
  <script
      src="../ASSETS/JS/bootstrap.bundle.min.js"
      class="astro-vvvwv3sm"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php if ($archivoActual == "trabajos.php") { ?>
      <script src="../public/JS/subirArchivo.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "asignarTrabajo.php") { ?>
      <script src="../ASSETS/JS/traerDatosTrabajos.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "crear_instructores.php") { ?>
      <script src="../ASSETS/js/crear_instructores.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "crear_administradores.php") { ?>
      <script src="../ASSETS/js/crear_admin.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "crear_aprendiz.php") { ?>
      <script src="../ASSETS/js/crear_aprenidez.js"></script>
  <?php } ?>

  <?php if($archivoActual == "editar_perfil.php"){ ?>
  <script src="../ASSETS/js/perfil.js"></script>
    <?php }?>


  </body>

  </html>