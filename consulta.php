<?php
    $banco = "mysql:host=127.0.0.1;port=3306;dbname=vipcustom;charset=utf8";
    $usuario = "root";
    $senha = "";
    try {
        $con = new PDO($banco, $usuario, $senha);
        $sql = "SELECT * FROM cliente ";
        if (isset($_GET['pesq']) === true){
            $sql .= " where nome like '%{$_GET['pesq']}%'";
        }
        $dados = $con-> query($sql);
        $resp = json_encode($dados-> fetchAll(PDO::FETCH_ASSOC));
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        echo ($resp);
    } catch (PDOException $e) {
        echo 'ERROR:' . $e-> getMessage();
    }
?>