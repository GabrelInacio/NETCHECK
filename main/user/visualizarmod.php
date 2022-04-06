<?php 
        include("menu-user.php"); 
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
            $sql = "SELECT AVG(vel_down) AS avg1, AVG(vel_up) AS avg2 FROM medicao WHERE data_medicao BETWEEN '$dtinicio 00:00:00' AND '$dtfim 23:59:59' AND id_modulo = $id_mod";
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


                $("#de").focusout(function(){
                    var de = $("#de").val()
                    var ate = $("#ate").val()
                    if(de > ate){
                        Swal.fire(
                        'Data inválida!',
                        'A data inicial não pode ser maior que a data final!',
                        'error'
                        );
                        $("#de").val(ate)
                    }
                });


               $("#ate").focusout(function(){
                    var de = $("#de").val()
                    var ate = $("#ate").val()
                    if(de > ate){
                        Swal.fire(
                        'Data inválida!',
                        'A data inicial não pode ser maior que a data final!',
                        'error'
                        );
                        $("#de").val(ate)
                    }
                });


                $(".botao").focus(function(){
                    var de = $("#de").val()
                    var ate = $("#ate").val()
                    if(de > ate){
                        Swal.fire(
                        'Data inválida!',
                        'A data inicial não pode ser maior que a data final!',
                        'error'
                        );
                        $("#de").val(ate)
                    }
                }); 
            });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">MEDIÇÕES - <?php echo $nome_modulo; ?> </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="roW">
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
                            <form action="visualizarmod.php" method="get">
                                <div class="user-box">
                                    <input type="hidden" name="idmod" value="<?php echo $id_mod; ?>">
                                    <input class="date" type="date" id="de" name="de" required="true">
                                    <label style="padding-left:1rem;">De: </label>
                                </div>
                            </div>
                            <div class="col">
                                <div class="user-box">
                                    <input class="date" type="date" id="ate" name="ate" required="true">
                                    <label style="padding-left:1rem;">Até: </label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center">
                            <div class="col-md-auto" style="margin: auto">
                                <input type="submit" class="botao" value="CONSULTAR" style="margin: auto">
                            </div>
                        </form>
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
                        $registros_por_pagina= 20;
                        $offset = ($numpag-1) * $registros_por_pagina;
                        
                        $id_mod = $_GET["idmod"];
                        $num = "SELECT * FROM medicao WHERE id_modulo = $id_mod AND data_medicao BETWEEN '$dtinicio 00:00:00' AND '$dtfim 23:59:00'";
                        $result = mysqli_query($conexao,$num);
                        $num_linhas = mysqli_num_rows($result);
                        $num_pag = 0;
                        $sub = $num_linhas;
                        while ($sub > 0){
                            $sub = $sub - $registros_por_pagina;
                            $num_pag = $num_pag + 1;
                        }

                        $sql = "SELECT * FROM medicao WHERE id_modulo = $id_mod AND data_medicao BETWEEN '$dtinicio 00:00:00' AND '$dtfim 23:59:00' ORDER BY data_medicao DESC LIMIT $offset, $registros_por_pagina";
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
                <div class="row">
                    <div class="col">
                        <nav aria-label="Page navigation" style="margin:auto;">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="visualizarmod.php?<?php echo 'idmod='.$id_mod.'&numpag=1&de='.$dtinicio.'&ate='.$dtfim; ?>" style="color:#BE3D3E;"><< </a></li>
                                <li class="page-item"><a class="page-link" href="visualizarmod.php?<?php if($numpag == 1){  echo 'idmod='.$id_mod.'&numpag=1&de='.$dtinicio.'&ate='.$dtfim; }else{ echo 'idmod='.$id_mod.'&numpag='.($numpag - 1).'&de='.$dtinicio.'&ate='.$dtfim; }?>" style="color:#BE3D3E;"><</a></li>
                                <?php for ($i=0; $i<$num_pag; $i++){
                                    ?>
                                
                                <li class="page-item"><a class="page-link" href="visualizarmod.php?<?php echo 'idmod='.$id_mod.'&numpag='.($i+1).'&de='.$dtinicio.'&ate='.$dtfim; ?>" style="color:#BE3D3E;"><?php echo $i+1;?></a></li>
                                <?php 
                                    }
                                ?>
                                <li class="page-item"><a class="page-link" href="visualizarmod.php?<?php if($numpag == $num_pag){  echo 'idmod='.$id_mod.'&numpag='.$num_pag.'&de='.$dtinicio.'&ate='.$dtfim; }else{ echo 'idmod='.$id_mod.'&numpag='.($numpag + 1).'&de='.$dtinicio.'&ate='.$dtfim; }?>" style="color:#BE3D3E;">></a></li>
                                <li class="page-item"><a class="page-link" href="visualizarmod.php?<?php echo 'idmod='.$id_mod.'&numpag='.$num_pag.'&de='.$dtinicio.'&ate='.$dtfim; ?>" style="color:#BE3D3E;"> >></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <br>
                <div class="row  justify-content-md-end">
                    <div class="col-sm-1">
                        <a href="modulos.php" class="botao2">VOLTAR</a>
                    </div>
                    <div class="col-md-2">
                        <a href="reportbuilder.php?idmod=<?php echo $id_mod."&de=".$dtinicio."&ate=".$dtfim."&nome=".$_SESSION["nome"]."&email=".$_SESSION["email"]; ?>" class="botao2" target="_blank">RELATÓRIO</a>
                    </div>
                </div>
                <br>
                <br>
            </div>
            
        </div>
        

    </body>
</html>