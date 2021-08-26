<?php
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../config/database.php';
    include_once '../app/usuarios.php';

    $database = new Database();
    $db = $database->getConnection();

    $items = new Usuarios($db);
    $stmt = $items->getUsuarios();
    $itemCount = $stmt->rowCount();


    echo json_encode($itemCount);

    if($itemCount > 0){
        
        $usuariosArr = array();
        $usuariosArr["body"] = array();
        $usuariosArr["itemCount"] = $itemCount;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $e = array(
                "id" => $id,
                "nome" => $nome,
                "cpf" => $cpf,
                "telefone" => $telefone,
                "email" => $email,
                "data_nascimento" => $data_nascimento,
                "senha" => $senha,
                "endereco" => $endereco 
            );

            array_push($usuariosArr["body"], $e);
        }
        echo json_encode($usuariosArr);
    }

    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "Nenhuma usuário encontrado.")
        );
    }
?>