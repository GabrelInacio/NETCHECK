<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $id_user= str_replace(array("'", "\"", "&quot;", ';'), '',$_SESSION['id']);
        $nome_cartao = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['nome_cartao']);
        $nome_titular = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['nome_titular']);
        $cpf_titular = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['cpf']);
        $num_cartao = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['num_cartao']);
        $vencimento = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['vencimento']);
        $vencimento = substr($vencimento, 5, 2).'/'.substr($vencimento, 0, 4);
        $sql = "INSERT INTO pagamento(nome_cartao, nome_titular, cpf_titular, num_cartao, vencimento, id_usuario) VALUES('$nome_cartao', '$nome_titular', '$cpf_titular', '$num_cartao', '$vencimento', $id_user)";
        if(strlen($cpf_titular) < 11 OR strlen($num_cartao) < 19){
            echo "
            <script>
            Swal.fire({
                title: 'Erro!".$vencimento."',
                text: 'Cartão ou CPF incorreto',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('pagamentos.php');
                }
            });
            </script>
            ";
        }else{

            if(mysqli_query($conexao, $sql)){
                echo "
                <script>
                Swal.fire({
                    title: 'Feito!',
                    text: 'Cartão adicionado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('pagamentos.php');
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
                    text: 'Falha no salvamento do Cartão',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('pagamentos.php');
                    }
                });
                </script>
                ";
            }
        }
?>
        <script>
            $(document).ready(function(){
                $("input[name=num_cartao]").inputmask({
                    mask: '9999 9999 9999 9999',
                    keepStatic: true
                });
                $("#cpfexibe").inputmask({
                    mask: '999.999.999-99',
                    keepStatic: true
                });
                $(".botao").focus(function(){
                    var cpf = $("#cpfexibe").val();
                    cpf = cpf.replace('.', '');
                    cpf = cpf.replace('.', '');
                    cpf = cpf.replace('.', '');
                    cpf = cpf.replace('-', '');
                    $("input[id='cpf']").val(cpf);
                    $("input[id='cpf']").attr("value", cpf);
                });
            });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder"> NOVO MEIO DE PAGAMENTO </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="height:2rem;"><br></div>
                </div>
                <form action="salvarcartao.php" method="POST">
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="text" name="nome_cartao" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nome do Cartão <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                             <div class="user-box">
                                <input type="text" name="nome_titular" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nome do Titular do Cartão <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="text" id="cpfexibe" name="cpfexibe" required="true" style="margin-left:0;">
                                <input type="hidden" name="cpf" required="true">
                                <label style="margin-left:0; left:0">CPF do Titular do Cartão<span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="text" name="num_cartao" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Número do Cartão <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input class="date" type="month" name="vencimento" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0; padding-left: 0">Data de Vencimento do Cartão <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">SALVAR</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>