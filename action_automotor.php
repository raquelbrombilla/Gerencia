<?php
    session_start();
    include_once("conexao.php");

    if(!isset($_SESSION['id_usuario']) && $_SESSION['tipo'] == '0'){
        header('location: index.php');
        exit();
    }

    $id_usuario = $_SESSION['id_usuario'];

    $placa = $_POST['placa'];
    $marca = $_POST['marca'];
    $data = $_POST['ano'];
    $renavam = $_POST['renavam'];
    $chassi = $_POST['chassi'];
    $antt = $_POST['antt']; 

    $sql2 = "insert into automotor(placa, marca, ano, renavam, chassi, antt, status, id_cad_usuario) values('$placa', '$marca', '$data', '$renavam', '$chassi', '$antt', '1', '$id_usuario')";
    $result2 = mysqli_query($bd, $sql2);

    if (mysqli_insert_id($bd)) {
        $_SESSION["mensagem"] = "<div class='mensagem_ok'><strong>
        <i class='fas fa-check-circle'></i>
        Automotor cadastrado com sucesso!
        </strong></div>";
        header('location: cad_automotor.php');
        exit();
    } else {
        $_SESSION['mensagem'] = "<div class='mensagem_erro'><strong>
        <i class='fa fa-exclamation-triangle' aria-hidden='true'></i>
        Esse automotor já está cadastrado. Tente novamente.
        </strong></div>";
        header('location: cad_automotor.php');
     }

     mysqli_close($bd);

?>