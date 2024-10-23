<!--Inicio HTML -->
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <form method="post" action="/anadirMunicipio">
                <input type="hidden" name="order" value="1"/>
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Datos a introducir</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <!--<form action="./?sec=formulario" method="post">                   -->
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="nombre">Nombre Municipio:</label>
                                <input type="text" class="form-control" name="nombre" id="nombre" value="" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="sexo">Sexo:</label>
                                <input type="text" class="form-control" name="sexo" id="sexo" value="" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="periodo">Periodo:</label>
                                <input type="text" class="form-control" name="periodo" id="periodo" value="" />
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="mb-3">
                                <label for="total">Total:</label>
                                <input type="text" class="form-control" name="total" id="total" value="" />
                            </div>
                        </div>
                    </div>
                    <?php if(isset($errors)){?>
                        <div>
                            
                        </div>
                    <?php }?>
                    <div class="card-footer">
                        <div class="col-12 text-right">
                            <a href="/anadirMunicipio" value="" name="reiniciar" class="btn btn-danger">Reiniciar
                                filtros</a>
                            <input type="submit" value="Aplicar filtros" name="enviar" class="btn btn-primary ml-2"/>
                        </div>
                    </div>
            </form>
        </div>
    </div>
