<?php

declare(strict_types=1);

?>
<!-- /.login-logo -->
<div class="row">
    <div class="col-6 offset-3">
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Inicia sesión para acceder a tu sesión</p>
                <small class="text-danger"><?php echo $errores['verificacion'] ?? '' ?></small>

                <form action="<?php echo $_ENV['host.folder'] . 'usuariosSistema/login' ?>" method="post">
                    <div class="col-12 input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">
                                    Recordarme
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-8">
                            <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="">Olvidé mi contraseña</a>
                </p>
                <p class="mb-0">
                    <a href="<?php echo $_ENV['host.folder'] . 'usuariosSistema/new' ?>" class="text-center">Registrarse</a>
                </p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
<!-- /.login-box -->
