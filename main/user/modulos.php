<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $user_id = $_SESSION["id"];
        function conta_modulos($user_id, $conexao){
            $sql1 = "SELECT * FROM modulo WHERE id_usuario = $user_id AND ativo=1";
            $sqlBusca = mysqli_query($conexao, $sql1);
            $contagem = mysqli_num_rows($sqlBusca);
            return $contagem;

        }
        function listar_modulos($user_id, $conexao){

            $mods = [];
            $sql1 = "SELECT * FROM modulo WHERE id_usuario = $user_id AND ativo=1";
            $sqlBusca = mysqli_query($conexao, $sql1);
            $contagem = mysqli_num_rows($sqlBusca);
            if ($contagem > 0){
                $mods=[];
                while($linha = mysqli_fetch_array($sqlBusca)) {
                    $id_mod = $linha["id"];
                    $hoje = date("Y-m-d");
                    $dia1 = date("Y-m-")."01";
                    $sql2 = "SELECT AVG(vel_down) AS avg1, AVG(vel_up) AS avg2 FROM medicao WHERE data_medicao BETWEEN '$dia1 00:00:00' AND '$hoje 23:59:59' AND id_modulo = $id_mod";
                    $sql3 = "SELECT data_medicao FROM medicao WHERE id_modulo = $id_mod ORDER BY data_medicao DESC LIMIT 1";
                    $sqlBusca2 = mysqli_query($conexao, $sql2);
                    $sqlBusca3 = mysqli_query($conexao, $sql3);
                    $linha2 = mysqli_fetch_array($sqlBusca2);
                    $linha3 = mysqli_fetch_array($sqlBusca3);
                    if(isset($linha3)){
                        $data_med = date_format(date_create($linha3["data_medicao"]), 'd/m/Y H:i:s');
                    }else{
                        $data_med = "";
                    }
                    $mod = ["id" => $linha['id'], "nome_modulo" => $linha["nome_modulo"], "down" => round($linha2["avg1"]), "up" => round($linha2["avg2"]), "data" => $data_med, "operadora" => $linha["operadora"], "intervalo" => $linha["intervalo"]]; 
                    array_push($mods, $mod);
                }
            }
            return $mods;
        }
    ?>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">MÓDULOS DE MEDIÇÃO</h1>
                    <div class="col-xs-12"><hr></div>
                </div>
    
                <?php 
                    $modulos = listar_modulos($_SESSION["id"], $conexao);
                    if (count($modulos) > 0){
                        foreach($modulos as $modulo){
                    
                ?>
                <div class="row">
                    <div class="col modcard">
                        <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                            <h2 style="font-weight: bolder" > <?php echo $modulo["nome_modulo"]; ?></h2>
                            <div class="col-xs-12"><hr></div>
                        </div>

                        <div class="row" style="padding-left: 2rem;">
                            <div class="col">
                                <h3>Provedora: <?php echo $modulo["operadora"]; ?></h3>
                            </div>
                            
                            <div class="col">
                                <h3>Última Medição: <?php echo $modulo["data"]; ?></h3>
                            </div>
                        </div>
                        
                        <div class="row" style="padding-left: 2rem;">
                            <div class="col">
                                <h3>Intervalos de Medição: <?php echo $modulo["intervalo"]; ?> min </h3>
                            </div>
                            
                            <div class="col d-flex flex-wrap align-items-center">
                                <h3 style=>Média Atual:</h3>
                                <i class="fas fa-arrow-down" style="padding-left: .3rem; margin-bottom: .5rem;"></i><h5 style="padding-left: .3rem"><?php echo $modulo["down"]; ?> Mbps / </h5>
                                <i class="fas fa-arrow-up" style="padding-left: .3rem; margin-bottom: .5rem;"></i> <h5 style="padding-left: .3rem"><?php echo $modulo["up"]; ?> Mbps</h5>
                            </div>
                        </div>

                        <div class="row d-flex justify-content-end" style="margin-top: 1rem; margin-bottom: 1rem;">
                            <div class="col-4">
                                <a href="<?php echo 'visualizarmod.php?idmod='.$modulo['id'];?>" class="botao">MEDIÇÕES REALIZADAS</a>
                                <a href="<?php echo 'acaomodulo.php?idmod='.$modulo['id'];?>" class="botao">CONFIGURAÇÕES</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <?php 
                        }
                    }
                ?>
                <?php
                    $plano = $_SESSION["id_plano"];
                    switch ($plano){
                        case 1:
                            if (conta_modulos($user_id, $conexao) < 2){
                                ?>
                                <div class="row">
                                    <a href="acaomodulo.php" class="col anticard">
                                        <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                                            <h2 style="font-weight: bolder" ><i class="fas fa-plus"></i> CADASTRAR NOVO MÓDULO</h2>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            break;
                        case 2:
                            if (conta_modulos($user_id, $conexao) < 6){
                                ?>
                                <div class="row">
                                    <a href="acaomodulo.php" class="col anticard">
                                        <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                                        <h2 style="font-weight: bolder" ><i class="fas fa-plus"></i> CADASTRAR NOVO MÓDULO</h2>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                            break;
                        case 3:
                        if (conta_modulos($user_id, $conexao) < 10){
                            ?>
                            <div class="row">
                                <a href="acaomodulo.php" class="col anticard">
                                    <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                                        <h2 style="font-weight: bolder" ><i class="fas fa-plus"></i> CADASTRAR NOVO MÓDULO</h2>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                        break;
                    }
                ?>
                <br>

            </div>
        </div>
    </body>
</html>