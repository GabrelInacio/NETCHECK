    <?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        function random_color() {
            $letters = '0123456789ABCDEF';
            $color = '#';
            for($i = 0; $i < 6; $i++) {
                $index = rand(0,15);
                $color .= $letters[$index];
            }
            return $color;
        }

        function date_search($date, $id_mod, $conexao){
            $resultado = [0, 0];

            $sql1 = "SELECT AVG(vel_down) AS avg FROM medicao WHERE datediff(data_medicao, '$date') = 0 AND id_modulo = $id_mod AND ativo = 1";
            $sqlBusca1 = mysqli_query($conexao, $sql1);
            $linha1 = mysqli_fetch_array($sqlBusca1) ;
            $resultado[0] = $linha1['avg'];

            $sql2 = "SELECT AVG(vel_up) AS avg FROM medicao WHERE datediff(data_medicao, '$date') = 0 AND id_modulo = $id_mod AND ativo = 1";
            $sqlBusca2 = mysqli_query($conexao, $sql2);
            $linha2 = mysqli_fetch_array($sqlBusca2) ;
            $resultado[1] = $linha2['avg'];

            return $resultado;
        }

        function date_avg($date, $id_mod, $conexao){
            $resultado = [0, 0];
            $date_pre = date_create($date);
            date_add($date_pre, date_interval_create_from_date_string('-7 days'));
            $date2 = date_format($date_pre, 'Y-m-d');
            $primasql = "SELECT * FROM modulo WHERE id = $id_mod AND ativo = 1";
            $primaQuery = mysqli_query($conexao, $primasql);
            $primaLinha = mysqli_fetch_array($primaQuery);

            $sql1 = "SELECT AVG(vel_down) AS avg FROM medicao WHERE ativo = 1 AND data_medicao BETWEEN '$date2 00:00:00' AND '$date 23:59:59' AND id_modulo = $id_mod";
            $sqlBusca1 = mysqli_query($conexao, $sql1);
            $linha1 = mysqli_fetch_array($sqlBusca1);
            
            if(mysqli_num_rows($sqlBusca1)>0){
                $resultado[0] = $linha1['avg'];
                $resultado[0] = round(($resultado[0]/$primaLinha["vel_down"])*100);
                $resultado[0] = ($resultado[0]);
            }else{
                $resultado[0] = 0;
            }
            
            $sql2 = "SELECT AVG(vel_up) AS avg FROM medicao WHERE data_medicao BETWEEN '$date2 00:00:00' AND '$date 23:59:59' AND id_modulo = $id_mod AND ativo=1";
            $sqlBusca2 = mysqli_query($conexao, $sql2);
            $linha2 = mysqli_fetch_array($sqlBusca2);
            if(mysqli_num_rows($sqlBusca2)>0){
                $resultado[1] = $linha2['avg'];
                $resultado[1] = round(($resultado[1]/$primaLinha["vel_up"])*100);
                $resultado[1] = ($resultado[1]);
            }else{
                $resultado[1] = 0;
            }
            

            return $resultado;
        }

        function count_med($user_id, $conexao){
            $sql = "SELECT med.id FROM medicao AS med INNER JOIN modulo ON med.id_modulo = modulo.id WHERE modulo.id_usuario = $user_id AND modulo.ativo = 1 AND med.ativo = 1";
            $sqlBusca = mysqli_query($conexao, $sql);
            $contagem = mysqli_num_rows($sqlBusca);
            
            return $contagem;
        }

        function judgement($user_id, $date, $conexao){
            $sql1 = "SELECT * FROM modulo WHERE id_usuario = $user_id AND ativo = 1";
            $sqlBusca = mysqli_query($conexao, $sql1);
            $contagem = mysqli_num_rows($sqlBusca);
            $comparativo = [];
            $retorno = ["maior_up" => ["Sem Módulo", "Sem Medição"], "maior_down" => ["Sem Módulo", "Sem Medição"], "menor_up" => ["Sem Módulo", "Sem Medição"], "menor_down" => ["Sem Módulo", "Sem Medição"]];
            if ($contagem > 0){
                $mods=[];
                while($linha = mysqli_fetch_array($sqlBusca)) {
                    $mods[$linha["id"]] = $linha['nome_modulo'];
                }
                foreach($mods as $id => $nome_mod){
                    $resultado = date_avg($date, $id, $conexao);
                    $comparativo[$id] = $resultado;
                }
                $cont = 0;
                foreach($comparativo as $id => $valores){
                    if($cont == 0){
                        $retorno = ["maior_up" => [$mods[$id], $valores[1]], "maior_down" => [$mods[$id], $valores[0]], "menor_up" => [$mods[$id], $valores[1]], "menor_down" => [$mods[$id], $valores[0]]];
                    }else{
                        if($valores[1]>=$retorno["maior_up"][1]){
                            $retorno["maior_up"][0] = $mods[$id];
                            $retorno["maior_up"][1] = $valores[1];
                        }
                        if($valores[0]>=$retorno["maior_down"][1]){
                            $retorno["maior_down"][0] = $mods[$id];
                            $retorno["maior_down"][1] = $valores[0];
                        }

                        if($valores[1]<=$retorno["menor_up"][1]){
                            $retorno["menor_up"][0] = $mods[$id];
                            $retorno["menor_up"][1] = $valores[1];
                        }
                        if($valores[0]<=$retorno["menor_down"][1]){
                            $retorno["menor_down"][0] = $mods[$id];
                            $retorno["menor_down"][1] = $valores[0];
                        }
                    }
                    $cont+=1;
                }
            }
            return $retorno;
        }
        
        function print_avg($avg){
            $retorno = "";
            if($avg>=85){
                $retorno = "#70C497";
            }else if($avg>=75){
                $retorno = "#F4EA25";
            }else{
                $retorno = "#DC3338";
            }
            return $retorno;
        }

        function chart_creator($user_id, $direction, $conexao){
            $dates = [];
            $medicoes = [];
            for ($i = 0; $i<7; $i++){
                array_push($dates, date("Y-m-d",mktime(0, 0, 0, date("m"), date("d")-$i,date("Y"))));
            }

            $sql1 = "SELECT * FROM modulo WHERE id_usuario = $user_id AND ativo = 1";
            $sqlBusca = mysqli_query($conexao, $sql1);
            $contagem = mysqli_num_rows($sqlBusca);
            if($contagem>0){
                $mods = [];
                while($linha = mysqli_fetch_array($sqlBusca)) {
                    $mods[$linha["id"]] = $linha['nome_modulo'];
                }
                foreach ($mods as $id => $mod){
                    $medias = [];
                    foreach($dates as $date){
                        $vetor = date_search($date, $id, $conexao);
                        if($direction == "down"){
                            array_push($medias, array("x" => strtotime($date." 00:00:00")*1000, "y" => 10*($vetor[0])/10));
                        }else{
                            array_push($medias, array("x" => strtotime($date." 00:00:00")*1000, "y" => 10*($vetor[1])/10));
                        }
                    }
                    $medicoes[$mod] = $medias;
                } 
            }
            return $medicoes;
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
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:4.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder; height:5.5rem;"><?php echo count_med($_SESSION['id'], $conexao); ?></p>
                            </div>
                            <div class="row text-center" style="font-size:1rem;">
                                <p>MEDIÇÕES REALIZADAS</p>
                            </div>
                        </div>
                        <div class="col">
                            <img src="../../styles/logos/icone-up-down.svg" style="padding-left: .5rem; height: 6rem"/>
                        </div>
                    </div>
                
                    <?php 
                    $hoje = date("Y-m-d");
                    $modulos = judgement($_SESSION["id"], $hoje, $conexao);?>
                    

                    <div class="col dado">
                        <div class="col">
                            <div class="row text-center" style="font-size:.8rem;padding-bottom:0">
                                <p style="margin-bottom:0">MELHOR DESEMPENHO DE DOWNLOAD NA SEMANA</p>
                            </div>
                            <div class="row text-center" style="font-size:1.2rem;">
                                <p style="margin-bottom:0;color:<?php echo print_avg($modulos["maior_down"][1]); ?>"><?php echo $modulos["maior_down"][0]; ?></p>
                            </div>
                            <div class="row text-center">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:3.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder;color:<?php echo print_avg($modulos["maior_down"][1]); ?>">
                                    <?php
                                        if($modulos["maior_down"][1] == "Sem Medição"){
                                            echo "<p font-size: 1.5rem>";
                                            echo $modulos["maior_down"][1]; 
                                            echo "</p>";
                                        }else{
                                            echo $modulos["maior_down"][1]."%"; 
                                        }
                                ?></p>
                            </div>
                        </div>
                    </div>
                    <?php
                    $medicoes = chart_creator($_SESSION["id"],"down", $conexao);
                    ?>
                    <div class="col dado">
                        <div class="col">
                            <div class="row text-center" style="font-size:.8rem;padding-bottom:0">
                                <p style="margin-bottom:0">MELHOR DESEMPENHO DE UPLOAD NA SEMANA</p>
                            </div>
                            <div class="row text-center" style="font-size:1.2rem;">
                                <p style="margin-bottom:0;color:<?php echo print_avg($modulos["maior_up"][1]); ?>"><?php echo $modulos["maior_up"][0]; ?></p>
                            </div>
                            <div class="row text-center">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:3.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder;color:<?php echo print_avg($modulos["maior_up"][1]); ?>">
                                    <?php
                                        if($modulos["maior_up"][1] == "Sem Medição"){
                                            echo "<p font-size: 1.5rem>";
                                            echo $modulos["maior_up"][1]; 
                                            echo "</p>";
                                        }else{
                                            echo $modulos["maior_up"][1]."%"; 
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col dado">
                        <div class="col">
                            <div class="row text-center" style="font-size:.8rem;padding-bottom:0">
                                <p style="margin-bottom:0">PIOR DESEMPENHO DE DOWNLOAD NA SEMANA</p>
                            </div>
                            <div class="row text-center" style="font-size:1.2rem;">
                                <p style="margin-bottom:0;color:<?php echo print_avg($modulos["menor_down"][1]); ?>"><?php echo $modulos["menor_down"][0]; ?></p>
                            </div>
                            <div class="row text-center">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:3.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder;color:<?php echo print_avg($modulos["menor_down"][1]); ?>">
                                    <?php
                                        if($modulos["menor_down"][1] == "Sem Medição"){
                                            echo "<p font-size: 1.5rem>";
                                            echo $modulos["menor_down"][1]; 
                                            echo "</p>";
                                        }else{
                                            echo $modulos["menor_down"][1]."%"; 
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col dado">
                        <div class="col">
                            <div class="row text-center" style="font-size:.8rem;padding-bottom:0">
                                <p style="margin-bottom:0">PIOR DESEMPENHO DE UPLOAD NA SEMANA</p>
                            </div>
                            <div class="row text-center" style="font-size:1.2rem;">
                                <p style="margin-bottom:0;color:<?php echo print_avg($modulos["menor_up"][1]); ?>"><?php echo $modulos["menor_up"][0]; ?></p>
                            </div>
                            <div class="row text-center">
                                <p class="text-center" style="font-family:'Roboto', sans-serif; font-size:3.5rem; padding-bottom: 0; margin-bottom: 0; font-weight: bolder;color:<?php echo print_avg($modulos["menor_up"][1]); ?>">
                                    <?php
                                        if($modulos["menor_up"][1] == "Sem Medição"){
                                            echo "<p font-size: 1.5rem>";
                                            echo $modulos["menor_up"][1]; 
                                            echo "</p>";
                                        }else{
                                            echo $modulos["menor_up"][1]."%"; 
                                        }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <script>
                        window.onload = function () {

                        var chart = new CanvasJS.Chart("graf1", {
                            animationEnabled: true,
                            title:{
                                text: "MÉDIAS DE DOWNLOADS DIÁRIAS"
                            },
                            subtitles: [{
                                text: "Velocidades em Mbps nos últimos 7 dias",
                                fontSize: 18
                            }],
                            axisY: {
                                prefix: "Mbps "
                            },
                            legend:{
                                cursor: "pointer",
                                itemclick: toggleDataSeries
                            },
                            toolTip: {
                                shared: true
                            },
                            data: [
                            <?php
                            $medicoes = chart_creator($_SESSION["id"],"down", $conexao);
                            $cont = 0;
                            foreach($medicoes as $modulo => $dias){
                                
                                if($cont == 0){
                                    ?>
                                    {
                                        type: "area",
                                        name: "<?php echo $modulo; ?>",
                                        showInLegend: "true",
                                        xValueType: "dateTime",
                                        xValueFormatString: "DD/MM/YYYY",
                                        yValueFormatString: "0.## Mbps",
                                        dataPoints: <?php echo json_encode($dias); ?>
                                    }
                                <?php
                                }else{
                                    ?>
                                    ,
                                    {
                                        type: "area",
                                        name: "<?php echo $modulo; ?>",
                                        showInLegend: "true",
                                        xValueType: "dateTime",
                                        xValueFormatString: "DD/MM/YYYY",
                                        yValueFormatString: "0.## Mbps",
                                        dataPoints: <?php echo json_encode($dias); ?>
                                    }
                                    <?php
                                }
                                $cont+= 1;
                            }
                            echo "] });";                  
                            ?>

                            var chart2 = new CanvasJS.Chart("graf2", {
                            animationEnabled: true,
                            title:{
                                text: "MÉDIAS DE UPLOAD DIÁRIAS"
                            },
                            subtitles: [{
                                text: "Velocidades em Mbps nos últimos 7 dias",
                                fontSize: 18
                            }],
                            axisY: {
                                prefix: "Mbps "
                            },
                            legend:{
                                cursor: "pointer",
                                itemclick: toggleDataSeries
                            },
                            toolTip: {
                                shared: true
                            },
                            data: [
                            <?php
                            $medicoes = chart_creator($_SESSION["id"],"up", $conexao);
                            $cont = 0;
                            foreach($medicoes as $modulo => $dias){
                                
                                if($cont == 0){
                                    ?>
                                    {
                                        type: "area",
                                        name: "<?php echo $modulo; ?>",
                                        showInLegend: "true",
                                        xValueType: "dateTime",
                                        xValueFormatString: "DD/MM/YYYY",
                                        yValueFormatString: "0.## Mbps",
                                        dataPoints: <?php echo json_encode($dias); ?>
                                    }
                                <?php
                                }else{
                                    ?>
                                    ,
                                    {
                                        type: "area",
                                        name: "<?php echo $modulo; ?>",
                                        showInLegend: "true",
                                        xValueType: "dateTime",
                                        xValueFormatString: "DD/MM/YYYY",
                                        yValueFormatString: "0.## Mbps",
                                        dataPoints: <?php echo json_encode($dias); ?>
                                    }
                                    <?php
                                }
                                $cont+= 1;
                            }
                            echo "] });";                  
                            ?>
            
                        
                        
                        chart.render();
                        chart2.render();

                        function toggleDataSeries(e){
                            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            }
                            else{
                                e.dataSeries.visible = true;
                            }
                            chart.render();
                            chart2.render
                        }

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