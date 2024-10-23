
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-12">
                <?php var_dump($usuarios); 
                foreach($usuarios as $u){
                    echo '<p>'.$u->getSalarioNeto().'</p>';
                }
                ?>
            </div>
        </div>
      </div>
