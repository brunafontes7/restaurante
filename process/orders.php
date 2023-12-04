<?php 
include_once("conn.php");

$method = $_SERVER["REQUEST_METHOD"];

if($method === "GET") {
  
    $pedidosQuery = $conn->query("SELECT * FROM pedidos;");

    $pedidos = $pedidosQuery->fetchAll();

    $refeicoes = [];

    // Montando prato
    foreach($pedidos as $pedido) {

      $refeicao = [];

      // definir um array para a prato
      $refeicao["id"] = $pedido["refeicao_id"];

      // resgatando o prato
      $refeicaoQuery = $conn->prepare("SELECT * FROM refeicao WHERE id = :refeicao_id");

      $refeicaoQuery->bindParam(":refeicao_id", $refeicao["id"]);

      $refeicaoQuery->execute();

      $refeicaoData = $refeicaoQuery->fetch(PDO::FETCH_ASSOC);
      
      // resgatando o tamanho
      $tamanhoQuery = $conn->prepare("SELECT * FROM tamanho WHERE id = :tamanho_id");

      $tamanhoQuery->bindParam(":tamanho_id", $refeicaoData["tamanho_id"]);

      $tamanhoQuery->execute();

      $tamanho = $tamanhoQuery->fetch(PDO::FETCH_ASSOC);
      
      $refeicao["tamanho"] = $tamanho["tipo"];
      
      // resgatando a proteina 
      $proteinaQuery = $conn->prepare("SELECT * FROM proteina WHERE id = :proteina_id");

      $proteinaQuery->bindParam(":proteina_id", $refeicaoData["proteina_id"]);

      $proteinaQuery->execute();

      $proteina = $proteinaQuery->fetch(PDO::FETCH_ASSOC);
      
      $refeicao["proteina"] = $proteina["tipo"];

      // resgatando a salada
      $saladaQuery = $conn->prepare("SELECT * FROM salada WHERE id = :salada_id");

      $saladaQuery->bindParam(":salada_id", $refeicaoData["salada_id"]);

      $saladaQuery->execute();

      $salada = $saladaQuery->fetch(PDO::FETCH_ASSOC);
      
      $refeicao["salada"] = $salada["nome"];
      
      // resgatando guarnicao
      $guarnicaoQuery = $conn->prepare("SELECT * FROM refeicao_guarnicao WHERE refeicao_id = :refeicao_id");

      $guarnicaoQuery->bindParam(":refeicao_id", $refeicao["id"]);

      $guarnicaoQuery->execute();

      $guarnicao = $guarnicaoQuery->fetchAll(PDO::FETCH_ASSOC);
      
      // resgatando o nome da guarnicao
      $guarnicaoDaRefeicao = [];

      $guarnicaoQuery = $conn->prepare("SELECT * FROM guarnicao WHERE id = :guarnicao_id");

      foreach($guarnicao as $g) {
        $guarnicaoQuery->bindParam(":guarnicao_id", $g["guarnicao_id"]);

        $guarnicaoQuery->execute();

        $guarnicaoRefeicao = $guarnicaoQuery->fetch(PDO::FETCH_ASSOC);
        
        array_push($guarnicaoDaRefeicao, $guarnicaoRefeicao["tipo"]);

      }

      $refeicao["guarnicao"] = $guarnicaoDaRefeicao;

      // adicionar o status do pedido
      $refeicao["status"] = $pedido["status_id"];

      // Adicionar o array refeicao, ao array refeicao
      array_push($refeicoes, $refeicao);
    }

    // Resgatando os status
    $statusQuery = $conn->query("SELECT * FROM status;");

    $status = $statusQuery->fetchAll();
  
} else if($method === "POST") {

  // verificando tipo de POST
  $type = $_POST["type"];

  // deletar pedido
  if($type === "delete") {

    $refeicaoId = $_POST["id"];

    $deleteQuery = $conn->prepare("DELETE FROM pedidos WHERE refeicao_id = :refeicao_id;");

    $deleteQuery->bindParam(":refeicao_id", $refeicaoId, PDO::PARAM_INT);

    $deleteQuery->execute();

    $_SESSION["msg"] = "Pedido removido com sucesso!";
    $_SESSION["status"] = "success";

  // Atualizar status do pedido
  } else if($type === "update") {

    $refeicaoId = $_POST["id"];
    $statusId = $_POST["status"];

    $updateQuery = $conn->prepare("UPDATE pedidos SET status_id = :status_id WHERE refeicao_id = :refeicao_id");

    $updateQuery->bindParam(":refeicao_id", $pizzaId, PDO::PARAM_INT);
    $updateQuery->bindParam(":status_id", $statusId, PDO::PARAM_INT);

    $updateQuery->execute();

    $_SESSION["msg"] = "Pedido atualizado com sucesso!";
    $_SESSION["status"] = "success";

  }

  // retorna usuário para dashboard
  header("Location: ../dashboard.php");

}

?>