<html lang="en">
<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DWES | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>DWES</b>UD6</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Regístrate para iniciar sesión</p>


            <form action="" method="post">
                <div class="col-12 input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small class="text-danger"><?php echo $errores['email'] ?? '' ?></small>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small class="text-danger"><?php echo $errores['nombre'] ?? '' ?></small>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="text" name="idioma" class="form-control" placeholder="Idioma">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <small class="text-danger"><?php echo $errores['idioma'] ?? '' ?></small>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <small class="text-danger"><?php echo $errores['password'] ?? '' ?></small>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="password" name="password2" class="form-control" placeholder="Repetir password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <small class="text-danger"><?php echo $errores['password2'] ?? '' ?></small>
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Crear usuario</button>
                    </div>
                </div>
            </form>

            <!--<div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="#" class="btn btn-block btn-primary">
                    <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
                </a>
                <a href="<?php /*echo $_ENV['host.folder'] . 'login-with-google' */?>" class="btn btn-block btn-danger">
                    <i class="fab fa-google mr-2"></i> Sign in using Google
                </a>
            </div>-->
            <!-- /.social-auth-links -->


            <p class="mb-0">
                <a href="<?php echo $_ENV['host.folder'] . 'login' ?>" class="text-center">Iniciar sesión</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
</div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>