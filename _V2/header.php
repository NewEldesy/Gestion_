<?php 
    session_start();
    require_once('model.php');
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title> Login || Garage Software </title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/seodashlogo.png" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="index.php" class="text-nowrap logo-img">
            <!-- <img src="assets/images/logos/logo-light.svg" alt="" /> -->
            <h5>Gestion Stock</h5>
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <!-- Home / Dashboard -->
            <!-- Active le sous menu si l'url correspond
            <a class="sidebar-link active" href="index.php" aria-expanded="false">
                <span class="hide-menu">Tableau de bord</span>
            </a> 
            -->
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?=(strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'active' : '';?>" href="dashboard.php" aria-expanded="false">
                <span class="hide-menu">Tableau de bord</span>
              </a>
            </li>
            <!-- Home / Dashboard -->
            <!-- Prestation -->
            <!-- <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-6"></i>
              <span class="hide-menu">Prestation</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?//=(strpos($_SERVER['REQUEST_URI'], 'prestataire.php') !== false) ? 'active' : '';?>" href="prestataire.php" aria-expanded="false">
                <span class="hide-menu">Prestataire</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?//=(strpos($_SERVER['REQUEST_URI'], 'prestationM.php') !== false) ? 'active' : '';?>" href="prestationM.php" aria-expanded="false">
                <span class="hide-menu">Prestation Mécanique</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?//=(strpos($_SERVER['REQUEST_URI'], 'prestationT.php') !== false) ? 'active' : '';?>" href="prestationT.php" aria-expanded="false">
                <span class="hide-menu">Prestation Tractage</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?//=(strpos($_SERVER['REQUEST_URI'], 'prestationA.php') !== false) ? 'active' : '';?>" href="prestationA.php" aria-expanded="false">
                <span class="hide-menu">Autre Prestation</span>
              </a>
            </li> -->
            <!-- Prestation -->
            <!-- Vente -->
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-6" class="fs-6"></iconify-icon>
              <span class="hide-menu">Vente</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?=(strpos($_SERVER['REQUEST_URI'],'vente.php')!==false||strpos($_SERVER['REQUEST_URI'],'facture.php')!==false)?'active':'';?>" href="vente.php" aria-expanded="false">
                <span class="hide-menu">Vente</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?=(strpos($_SERVER['REQUEST_URI'], 'produits.php') !== false) ? 'active' : '';?>" href="produits.php" aria-expanded="false">
                <span class="hide-menu">Produits</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?=(strpos($_SERVER['REQUEST_URI'], 'stock.php') !== false) ? 'active' : '';?>" href="stock.php" aria-expanded="false">
                <span class="hide-menu">Stock</span>
              </a>
            </li>
            <!-- Vente -->
            <li class="nav-small-cap">
              <iconify-icon icon="solar:menu-dots-linear" class="nav-small-cap-icon fs-4" class="fs-6"></iconify-icon>
              <span class="hide-menu">EXTRA</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link <?=(strpos($_SERVER['REQUEST_URI'], 'vehicule.php') !== false) ? 'active' : '';?>" href="vehicule.php" aria-expanded="false">
                <span class="hide-menu">Vehicule</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                <i class="ti ti-bell-ringing"></i>
                <div class="notification bg-primary rounded-circle"></div>
              </a>
            </li> -->
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <!-- <a href="#" target="_blank"
                class="btn btn-primary me-2"><span class="d-none d-md-block">Check Pro Version</span> <span class="d-block d-md-none">Pro</span>
              </a>
              <a href="#" target="_blank"
                class="btn btn-success"><span class="d-none d-md-block">Download Free </span> <span class="d-block d-md-none">Free</span>
              </a> -->
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">Mon Profil</p>
                    </a>
                    <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->