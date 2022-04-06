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
        $sql2 = "SELECT * FROM modulo WHERE id_usuario = $id_usuario AND ativo = 1";
        $resultado2 = mysqli_query($conexao, $sql2);
        $qtd_modulos = mysqli_num_rows($resultado2);
        
        $sql3 = "SELECT * FROM pagamento WHERE id_usuario = $id_usuario";
        $resultado3 = mysqli_query($conexao, $sql3);
        $qtd_cartoes = mysqli_num_rows($resultado3);
        

?>
    <script>
        $(document).ready(function(){
            var plano = <?php echo $plano; ?>;
            var n_modulos = <?php echo $qtd_modulos; ?>;
            $("#cancela").on('mousedown mouseup', function(){
                if (n_modulos > 2){
                    Swal.fire({
                        title: 'Não é possível mudar de plano!',
                        text: "Você tem mais módulos do que o plano que você quer assinar permite!",
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'OK',
                    });
                }
            });

                    

            $("#assinagratuito").on('mousedown mouseup', function(){
                if (n_modulos > 2){
                    Swal.fire({
                        title: 'Não é possível mudar de plano!',
                        text: "Você tem mais módulos do que o plano que você quer assinar permite!",
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'OK',
                    });
                }
            });

            var cartoes = "<?php echo $qtd_cartoes; ?>";
            $("#assinaaria").on('mousedown mouseup', function(){
                if (n_modulos > 6){
                    Swal.fire({
                        title: 'Não é possível mudar de plano!',
                        text: "Você tem mais módulos do que o plano que você quer assinar permite!",
                        icon: 'error',
                        showCancelButton: true,
                        showConfirmButton: false,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'OK',
                    });
                }    
                
                if (cartoes < 1){
                    Swal.fire(
                        'Ação bloqueada!',
                        'Favor cadastrar um cartão de crédito',
                        'error'
                    );
                }
            });

            $("#assinarequiem").on('mousedown mouseup', function(){
                if (cartoes < 1){
                    Swal.fire(
                        'Ação bloqueada!',
                        'Favor cadastrar um cartão de crédito',
                        'error'
                    );
                }
            });
            
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
                                <h1 class="text-center" style="font-size: 2rem;"><b><?php echo $planos[$plano];?></b></h1>
                            </div>
                        </div>

                        <?php if($plano != "1"){?>
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">PRÓXIMA FATURA: <?php echo date_format(date_create($data_vencimento), 'd/m/Y'); ?></h5>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-md-auto" style="padding-bottom:1rem;">

                                <a href="cancelarplano.php" id="cancela" class="botao" style="margin:0">CANCELAR ASSINATURA</a>
                            </div>
                        </div>
                        <?php } ?>
                    </div>    
                </div>

                <div class="row justify-content-center" style="margin-top:1rem;margin-bottom:1rem">
                    <h1 style="font-weight: bolder; font-size: 2rem; text-align:center">ESCOLHA SEU PLANO DELUXE</h1>
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
                                <span><b>  3 meses de validade para suas medições </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 2 medições por hora </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 3 módulos cadastráveis </b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="cancelarplano.php" class="botao2" id="assinagratuito">ASSINE JÁ</a>
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
                                <h4 class="text-center"><b>R$ 35,00/ Mês</b></h4>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  6 meses de validade para suas medições </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 4 medições por hora </b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 6 módulos de medição </b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="assinandoplano.php?planoid=<?php echo "2"; ?>" class="botao2" id="assinaaria">ASSINE JÁ</a>
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
                                <h4 class="text-center"><b>R$ 50,00/ Mês</b></h4>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Medições válidas hoje e para sempre</b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 10 medições por hora</b></span>
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-sm-1" style="padding-top:.5rem; padding-botom:.25rem;padding-left:3rem; padding-right:1.5rem;">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="col" style="padding-top:.25rem; padding-botom:.25rem">
                                <span><b>  Até 10 módulos de medição</b></span>
                            </div>    
                        </div>
                        <div class="row" style="padding-bottom:.5rem;padding-top:1.5rem">
                            <div class="col text-center" style="padding-top:.25rem; padding-botom:.25rem">
                                <a href="assinandoplano.php?planoid=<?php echo "3"; ?>" class="botao2" id="assinarequiem">ASSINE JÁ</a>
                            </div>    
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        

    </body>
</html>