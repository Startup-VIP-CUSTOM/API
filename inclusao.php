<?php
    $banco = "mysql:host=127.0.0.1;port=3306;dbname=vipcustom;charset=utf8";
    $usuario = "root";
    $senha = "";
    header("Content-Type: application/json");
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: Origin, Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    try {
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $contato = json_decode(file_get_contents('php://input'), true);
            if (isset($contato["nome"]) === true){
                $con = new PDO($banco, $usuario, $senha);
                $sql = "INSERT INTO cliente (nome, email, cpf, cidade, senha) ";
                $sql .= " VALUES (?, ?, ?, ?, ?)";
                $comando = $con-> prepare($sql);
                $comando -> execute([
                    $contato["nome"],
                    $contato["email"],
                    $contato["cpf"],
                    $contato["cidade"],
                    $contato["senha"]
                ]);
                $id = $con-> lastInsertId();
                http_response_code(201);
                echo ('{"id":'.$id.'}');
            } else {
                http_response_code(405);
            }
        } else {
            if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
                http_response_code(200);
            } else {
                http_response_code(406);
                echo('{ "message2": "'.$_SERVER['REQUEST_METHOD'].'"}'); 
            }
        }
    } catch (PDOException $e) {
        http_response_code(500);
        echo '{"ERROR:":"' . $e-> getMessage() . '"}';
    }
?>
