
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
  <h1 class="h3 mb-0 text-gray-800">Iterativas 07</h1>

</div>
<!-- Content Row -->

<div class="row">
  <div class="col-12">
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Bingo!</h6>
      </div>
      <div class="card-body">
        <form action="" method="get">
          <div class="mb-3 col-12">
            <label for="textarea">Introduce los números de tu cartón: </label>
            <textarea class="form-control" id="carton" name="carton"
                      rows="3"><?php echo $data['input_carton'] ?? ''; ?></textarea>
            <p class="text-danger small"><?php echo $data['errors']['carton'] ?? ''; ?></p>
            <br />
            <label for="textarea">Los números que han salido del bombo: </label>
            <p id="bolas" name="bolas"><?php echo $data['bolas']?></p>
          </div>
          <div class="mb-3">
            <input type="submit" value="Bolas" name="sacarBolas" class="btn btn-primary">
            <input type="submit" value="Reiniciar el juego" name="reiniciar" class="btn btn-primary">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>