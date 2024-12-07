
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Connexion || Logiciel de gestion</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="./assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
</head>
<body>
    <section class="vh-100" style="background-color: #508bfc;">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card shadow-2-strong" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">
                            <h3 class="mb-5">Connexion</h3>
                            <form method="POST" action="process_login.php">
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typeUsername">Nom d'utilisateur</label>
                                    <input type="email" id="typeUsername" class="form-control form-control-lg" required>
                                </div>
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="typePassword">Mot de passe</label>
                                    <input type="password" id="typePassword" class="form-control form-control-lg" required>
                                </div>
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Se connecter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>