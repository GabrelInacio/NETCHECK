<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $id_usuario = $_SESSION["id"];
        $id_mod = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['idmod']);
        $nome_modulo = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['nome_modulo']);
        $intervalo = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['intervalo']);
        $vel_up = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['vel_up']);
        $vel_down = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['vel_down']);
        $tipo = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['id_plano']);
        $sql="";
        if($id_mod == ""){
            $sql = "INSERT INTO modulo(nome_modulo, vel_up, vel_down, intervalo, id_usuario, situacao, ativo) VALUE ('$nome_modulo', $vel_up, $vel_down, $intervalo, $id_usuario, 1, 1)";
        }else{
            $sql = "UPDATE modulo SET nome_modulo = '$nome_modulo', vel_up = $vel_up, vel_down = $vel_down, intervalo = $intervalo, id_usuario = $id_usuario, situacao = 1 WHERE id = $id_mod";
        }
        if(mysqli_query($conexao, $sql)){
            echo "
            <script>
            Swal.fire({
                title: 'Feito!',
                text: 'Módulo salvo com sucesso!',
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
                text: 'Falha no salvamento do Módulo',
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
                var idmod = <?php echo $id_mod; ?>;
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
                    $("input[name=nome_modulo]").attr("value", "<?php echo $nome_modulo; ?>");
                    $("input[name=vel_down]").attr("value", "<?php echo $vel_down; ?>");
                    $("input[name=vel_up]").attr("value", "<?php echo $vel_up; ?>");
                    $("input[name=intervalo]").attr("value", "<?php echo $intervalo; ?>");
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
                                <input type="number" name="intervalo" required="true" min="5" style="margin-left:0;">
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
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>