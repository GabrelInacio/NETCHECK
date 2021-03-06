<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $plano = $_SESSION["id_plano"];
        $planos = [1 => "GRATUITO", 2 => "ARIA", 3 => "REQUIEM"];
        $id_usuario = $_SESSION["id"];
        $sql = "SELECT * FROM fatura WHERE situacao = 0 AND id_usuario = $id_usuario ORDER BY data_vencimento DESC";
        $resultado = mysqli_query($conexao, $sql);
        $data_vencimento = "";
        if(mysqli_num_rows($resultado)>0){
            $data = mysqli_fetch_array($resultado);
            $data_vencimento = $data["data_vencimento"];
        }
        $sql5 = "UPDATE fatura set situacao = 1 WHERE id_usuario = $id_usuario";
        $ok = mysqli_query($conexao, $sql5);
        $sql2 = "UPDATE usuario SET id_plano = 1 WHERE id = $id_usuario";
        if(mysqli_query($conexao, $sql2)){
            $_SESSION["id_plano"] = 1;
            
            echo "
            <script>
            Swal.fire({
                title: 'OK!',
                text: 'Assinatura cancelada com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('planos.php');
                }
            });
            </script>
            ";
        }else{
            echo "
            <script>
            Swal.fire({
                title: 'Erro!',
                text: 'Erro no cancelamento do plano',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('planos.php');
                }
            });
            </script>
            ";
        }
        

?>
    <script>
        $(document).ready(function(){
            var plano = <?php echo $plano; ?>;
            switch (plano){
                case 1:
                    $("#gratuito").attr("class", "col cardsel");
                    $("#aria").attr("class", "col cardnot");
                    $("#requiem").attr("class", "col cardnot");
                    $("#assinagratuito").hide();
                    $("#assinarequiem").show();
                    $("#assinaaria").show();
                    break;
                case "1":
                    $("#gratuito").attr("class", "col cardsel");
                    $("#aria").attr("class", "col cardnot");
                    $("#requiem").attr("class", "col cardnot");
                    $("#assinagratuito").hide();
                    $("#assinarequiem").show();
                    $("#assinaaria").show();
                    break;
                case 2:
                    $("#gratuito").attr("class", "col cardnot");
                    $("#aria").attr("class", "col cardsel");
                    $("#requiem").attr("class", "col cardnot");
                    $("#assinagratuito").show();
                    $("#assinarequiem").show();
                    $("#assinaaria").hide();
                    break;
                case "2":
                    $("#gratuito").attr("class", "col cardnot");
                    $("#aria").attr("class", "col cardsel");
                    $("#requiem").attr("class", "col cardnot");
                    $("#assinagratuito").show();
                    $("#assinarequiem").show();
                    $("#assinaaria").hide();
                    break;
                case 3:
                    $("#gratuito").attr("class", "col cardnot");
                    $("#aria").attr("class", "col cardnot");
                    $("#requiem").attr("class", "col cardsel");
                    $("#assinagratuito").show();
                    $("#assinarequiem").hide();
                    $("#assinaaria").show();
                    break;
                case "3":
                    $("#gratuito").attr("class", "col cardnot");
                    $("#aria").attr("class", "col cardnot");
                    $("#requiem").attr("class", "col cardsel");
                    $("#assinagratuito").show();
                    $("#assinarequiem").hide();
                    $("#assinaaria").show();
                    break;
            }
        });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 style="font-weight: bolder">PLANOS DE ASSINATURA </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-sm-4 modcard" style="margin: auto;" >
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center" style="margin-top:.5rem;margin-bottom:0rem;"><b>PLANO ATUAL: </b></h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h1 class="text-center" style="font-size: 2.5rem;"><b><?php echo $planos[$plano];?></b></h1>
                            </div>
                        </div>

                        <?php if($plano != "1"){?>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">PR??XIMA FATURA: <?php echo date_format(date_create($data_vencimento), 'd/m/Y'); ?></h5>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-auto" style="padding-bottom:1rem;">
                                <a href="cancelarplano.php" class="botao" style="margin:0">CANCELAR ASSINATURA</a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>    
                </div>

                <div class="row justify-content-center" style="margin-top:1rem;margin-bottom:1rem">
                    <h1 style="font-weight: bolder; font-size: 3rem; text-align:center">ESCOLHA SEU PLANO DELUXE</h1>
                </div>
                <div class="row justify-content-center" style="margin-top:1rem;margin-bottom:1rem">
                    

                    <div class="col" id="gratuito">
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <h1 class="text-center" style="font-size: 2.5rem;"><b><?php echo $planos[1];?></b></h1>
                            </div>    
                        </div>
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <br>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  3 meses de validade para suas medi????es </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 2 medi????es por hora </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 3 m??dulos cadastr??veis </b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="cancelarplano.php" class="botao2" id="assinagratuito">ASSINE J??</a>
                            </div>    
                        </div>
                    </div>


                    <div class="col" id="aria">
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <h1 class="text-center" style="font-size: 2.5rem;"><b><?php echo $planos[2];?></b></h1>
                            </div>    
                        </div>
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <h4 class="text-center"><b>R$ 35,00/ M??s</b></h4>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  6 meses de validade para suas medi????es </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 10 medi????es por hora </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 6 m??dulos de medi????o </b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="assinandoplano.php?planoid=<?php echo "2"; ?>" class="botao2" id="assinaaria">ASSINE J??</a>
                            </div>    
                        </div>
                    </div>


                    <div class="col" id="requiem">
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <h1 class="text-center" style="font-size: 2.5rem;"><b><?php echo $planos[3];?></b></h1>
                            </div>    
                        </div>
                        <div class="row justify-content-center">
                            <div class="col justify-content-center">
                                <h4 class="text-center"><b>R$ 50,00/ M??s</b></h4>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Medi????es v??lidas hoje e para sempre</b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 60 medi????es por hora</b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  At?? 10 m??dulos de medi????o</b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="assinandoplano.php?planoid=<?php echo "3"; ?>" class="botao2" id="assinarequiem">ASSINE J??</a>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        

    </body>
</html>