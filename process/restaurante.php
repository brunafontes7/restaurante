<?php 
    include_once("conn.php");

    $method = $_SERVER["REQUEST_METHOD"];
    // RESGATE DOS DADOS, MONTAGEM DO PEDIDO
    if($method === "GET"){
        $tamanhoQuery = $conn->query("SELECT * FROM tamanho;");
        $tamanho = $tamanhoQuery->fetchAll();
        
        $proteinaQuery = $conn->query("SELECT * FROM proteina;");
        $proteina = $proteinaQuery->fetchAll();
        
        $saladaQuery = $conn->query("SELECT * FROM salada;");
        $salada = $saladaQuery->fetchAll();

        $guarnicaoQuery = $conn->query("SELECT * FROM guarnicao;");
        $guarnicao = $guarnicaoQuery->fetchAll();

    //CRIACAO DO PEDIDO    
    } else if($method === "POST"){
        $data = $_POST;
        
        $tamanho = $data["tamanho"];
        $proteina = $data["proteina"];
        $salada = $data["salada"];
        $guarnicao = $data["guarnicao"];

    //VALIDACAO DE GUARNICAO MAXIMOS
     if(count($guarnicao) > 3) {
        $_SESSION["msg"] = "Selecione no máximo 3 guarnição";
        $_SESSION["status"] = "warning";
     }  else{
    //SALVANDO SALADA E PROTEINA NO RESTAURANTE.PHP
        try {
            $stmt =  $conn->prepare("INSERT INTO refeicao (tamanho_id,proteina_id, salada_id) VALUES (:tamanho,:proteina, :salada)");
        
        // FILTRANDO INPUTS
            $stmt->bindParam(":tamanho", $tamanho, PDO::PARAM_INT);
            $stmt->bindParam(":proteina", $proteina, PDO::PARAM_INT);
            $stmt->bindParam(":salada", $salada, PDO::PARAM_INT);

            $stmt->execute();

        // RESGATANDO ULTIMO ID DA ULTIMA refeicao
            $refeicaoId = $conn->lastInsertId();

            $stmt = $conn->prepare("INSERT INTO refeicao_guarnicao (refeicao_id, guarnicao_id) VALUES (:refeicao, :guarnicao)");

        // REPETICAO ATE TERMINAR DE SALVAR TODAS AS GUARNICOES
            foreach($guarnicao as $guarnicao) {

                //filtrando os inputs
                $stmt->bindParam(":refeicao", $refeicaoId, PDO::PARAM_INT);
                $stmt->bindParam(":guarnicao", $guarnicao, PDO::PARAM_INT);

                $stmt->execute();
            }

            //criar pedido 
            $stmt = $conn ->prepare("INSERT INTO pedidos (refeicao_id, status_id) VALUES (:refeicao, :status)");

            // status -> sempre inicia com 1, que é em producao
            $statusId = 1;

        // filtrar inputs
            $stmt->bindParam("refeicao",$refeicaoId);
            $stmt->bindParam("status",$statusId);

            $stmt->execute();

        //exibir mensagem de sucesso
            $_SESSION["msg"] = "Pedido com sucesso";
            $_SESSION["status"] = "success";
        } catch(Exception $e) {
            var_dump($e);
        }

     } 
    // RETONAR PARA A PG INICIAL
     header("Location:.."); 
    }
?>