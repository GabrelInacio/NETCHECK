<html>
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../styles/user.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NetCheck</title>
    </head>
<?php 
        include "../../cad/config.php";
        if(!isset($_GET["idmod"])){
            header("Location: modulos.php");
        }
        if (isset($_GET['numpag'])) {
            $numpag = $_GET['numpag'];
        } else {
            $numpag = 1;
        }
        $id_mod = $_GET["idmod"];
        $buscamod = "SELECT * FROM modulo WHERE id = $id_mod";
        $pesquisa = mysqli_query($conexao, $buscamod);
        $infomod = mysqli_fetch_array($pesquisa);
        $nome_modulo = $infomod["nome_modulo"];
        $vel_up_mod = $infomod["vel_up"];
        $vel_down_mod = $infomod["vel_down"];

        if(!isset($_GET["ate"])){
            $dtfim = date("Y-m-d");
        }else{
            $dtfim = $_GET["ate"];
        }
        if(!isset($_GET["de"])){
            $dtinicio = date("Y-m-")."01";
        }else{
            $dtinicio = $_GET["de"];
        }

        function media_calc($id_mod, $dtinicio, $dtfim, $vel_up_mod, $vel_down_mod, $conexao){
            $media = ["up_mbps" => 0, "up_pc" => 0, "down_mbps" => 0, "down_pc" => 0];
            $sql = "SELECT AVG(vel_down) AS avg1, AVG(vel_up) AS avg2 FROM medicao WHERE data_medicao BETWEEN '$dtinicio' AND '$dtfim' AND id_modulo = $id_mod";
            $sqlBusca = mysqli_query($conexao, $sql);
            $linha = mysqli_fetch_array($sqlBusca);

            $media["up_mbps"] = round($linha["avg2"], 2);
            $media["up_pc"] = round((($linha["avg2"]/$vel_up_mod)*100), 2);

            $media["down_mbps"] = round($linha["avg1"], 2);
            $media["down_pc"] = round((($linha["avg1"]/$vel_down_mod)*100), 2);
            return $media;
        }

        function print_avg($valor){
            $retorno = "";
            if($valor>=85){
                $retorno = "#70C497";
            }else if($valor>=75){
                $retorno = "#F4EA25";
            }else{
                $retorno = "#DC3338";
            }
            return $retorno;
        }

        $modulo = media_calc($id_mod, $dtinicio, $dtfim, $vel_up_mod, $vel_down_mod, $conexao);
?>
        <script>
            $(document).ready(function(){
                $("#de").val("<?php echo $dtinicio; ?>");
                $("#ate").val("<?php echo $dtfim; ?>");
            });
        </script>
            <div class="topo">
                <div class="col">
                    <img src="../../styles/logos/logo-user.png" style="padding-left: auto; padding-bottom: auto; display: block; margin-left: auto; margin-right: auto; height: 4rem;">
                </div>
            </div>
            <div class="container" style="padding-top: 7rem;">
                <div class="row">
                    <h1 style="font-weight: bolder; text-align:center">RELATÓRIO DE MEDIÇÕES</h1>
                    <h3 style="font-weight: bolder; text-align:center"><?php echo $nome_modulo; ?> </h3>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-sm-8 modcard" style="margin: auto;" >
                        <div class="row">
                            <div class="col">
                                <h2 class="text-center" style="margin-top:2rem"><b>MÉDIA</b></h2>
                            </div>
                        </div>

                        <div class="row" style="padding-bottom:1rem; padding-top: .5rem">
                            <div class="container col" style="border-right: 1px solid #FFF;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="../../styles/logos/down-icon.svg">
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col text-center">
                                                <h1 style="display:inline-block; padding-right:1rem;"><b><?php echo $modulo['down_mbps'] ;?></b></h1>
                                                <h3 style="display:inline-block; color: <?php echo print_avg($modulo['down_pc']);?>;"><b>(<?php echo $modulo['down_pc'] ; ?></b>)%</h3>
                                                <h4>Download em Mbps</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="container col" style="border-left: 1px solid #FFF;">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <img src="../../styles/logos/up-icon.svg">
                                    </div>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col text-center">
                                                <h1 style="display:inline-block; padding-right:1rem;"><b><?php echo $modulo['up_mbps'] ;?></b></h1>
                                                <h3 style="display:inline-block; color: <?php echo print_avg($modulo['up_pc']);?>;"><b>(<?php echo $modulo['up_pc'] ; ?></b>)%</h3>
                                                <h4>Upload em Mbps</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>

                <div style="width:80%; margin: auto">
                    <div class="row justify-content-md-center" style="padding-top:2rem;">
                        <div class="col">
                                <h3 style="font-weight: bolder; text-align:center">DE: <?php echo date_format(date_create($dtinicio), 'd/m/Y'); ?> </h3>
                            </div>
                            <div class="col">
                                <h3 style="font-weight: bolder; text-align:center">ATÉ: <?php echo date_format(date_create($dtfim), 'd/m/Y'); ?> </h3>
                            </div>
                        </div>
                    <div class="row" style="padding-top:2rem;">
                        <div class="row text-center">
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b>Download em Mbps</b></h5>
                            </div>
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b>Upload em Mbps</b></h5>
                            </div>
                            <div class="col">
                                <h5><b>Data e Hora da Medição</b></h5>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                                <h5><b>Provedora</b></h5>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <?php
                        
                        $id_mod = $_GET["idmod"];
                        $num = "SELECT * FROM medicao WHERE id_modulo = $id_mod AND data_medicao BETWEEN '$dtinicio' AND '$dtfim'";
                        $result = mysqli_query($conexao,$num);
                        $num_linhas = mysqli_num_rows($result);
                        $num_pag = 0;
                        $sub = $num_linhas;
                        $sql = "SELECT * FROM medicao WHERE id_modulo = $id_mod AND data_medicao BETWEEN '$dtinicio' AND '$dtfim' ORDER BY data_medicao DESC";
                        $resultado = mysqli_query($conexao,$sql);
                        while($row = mysqli_fetch_array($resultado)){
                            $data= date_format(date_create($row["data_medicao"]), 'd/m/Y H:i:s');
                    ?>
                
                    <div class="row">
                        <div class="row text-center">
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b><?php echo $row["vel_down"]; ?> Mbps</b></h5>
                            </div>
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b><?php echo $row["vel_up"]?> Mbps</b></h5>
                            </div>
                            <div class="col">
                                <h5><b><?php echo $data; ?></b></h5>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                                <h5><b><?php echo $row["operadora"]; ?></b></h5>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <?php

                        }
                    ?>
                </div>
                <br>
            </div>
    </body>
</html>