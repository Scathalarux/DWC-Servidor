<?php

declare(strict_types=1);

?>

<div class="row">
    <div class="col-6">
        <div class="card shadow mb-4">
            <form method="post" action="">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Cambiar Tema</h6>
                </div>
                <div class="col-12 col-lg-6 m-3">
                    <input type="checkbox" class="form-check-input" id="tema" name="tema"  <?php echo (isset($_COOKIE['theme']) && $_COOKIE['theme']) ? 'checked' : ''; ?>>
                    <label for="tema">Tema Oscuro</label>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <input type="submit" value="Aplicar tema" name="theme-button" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
        <div class="card shadow mb-4">
            <form method="post" action="">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Estabecer nombre Usuario</h6>
                </div>
                <div class="col-12 col-lg-6 m-3">
                    <div class="form-group">
                        <label for="username">Nombre usuario:</label>
                        <input type="text" class="form-control" name="username" id="username"
                               value="<?php echo $input['username'] ?? ''; ?>"/>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col-12 text-right">
                        <input type="submit" value="Aplicar nombre" name="username-button" class="btn btn-primary ml-2"/>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
