<?php
  include_once("templates/header.php");
  include_once("process/orders.php");
?>
  <div id="main-container">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h2>Gerenciar pedidos:</h2>
        </div>
        <div class="col-md-12 table-container">
          <table class="table">
            <thead>
              <tr>
                <th scope="col"><span>Pedido</span> #</th>
                <th scope="col">Tamanho</th>
                <th scope="col">Proteina</th>
                <th scope="col">Salada</th>
                <th scope="col">Guarnição</th>
                <th scope="col">Status</th>
                <th scope="col">Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($refeicoes as $refeicao): ?>
                <tr>
                  <td><?= $refeicao["id"] ?></td>
                  <td><?= $refeicao["tamanho"] ?></td>
                  <td><?= $refeicao["proteina"] ?></td>
                  <td><?= $refeicao["salada"] ?></td>
                  <td>
                    <ul>
                      <?php foreach($refeicao["guarnicao"] as $guarnicao): ?>
                        <li><?= $guarnicao;?></li>
                      <?php endforeach; ?>
                    </ul>
                  </td>
                  <td>
                    <form action="process/orders.php" method="POST" class="form-group update-form">
                      <input type="hidden" name="type" value="update">
                      <input type="hidden" name="id" value="<?= $refeicao["id"] ?>">
                      <select name="status" class="form-control status-input">
                        <?php foreach($status as $s): ?>
                          <option value="<?= $s["id"] ?>" <?php echo ($s["id"] == $refeicao["status"]) ? "selected" : ""; ?> ><?= $s["tipo"] ?></option>
                        <?php endforeach; ?>
                      </select>
                      <button type="submit" class="update-btn">
                        <i class="fas fa-sync-alt"></i>
                      </button>
                    </form>
                  </td>
                  <td>
                    <form action="process/orders.php" method="POST">
                      <input type="hidden" name="type" value="delete">
                      <input type="hidden" name="id" value="<?= $refeicao["id"] ?>">
                      <button type="submit" class="delete-btn">
                        <i class="fas fa-times"></i>
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php
  include_once("templates/footer.php");
?>