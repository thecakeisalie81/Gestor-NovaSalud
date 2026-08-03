<?php
$rol = $_SESSION['rol'] ?? 'guest';
?>


<nav class="sidebar">
  <header>
    <div class="image-text">
      <span class="image">
        <img src="../../assets/img/logo.png" alt="logo" />
      </span>
      <div class="text header-text">
        <span class="name">Clinica</span>
        <span class="profession">NovaSalud</span>
      </div>
    </div>
  </header>

  <div class="menu-bar">
    <div class="menu">
      <ul class="menu-links">

      </ul>
    </div>

    <div class="buttom-content">
      <li class="">
        <a href="../../logout.php">
          <i class='bx bx-log-out icon'></i>
          <span class="text nav-text">Logout</span>
        </a>
      </li>
    </div>

  </div>
</nav>

<script>
  window.userRole = "<?php echo $rol; ?>";
</script>
<script src="../../assets/js/sidebar.js"></script>