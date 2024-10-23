 <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<div class="row">
    <div class="col-12">
        <div class="card shadow mb-4">
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary"><?php echo $csv_div_titulo; ?></h6>                                    
            </div>
            <div class="card-body">  
                <table id="csvTable" class="table table-hover dataTable">
                    <?php 
                    $first = true;
                    foreach($data as $fila){
                        if($first){
                            ?>
                    <thead>
                        <tr>
                            <?php 
                            foreach($columnasMostrar as $column){
                            ?>
                                <th><?php echo $fila[$column]; ?></th>
                            <?php
                            }
                        $first = false;
                        ?>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                        }
                        else{
                            ?>
                        <tr>  
                            <?php 
                            foreach($columnasMostrar as $column){
                            ?>
                                <td><?php echo $fila[$column]; ?></td>
                            <?php
                            }
                            ?>                               
                        </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
</div>
<!--<script src="./vendor/jquery/jquery.min.js"></script>-->
