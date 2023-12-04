<!-- include_once("templates/header.php") isso faz o cabelhaco aparecer na pg -->
<!-- main,banner,conteiner é biblioteca -- cold md 12 sig 12 colunas do body -->
<?php 
    include_once("templates/header.php");
    include_once("process/restaurante.php");
?>
    <div id="main-banner">
        <h1>Faça o seu pedido</h1>
    </div>
    <div id="main-conteiner">
        <div class="conteiner">
            <div class="row">
                <div class="col-md-12">
                    <h2>Monte o seu prato</h2>
                    <form action="process/restaurante.php" method="POST" id="restaurante-form">
                        <div class="form-group">
                            <label for="proteina">Tamanho:</label>
                            <select name="tamanho" id="tamanho" class="form-control">
                                <option value="">Selecione um tamnho</option>
                                <?php foreach($tamanho as $tamanho): ?>
                                    <option value="<?= $tamanho["id"] ?>"><?=$tamanho["tipo"]?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="proteina">Proteina:</label>
                            <select name="proteina" id="proteina" class="form-control">
                                <option value="">Selecione uma proteina</option>
                                <?php foreach($proteina as $proteina): ?>
                                    <option value="<?= $proteina["id"] ?>"><?=$proteina["tipo"]?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="salada">Salada:</label>
                            <select name="salada" id="salada" class="form-control">
                                <option value="">Selecione uma salada</option>
                                <?php foreach($salada as $salada): ?>
                                    <option value="<?= $salada["id"] ?>"><?=$salada["nome"]?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="guarnicao">Guarnição: (máximo 3)</label>
                            <select multiple name="guarnicao[]" id="guarnicao" class="form-control">
                                <?php foreach($guarnicao as $guarnicao): ?>
                                    <option value="<?= $guarnicao["id"] ?>"><?=$guarnicao["tipo"]?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Fazer Pedido!">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php 
    include_once("templates/footer.php");
?>

