<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";

        function num_usr_semestre($conexao){
            $date = date("Y-m-d",mktime(0, 0, 0, date("m")-6, 01,date("Y")));
            $date = substr($date, 0,7);
            $sql = "SELECT id FROM usuario WHERE created >= '$date'";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            return $contagem;
        }


        function count_usr_date($date, $conexao){
            $sql = "SELECT id FROM usuario WHERE created LIKE '$date%'";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            
            return $contagem;
        }
        

        function count_usr_deluxe($tipo, $conexao){
            $sql = "SELECT id FROM usuario WHERE id_plano = $tipo";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            return $contagem;
        }


        function count_novo_usr($conexao){
            $mes_atual = date("Y-m-")."01 00:00:00";
            $sql = "SELECT id FROM usuario WHERE created > '$mes_atual'";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            
            return $contagem;
        }

        
        function count_deluxe_usr($conexao){
            $mes_atual = date("Y-m-")."15 00:00:00";
            $sql = "SELECT id FROM fatura WHERE situacao=0 AND data_vencimento > '$mes_atual'";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            
            return $contagem;
        }


        function count_usr($conexao){
            $sql = "SELECT id FROM usuario";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            
            return $contagem;
        }


        function chart1_creator($conexao){
            $dates = [];
            $n_users = array();
            for ($i = 0; $i<6; $i++){
                array_push($dates, date("Y-m-d",mktime(0, 0, 0, date("m")-$i, 01,date("Y"))));
            }
            $soma = num_usr_semestre($conexao);
            foreach($dates as $date){
                $date = substr($date, 0,7);
                $data = substr($date, 5,2)."/".substr($date, 0,4);
                $vetor = count_usr_date($date, $conexao);
                array_push($n_users, array("label" =>$data, "y" => round(($vetor/$soma)*100),2));
            } 
            return $n_users;
        }

        
        function chart2_creator($conexao){
            $n_users = array();
            $gratuito = count_usr_deluxe(1, $conexao);
            $aria = count_usr_deluxe(2, $conexao);
            $requiem = count_usr_deluxe(3, $conexao);
            $soma = $gratuito + $aria + $requiem;
            array_push($n_users, array("label" => "GRATUITO", "y" => round(($gratuito/$soma)*100),2));
            array_push($n_users, array("label" => "ARIA", "y" => round(($aria/$soma)*100),2));
            array_push($n_users, array("label" => "REQUEM", "y" => round(($requiem/$soma)*100),2));
            return $n_users;
        }
        

    ?>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">HOME</h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">

                    <div class="col dado" >
                        <div class="col">
                            <div class="row" style="margin-bottom: 0;">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:4.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder; height:5.5rem;"><?php echo count_usr($conexao); ?></p>
                            </div>
                            <div class="row text-center" style="font-size:1rem;">
                                <p>USUÁRIOS CADASTRADOS</p>
                            </div>
                        </div>
                        <div class="col">
                            <i class="fas fa-user" style="padding-left: .5rem; padding-right: .5rem; margin-left: 5rem; margin-right: 0; font-size: 6rem"></i>
                        </div>
                    </div>
                
                    <div class="col dado" >
                        <div class="col">
                            <div class="row" style="margin-bottom: 0;">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:4.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder; height:5.5rem;"><?php echo count_novo_usr($conexao); ?></p>
                            </div>
                            <div class="row text-center" style="font-size:1rem;">
                                <p>NOVOS USUÁRIOS NESTE MÊS</p>
                            </div>
                        </div>
                        <div class="col">
                            <i class="fas fa-user-plus" style="padding-left: .5rem; padding-right: .5rem; margin-left: 5rem; margin-right: 0; font-size: 6rem"></i>
                        </div>
                    </div>
                    
                    <?php   
                    $n_users_semestre = chart1_creator($conexao);
                    $n_users_deluxe = chart2_creator($conexao);
                    ?>
                    <div class="col dado" >
                        <div class="col">
                            <div class="row" style="margin-bottom: 0;">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:4.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder; height:5.5rem;"><?php echo count_deluxe_usr($conexao); ?></p>
                            </div>
                            <div class="row text-center" style="font-size:1rem;">
                                <p>NOVOS USUÁRIOS DELUXE NESTE MÊS</p>
                            </div>
                        </div>
                        <div class="col">
                            <i class="fas fa-gem" style="padding-left: .5rem; padding-right: .5rem; margin-left: 5rem; margin-right: 0; font-size: 6rem"></i>
                        </div>
                    </div>

                    <script>
                        window.onload = function () {

                            var chart = new CanvasJS.Chart("graf1", {
                                animationEnabled: true,
                                title: {
                                    text: "NOVOS USUÁRIOS CADASTRADOS"
                                },
                                subtitles: [{
                                    text: "NOS ÚLTIMOS 6 MESES"
                                }],
                                data: [{
                                    type: "pie",
                                    showInLegend: "true",
                                    legendText: "{label}",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($n_users_semestre, JSON_NUMERIC_CHECK); ?>
                                }]
                            });

                            var chart2 = new CanvasJS.Chart("graf2", {
                                animationEnabled: true,
                                title: {
                                    text: "RELAÇÃO DE PLANOS"
                                },
                                data: [{
                                    type: "pie",
                                    showInLegend: "true",
                                    legendText: "{label}",
                                    yValueFormatString: "#,##0.00\"%\"",
                                    indexLabel: "{label} ({y})",
                                    dataPoints: <?php echo json_encode($n_users_deluxe, JSON_NUMERIC_CHECK); ?>
                                }]
                            });
                            chart.render();
                            chart2.render();
                        }
                    </script>

                </div>
                <div class="row">
                    <div class="col">
                        <br>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div id="graf1" style="height:20rem; width:35rem"></div>
                    </div>
                    <div class="col">
                        <div id="graf2" style="height:20rem; width:35rem"></div>
                    </div>
                    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
                </div>
            </div>
        </div>
    </body>
</html>