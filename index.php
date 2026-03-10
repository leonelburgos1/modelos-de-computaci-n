<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="assets/css/estilos.css">

</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <div class="wrapper">

    <!-- NAVBAR -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-custom">
      <span class="navbar-brand font-weight-bold">Dashboard</span>
    </nav>

    <!-- SIDEBAR -->
    <aside class="main-sidebar elevation-4 sidebar-custom">

      <!-- LOGO -->
      <a href="index.php" class="brand-link text-center brand-custom">
        <span class="brand-text font-weight-bold">Panel</span>
      </a>

      <!-- MENU -->
      <div class="sidebar">
        <nav>

          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview">

            <!-- JUEGOS -->
            <li class="nav-item">
              <a href="?page=juegos"
                class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'juegos') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-gamepad"></i>
                <p><strong>Juegos</strong></p>
              </a>
            </li>

            <!-- DESARROLLADORES -->
            <li class="nav-item">
              <a href="?page=desarrolladores"
                class="nav-link <?php echo (isset($_GET['page']) && $_GET['page'] == 'desarrolladores') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-code"></i>
                <p><strong>Desarrolladores</strong></p>
              </a>
            </li>

          </ul>

        </nav>
      </div>

    </aside>

    <!-- CONTENIDO -->
    <div class="content-wrapper p-4">

      <?php

      if (isset($_GET['page']) && $_GET['page'] == 'juegos') {

        include 'juego.php';

      } elseif (isset($_GET['page']) && $_GET['page'] == 'desarrolladores') {

        include 'desarrolladores.php';

      } else {

        echo "<h3 class='text-center mt-5'>Bienvenido al Dashboard</h3>";

      }

      ?>

    </div>

  </div>

  <!-- SCRIPTS -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>