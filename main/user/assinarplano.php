<?php
        include("menu-user.php"); 
        include "../../cad/config.php";
        $planos = [1 => "GRATUITO", 2 => "ARIA", 3 => "REQUIEM"];
        $id_usuario = $_SESSION["id"];
        $sql = "SELECT * FROM pagamento WHERE id_usuario = $id_usuario";
        $plano = $_POST["planoid"];
        $cpf = $_POST["cpf"];
        $id_cartao = $_POST["id"];
        $sql2 = "SELECT * FROM pagamento WHERE id_usuario = $id_usuario AND id = $id_cartao AND cpf_titular = '$cpf'";
        
        $resultado_checagem = mysqli_query($conexao, $sql2);
        if (mysqli_num_rows($resultado_checagem)>0){
            $sql5 = "UPDATE fatura set situacao = 1 WHERE id_usuario = $id_usuario";
            $ok = mysqli_query($conexao, $sql5);
            $sql3 = "UPDATE usuario set id_plano = $plano WHERE id=$id_usuario";
            $mes = date("m");
            $data = date("Y-".($mes+1)."-15 00:00:00");
            $sql4 = "INSERT INTO fatura VALUES (0, '$data', 0, $id_usuario)";
            if(mysqli_query($conexao, $sql3)){
                if(mysqli_query($conexao, $sql4)){
                    $_SESSION["id_plano"] = $plano;
                    echo "
                    <script>
                    Swal.fire({
                        title: 'Feito!',
                        text: 'Assinatura realizada com sucesso!',
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
                        text: 'Erro na assinatura do plano',
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
            }else{
                echo "
                <script>
                Swal.fire({
                    title: 'Erro!',
                    text: 'Erro na assinatura do plano',
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
            
        }else{
            echo "
            <script>
            Swal.fire({
                title: 'Erro!',
                text: 'Validações do cartão incorretas',
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
            $(".modcard").hide();
            $(".info1").hide();
            $(".info2").hide();
            $(".info3").hide();
            $("#cpfexibe").inputmask({
                mask: '999.999.999-99',
                keepStatic: true
            });
            $(".my-btn").focus(function(){
                var cpf = $("#cpfexibe").val();
                var email = $("#exibeemail").val();
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('-', '');
                $("input[id='cpf']").val(cpf);
                $("input[id='cpf']").attr("value", cpf);
                $("#email").val(email);
                $("#email").attr("value", email);
            });

            $('select').change(function () {
                var optionSelected = $(this).find("option:selected");
                var valueSelected = optionSelected.val();
                var textSelected = optionSelected.text();
                var nome = optionSelected.data("nome");
                var numero = optionSelected.data("numero");
                var vencimento = optionSelected.data("vencimento");
                if (textSelected != ""){
                    $(".modcard").show();
                    document.getElementById("numero").innerHTML = ""+numero;
                    document.getElementById("nome").innerHTML = ""+(nome.toUpperCase());
                    document.getElementById("vencimento").innerHTML = "EXPIRA EM: "+vencimento;
                    $(".info1").show();
                    $(".info2").show();
                    $(".info3").show();
                    
                }else{
                    $(".modcard").hide();
                    $(".info1").hide();
                    $(".info2").hide();
                    $(".info3").hide();
                    
                }
            });
        });
    </script>
        <div class="conteudo">
            <div class="container">
                <div class="row justify-content-center">
                    <h1 style="font-weight: bolder">NOVA ASSINATURA</h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row justify-content-center">
                    <h1 class="text-center" style="font-weight: bolder; font-size:3.5rem">PLANO <?php echo $planos[$plano];?></h1>
                </div>
                <div class="row justify-content-center" style="padding-top:1rem;">
                    <div class="col-sm-3">
                        <form action="assinarplano.php" method="POST">
                        <label style="top: -28px; color: #949494; font-size: 16px;padding-left:3rem;">Selecione o cartão <span style="color: red;"> *</span></label>
                        <div class="user-box">  
                            <select name="id" required="true"> 
                                <option value="" data-nome="" data-vencimento="" data-numero=""></option>
                            <?php
                                $resultado = mysqli_query($conexao, $sql);
                                if(mysqli_num_rows($resultado)>0){
                                    while($row = mysqli_fetch_array($resultado)){
                                        ?>
                                        <option value="<?php echo $row["id"]; ?>" data-nome="<?php echo $row["nome_titular"]; ?>" data-vencimento="<?php echo $row["vencimento"];?>" data-numero="<?php echo $row["num_cartao"];?>"><?php echo $row["nome_cartao"]; ?></option>
                                        <?php
                                    }
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center" style="padding-top:0">
                    <div class="col-sm-4 modcard" style="background-color: #DC3338;margin-right:0">
                        <div class="row">
                            <div class="col">
                                <h3>BANDEIRA</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 id="numero">9999</h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 id="nome">BANDEIRA</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h5 id="vencimento">EXPIRA EM: 99/99</h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center info1" style="padding-top:2rem;">
                    <div class="col-sm-2">
                        <div class="user-box">  
                            <input type="text" name="cpfexibe" id="cpfexibe" required="true">
                            <label style="left:2rem">CPF do Titular <span style="color: red;"> *</span></label>
                            <input type="hidden" name="cpf" id="cpf">
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center info2" style="padding-top:1rem;">
                    <div class="col-sm-2">
                        <div class="user-box">  
                            <input type="text" name="cvv" required="true">
                            <label style="left:2rem">CVV<span style="color: red;" maxlength="3"> *</span></label>
                        </div>
                    </div>
                </div>
                <div class="row info3" style="padding-bottom:3rem;">
                    <div class="col-sm d-flex justify-content-center ">
                        <button class="botao2" style="margin-left:1rem">ASSINAR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>