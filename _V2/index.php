<?php
  ob_start(); session_start();
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GARAGE GARANGO PAUL</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/ggp.ico" />
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>
<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-3">
            <div class="card mb-0">
              <div class="card-body">
                <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <h4>GARAGE GARANGO PAUL</h4>
                  <h6>Page de Connexion</h6>
                </a>
                <!-- <p class="text-center">Your Social Campaigns</p> -->
                <form method="POST">
                  <div class="mb-3">
                    <label for="Email1" class="form-label">Username</label>
                    <input type="text" class="form-control" id="Email1">
                  </div>
                  <div class="mb-4">
                    <label for="Password1" class="form-label">Password</label>
                    <input type="password" class="form-control" id="Password1">
                  </div>
                  <div id="login_result"></div>
                  <button type="button" id="login" class="btn btn-primary w-100 py-8 fs-4 mb-4">Sign In</button>
                  <!-- <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">New to SeoDash?</p>
                    <a class="text-primary fw-bold ms-2" href="./authentication-register.html">Create an account</a>
                  </div> -->
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/iconify-icon.min.js"></script>
  <script src="assets/js/script.js"></script>
</body>
</html>