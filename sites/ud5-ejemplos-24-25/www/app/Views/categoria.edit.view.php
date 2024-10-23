<?php
/*
 * Licensed to the Apache Software Foundation (ASF) under one
 * or more contributor license agreements.  See the NOTICE file
 * distributed with this work for additional information
 * regarding copyright ownership.  The ASF licenses this file
 * to you under the Apache License, Version 2.0 (the
 * "License"); you may not use this file except in compliance
 * with the License.  You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing,
 * software distributed under the License is distributed on an
 * "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
 * KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations
 * under the License.
 */
?>

<div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cubes mr-1"></i>
                        Datos categoría
                    </h3>                
                </div>
                <form action="/categoria/<?php echo $action; ?>" method="post">
                    <div class="card-body">
                        <div class="row">
                            <input type="hidden" name="id_categoria" value="<?php echo $categoria->id; ?>" />
                            <!-- select -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Categoría padre: <?php echo $idPadre; ?></label>
                                    <select class="form-control" name="id_padre" id="id_padre">
                                        <option value="0"><i>Ninguna</i></option>
                                        <?php
                                        foreach ($categoriasList as $c) {
                                            echo '<option value="' . $c->id . '" ' . ($idPadre == $c->id ? 'selected' : '') . '>' . $c->getFullName() . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if(isset($errors['id_padre'])){
                                    ?>
                                    <p class="text-danger"><small><?php echo $errors['id_padre']; ?></small></p>
                                    <?php
                                    }
                                    ?>
                                </div>   
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nombre">Nombre categoría:</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo $categoriaEdit->nombre; ?>" />
                                    <?php
                                    if(isset($errors['nombre'])){
                                    ?>
                                    <p class="text-danger"><small><?php echo $errors['nombre']; ?></small></p>
                                    <?php
                                    }
                                    ?>
                                </div> 
                            </div>

                        </div></div>
                    <div class="card-footer">
                        
                        <button type="submit" name="action" class="btn btn-danger float-right " value="cancelar">Cancelar</button>
                        <button type="submit" name="action" class="btn btn-primary mr-3 float-right" value="guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



