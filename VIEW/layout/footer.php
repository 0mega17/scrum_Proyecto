  </div>
  </div>
  <script
      src="../ASSETS/JS/bootstrap.bundle.min.js"
      class="astro-vvvwv3sm"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://kit.fontawesome.com/4c0cbe7815.js" crossorigin="anonymous"></script>

  <!-- BOOSTRAP 5 DATATABLES -->
  <script src="../ASSETS/JS/datatable.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
  <script src="https://cdn.datatables.net/2.3.4/js/dataTables.bootstrap5.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.7/js/dataTables.responsive.js"></script>
  <script src="https://cdn.datatables.net/responsive/3.0.7/js/responsive.bootstrap5.js"></script>

  <?php if ($archivoActual == "trabajos.php" && $rol == 2) { ?>
      <script src="../ASSETS/JS/crear_trabajo.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "trabajos.php" && $rol == 3) { ?>
      <script src="../ASSETS/JS/subir_trabajo.js"></script>
  <?php } ?>
  <?php if ($archivoActual == "calificar_trabajo.php" && $rol == 2) { ?>
      <script src="../ASSETS/JS/cargar_calificaciones.js"></script>
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

  <?php if ($archivoActual == "editar_perfil.php") { ?>
      <script src="../ASSETS/js/perfil.js"></script>
  <?php } ?>

  <?php if ($archivoActual == "entregas.php" && $rol == 3) { ?>
      <script src="../ASSETS/JS/ver_calificaciones.js"></script>
  <?php } ?>


  </body>

  </html>