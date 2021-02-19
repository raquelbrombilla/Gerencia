<?php
    session_start();
    include_once("conexao.php");

    if( !isset($_SESSION['id_usuario']) ){
        header('location: index.php');
        exit();
    }

    header('Content-Type: text/html; charset=utf-8');

?>


<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Viagens Não-Concluídas | Gerencia!</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    
    <?php
        include_once("link.php"); 
    ?>

</head>
<body>

    <?php
        include_once("menu/index.php"); 

        if(isset($_SESSION['mensagem'])) {
            echo $_SESSION['mensagem'];
            echo "<br><br>";
            unset($_SESSION['mensagem']);
        }
    ?>

        <div id="main" class="container-fluid">
            <h3 class="page-header">Viagens não-concluídas:</h3>

            <div class="row">
                <div class="table-responsive col-md-12">
                    <table class="table table-striped" cellspacing="0" cellpadding="0">
                        <thead>
                            <th style="color: #0d6f75; font-weight: 700;">#</th>
                            <th>Data</th>
                            <th>Placa</th>

                            <?php
                                 if($_SESSION['tipo'] == 1){
                                     echo "<th>Motorista</th>";
                                 }
                            ?>
                            <th>Local de saída</th>
                            <th>Local de chegada</th>
                            <th>Visualizar</th>
                        <thead>
                        <tbody>
                            <tr>

    <?php
        $id_usuario = $_SESSION['id_usuario'];

        if($_SESSION['tipo'] == 1){
            $sql2 = "select v.*, u.nome, u.id_usuario, u.possui_id_usuario, a.placa, a.id_dirige_usuario, a.id_cad_usuario from viagem v, 
            usuario u, automotor a where u.possui_id_usuario = $id_usuario 
            and a.id_cad_usuario = u.possui_id_usuario and u.id_usuario = v.id_usuario 
            and u.id_usuario = a.id_dirige_usuario and v.concluida = 0 order by v.dt_carregamento desc";
            $result2 = mysqli_query($bd, $sql2);

            $cont = 1;
            
            while($viagem_func = mysqli_fetch_array($result2)){


                echo "<td style='color: #0d6f75; font-weight: 700;'>".$cont."</td>";
                echo "<td>".date('d/m/Y', strtotime($viagem_func['dt_carregamento']))."</td>";
                echo "<td>".$viagem_func['placa']."</td>";
                echo "<td>".$viagem_func['nome']."</td>";
                echo "<td>".$viagem_func['local_carregamento']."</td>";
                echo "<td>".$viagem_func['destino']."</td>";
            
            ?>
                                
                                <td>
                                <?php
                                   echo "<a class='btn btn-info' style='background-color: #5a95d4; border: #5a95d4;' id='btn_action' href='ver_viagens.php?id=".$viagem_func['id_viagem']."'><i class='fas fa-mouse-pointer'></i></a>";
                                ?>
                                </td>
                                
                            </tr>
            <?php
                $cont++;
            }

            
        } else if($_SESSION['tipo'] == 0){
            
            $sql2 = "select v.*, u.nome, u.id_usuario, a.placa, a.id_dirige_usuario from viagem v, usuario u, automotor a
             where u.id_usuario = $id_usuario and v.id_usuario = u.id_usuario and u.id_usuario = a.id_dirige_usuario 
             and v.concluida = 0 order by v.dt_carregamento desc";
            $result2 = mysqli_query($bd, $sql2);

            $cont = 1;
            
            while($viagem = mysqli_fetch_array($result2)){


                echo "<td style='color: #0d6f75; font-weight: 700;'>".$cont."</td>";
                echo "<td>".date('d/m/Y', strtotime($viagem['dt_carregamento']))."</td>";
                echo "<td>".$viagem['placa']."</td>";
                echo "<td>".$viagem_func['local_carregamento']."</td>";
                echo "<td>".$viagem_func['destino']."</td>";

            
            ?>
                                <td>
                                <?php
                                   echo "<a class='btn btn-info' style='background-color: #5a95d4; border: #5a95d4;' id='btn_action' href='ver_viagens.php?id=".$viagem['id_viagem']."'><i class='fas fa-mouse-pointer'></i></a>";
                                ?>
                                </td>
                                <td>
                                <?php
                                   echo "<a class='btn btn-info' style='background-color: #d2238f; border: #d2238f;' id='btn_action' href='despesas.php?id=".$viagem['id_viagem']."'><i class='fas fa-plus'></i></a>";
                                ?>                                 
                                </td>
                                <td>
                                <?php
                                   echo "<a class='btn btn-primary' id='btn_action' href='alterar_viagem.php?id=".$viagem['id_viagem']."'><i class='fas fa-edit'></i></a>";
                                ?>                                
                                </td>
                                <td>
                                <?php
                                   echo "<a class='btn btn-success' style='background-color: #28a945;  border: #28a945;' id='btn_action' href='concluir_viagem.php?id=".$viagem['id_viagem']."'><i class='fas fa-check'></i></a>";
                                ?>
                                </td>   
                            </tr>
            <?php
                $cont++;
            }
            

        } // fecha o if 
        

            ?>

        
                                
                                
                        </tbody>
                    </table>
                </div>
            </div>




        </div>
            
               
    <?php
        include_once("link_fim.php"); 
    ?>
  
</body>
</html>