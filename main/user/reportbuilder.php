<?php
    namespace Mpdf;
    $id_mod = $_GET["idmod"];
    $dtinicio = $_GET["de"];
    $nome_cliente = $_GET["nome"];
    $email_cliente = $_GET["email"];
    $dtfim = $_GET["ate"];
    include "../../cad/config.php";
    if(!isset($_GET["idmod"])){
        header("Location: modulos.php");
    }
    if (isset($_GET['numpag'])) {
        $numpag = $_GET['numpag'];
    } else {
        $numpag = 1;
    }
    $buscamod = "SELECT * FROM modulo WHERE id = $id_mod";
    $pesquisa = mysqli_query($conexao, $buscamod);
    $infomod = mysqli_fetch_array($pesquisa);
    $nome_modulo = $infomod["nome_modulo"];
    $vel_up_mod = $infomod["vel_up"];
    $vel_down_mod = $infomod["vel_down"];

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
    
        <?php
            require_once '../../vendor/autoload.php';
            $mpdf = new mPDF();
            $mpdf->writeHTML(
            '<head>
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
            </head>', 1);
            $mpdf->writeHTML('<body style="position: relative;
            margin: 0 auto; 
            color: #001028;
            background: #FFFFFF; 
            font-family: Arial, sans-serif; 
            font-size: 12px; 
            font-family: Arial;
            padding: 10px 0;
            margin-bottom: 30px;">');
            $header = '
            <header style="
            display: table;
            clear: both;">
                <div style="margin-bottom: 10px;">
                    <h3>Cliente: '.$nome_cliente.'</h3>
                    <h3>E-Mail: '.$email_cliente.'</h3>
                </div>
                <hr>
                <div style="text-align: center; margin-bottom: 10px;">
                    <img src="../../styles/logos/logo_login.png" style="width=100px; margin-left: auto; margin-right: auto;">
                </div>
                <div style="text-align: center; margin-bottom: 10px;">
                    <hr>
                    <h1 style="margin-left: auto; margin-right: auto;font-size: 3rem;"> RELATÓRIO </h1>
                    <h3 style="margin-left: auto; margin-right: auto;font-size: 2rem;">'.$nome_modulo.'</h3>
                    <hr>
                </div>
                <div style="margin-left: auto; margin-right: auto">
                    <div class="modcard" style="margin-left: auto; margin-right: auto; padding-top: 1rem; padding-left: 1rem; padding-right: 1rem; padding-bottom: 1rem;
                    display: table;
                    clear: both; width:50%">
                        <table style="width:50%">
                            <tr colspan="2">
                                <td colspan="2" style="text-align:center; color:white; font-size: 2rem;width:100%">MÉDIA</td>
                            </tr>
                            <tr>
                                <td style="color: white; border-right:1px solid white; padding-right: 1rem;width:100%; text-align:center">Upload</td>
                                <td style="color: white;padding-left: 1rem; width:100%; text-align:center">Download</td>
                            </tr>
                            <tr>
                                <td style="color: white; border-right:1px solid white; padding-right: 1rem;width:100%; text-align:center;">
                                    <p style="font-size: 2rem">'.$modulo['up_mbps'].'</p><p style="font-size: .75rem">('.$modulo['up_pc'].' %)</p>
                                </td>
                                <td style="color: white;padding-left: 1rem; width:100%; text-align:center;">
                                    <p style="font-size: 2rem">'.$modulo['down_mbps'].'</p><p style="font-size: .75rem">('.$modulo['down_pc'].' %)</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: white; border-right:1px solid white; padding-right: 1rem;width:100%; text-align:center">Em Mbps</td>
                                <td style="color: white;padding-left: 1rem; width:100%; text-align:center">Em Mbps</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <br>
                <table style="margin-right:auto; margin-left: auto;">
                    <tr>
                        <td style="font-size: 2rem;">DE: '.date_format(date_create($dtinicio), 'd/m/Y').'</td>
                        <td style="font-size: 2rem;">-</td>
                        <td style="font-size: 2rem;">ATÉ: '.date_format(date_create($dtfim), 'd/m/Y').'</td>
                    </tr>
                </table>
            </header>';

            $main = '<br>
                        <table style="margin-left: auto; margin-right: auto;">
                            <tr>
                                <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">Download em Mbps</td>
                                <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">Upload em Mbps</td>
                                <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">Data e Hora da Medição</td>
                                <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">Provedora</td>
                            </tr>
                        <tr colspan="4">
                            <td colspan="4"><hr></td>
                        </tr>';
            $sql = "SELECT * FROM medicao WHERE id_modulo = $id_mod AND data_medicao BETWEEN '$dtinicio' AND '$dtfim 23:59:59' ORDER BY data_medicao DESC";
            $resultado = mysqli_query($conexao,$sql);
            while($row = mysqli_fetch_array($resultado)){
                $data= date_format(date_create($row["data_medicao"]), 'd/m/Y H:i:s');
                $main = $main.'
                    <tr>
                        <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">'.$row["vel_down"].' Mbps</td>
                        <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">'.$row["vel_up"].' Mbps</td>
                        <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">'.$data.'</td>
                        <td style="border-right: 1px solid black; text-align:center; padding-right: .5rem; padding-left: .5rem;">'.$row["operadora"].'</td>
                    </tr>
                    <tr colspan="4">
                        <td colspan="4"><hr></td>
                    </tr>';
            }
            $main.="</table></main>";
            $mpdf->writeHTML($header);
            $mpdf->writeHTML($main);
            $mpdf->writeHTML('</body>');
            $mpdf->Output();
        ?>