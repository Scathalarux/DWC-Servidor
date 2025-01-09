<?php

declare(strict_types=1);

?>
<!DOCTYPE html>
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
            <p class="login-box-msg">Registro de usuario</p>
            <small class="text-danger"><?php echo $errores['verificacion'] ?? '' ?></small>

            <form action="" method="post">
                <div class="col-12 input-group mb-3">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre completo"
                           value="<?php echo $input['nombre'] ?? '' ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email"
                           value="<?php echo $input['email'] ?? '' ?>">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                    <div>
                        <small class="text-danger"><?php echo $errores['email'] ?? '' ?></small>
                    </div>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div>
                        <small class="text-danger"><?php echo $errores['password'] ?? '' ?></small>
                    </div>
                </div>
                <div class="col-12 input-group mb-3">
                    <input type="password" name="password2" class="form-control" placeholder="Reescribir Password">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    <div>
                        <small class="text-danger"><?php echo $errores['password2'] ?? '' ?></small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="icheck-primary">
                            <input type="checkbox" id="terminos" name="terminos">
                            <label for="terminos">
                                Aceptar los términos
                            </label>
                        </div>
                        <div>
                            <small class="text-danger"><?php echo $errores['terminos'] ?? '' ?></small>
                        </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Registrarse</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mb-3">
                <p>- OR -</p>
                <a href="<?php echo $_ENV['host.folder'] . 'register-with-google' ?>" class="btn btn-block btn-danger">
                    <i class="fab fa-google mr-2"></i> Registrarse con Google
                </a>
            </div>
            <!-- /.social-auth-links -->

            <a href="<?php echo $_ENV['host.folder']; ?>login" class="text-center">Ya tengo una cuenta. Iniciar
                sesión</a>
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
