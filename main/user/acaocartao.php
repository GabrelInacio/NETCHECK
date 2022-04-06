<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
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
                    var vencimento = $("#vencimento").val()
                    var hoje = "<?php $data = date("Y"); echo ($data+1)."-".date("m"); ?>";
                    if(hoje >= vencimento){
                        Swal.fire(
                        'Impossível continuar!',
                        'Dados inválidos no cartão!',
                        'error'
                        );
                        $("#vencimento").val("");
                    }
                });

                $("#vencimento").focusout(function(){
                    var vencimento = $("#vencimento").val()
                    var hoje = "<?php $data = date("Y"); echo ($data+1)."-".date("m"); ?>";
                    if(hoje >= vencimento){
                        Swal.fire(
                        'Data inválida!',
                        'O cartão está vencido!',
                        'error'
                        );
                        $("#vencimento").val("");
                    }
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
                                <input type="hidden" id="cpf" name="cpf" required="true">
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
                                <input class="date" type="month" name="vencimento" id="vencimento" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0; padding-left: 0">Data de Vencimento do Cartão <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">SALVAR</button>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>