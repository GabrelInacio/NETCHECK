<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $tipo = $_SESSION["id_plano"];
        if(!isset($_GET["idmod"])){
            $id_mod = "";
        }else{
            $id_mod = $_GET["idmod"];
            $buscamod = "SELECT * FROM modulo WHERE id = $id_mod";
            $pesquisa = mysqli_query($conexao, $buscamod);
            $infomod = mysqli_fetch_array($pesquisa);
            $nome_modulo = $infomod["nome_modulo"];
            $vel_up_mod = $infomod["vel_up"];
            $vel_down_mod = $infomod["vel_down"];
            $intervalo = $infomod["intervalo"];
        }
        $id_mod = $_GET["idmod"];
        $sql = "UPDATE modulo set hash_modulo = null, operadora = null WHERE id = $id_mod";
        if(mysqli_query($conexao, $sql)){
            echo "
            <script>
            Swal.fire({
                title: 'Feito!',
                text: 'Validação do módulo reiniciada com sucesso!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('modulos.php');
                }
            });
            </script>
            ";
        }
        else{
            echo "
            <script>
            Swal.fire({
                title: 'Erro!',
                text: 'Falha ao reiniciar a validação do módulo',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('modulos.php');
                }
            });
            </script>
            ";
        }
        
?>
        <script>
            $(document).ready(function(){
                var idmod = "<?php echo $id_mod; ?>";
                var tipo = <?php echo $tipo; ?>;
                if (idmod == ""){
                    $("input[name=nome_modulo]").attr("value", "");
                    $("input[name=vel_down]").attr("value", "");
                    $("input[name=vel_up]").attr("value", "");
                    switch (tipo){
                        case "0":
                            $("input[name=intervalo]").attr("min", "30");
                            break;
                        case 0:
                            $("input[name=intervalo]").attr("min", "30");
                            break;
                        case 1:
                            $("input[name=intervalo]").attr("min", "6");
                            break;
                        case "1":
                            $("input[name=intervalo]").attr("min", "6");
                            break;
                        case "2":
                            $("input[name=intervalo]").attr("min", "1");
                            break;
                        case 2:
                            $("input[name=intervalo]").attr("min", "1");
                            break;
                    }
                }else{
                    $("input[name=nome_modulo]").attr("value", "<?php if(isset($nome_modulo)){echo $nome_modulo; }else{ echo " "; }?>");
                    $("input[name=vel_down]").attr("value", "<?php if(isset($vel_down_mod)){echo $vel_down_mod; }else{ echo " "; }?>");
                    $("input[name=vel_up]").attr("value", "<?php if(isset($vel_up_mod)){echo $vel_up_mod; }else{ echo " "; }?>");
                    $("input[name=intervalo]").attr("value", "<?php if(isset($intervalo)){echo $intervalo; }else{ echo " "; }?>");
                    switch (tipo){
                        case "0":
                            $("input[name=intervalo]").attr("min", "30");
                            break;
                        case 0:
                            $("input[name=intervalo]").attr("min", "30");
                            break;
                        case 1:
                            $("input[name=intervalo]").attr("min", "6");
                            break;
                        case "1":
                            $("input[name=intervalo]").attr("min", "6");
                            break;
                        case "2":
                            $("input[name=intervalo]").attr("min", "1");
                            break;
                        case 2:
                            $("input[name=intervalo]").attr("min", "1");
                            break;
                    }
                }
            });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">CONFIGURAÇÕES DO MÓDULO DE MEDIÇÃO - <?php if (isset($nome_modulo)){ echo $nome_modulo; }else{ echo "NOVO MÓDULO"; } ?> </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="height:2rem;"><br></div>
                </div>
                <form action="salvarmodulo.php" method="POST">
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="hidden" name="idmod" value="<?php echo $id_mod; ?>">
                                <input type="text" name="nome_modulo" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nome do Módulo <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                             <div class="user-box">
                                <input type="number" name="intervalo" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Intervalo de Medições em minutos:<span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="number" name="vel_down" required="true"  min="0" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Velocidade de Download Contratada (Em Mbps): <span style="color: red; "> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="number" name="vel_up" required="true" min="0" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Velocidade de Upload Contratada (Em Mbps): <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">SALVAR</a>
                        </div>
                        <div class="col" style="margin-top:2px;">
                            <a class="botao" style="padding-bottom: .5rem">GERAR ARQUIVOS DE INSTALAÇÃO</a>
                        </div>
                        <div class="col" style="margin-top:2px;">
                            <a class="botao" style="padding-bottom: .5rem">REINICIAR VALIDAÇÃO DO MÓDULO</a>
                        </div>
                        <?php if($id_mod != ""){ ?>
                        <div class="col" style="margin-top:2px;">
                            <a href="deletamodulo.php?idmod=<?php echo $id_mod; ?>" class="botao" style="padding-bottom: .5rem"><i class="fas fa-trash"></i> REMOVER MÓDULO</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>