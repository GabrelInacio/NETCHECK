<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";

        $id_cartao = $_GET["cardid"];
        $sql = "DELETE FROM pagamento WHERE id = $id_cartao";
        if(mysqli_query($conexao, $sql)){
            echo "
            <script>
            Swal.fire({
                title: 'Feito!',
                text: 'Cartão de crédito removido com sucesso!',
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
                text: 'Falha na remoção do cartão de crédito',
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
        function listar_pagamentos($user_id, $conexao){

            $cards = [];
            $sql1 = "SELECT * FROM pagamento WHERE id_usuario = $user_id";
            $sqlBusca = mysqli_query($conexao, $sql1);
            $contagem = mysqli_num_rows($sqlBusca);
            if ($contagem > 0){
                $cards=[];
                while($linha = mysqli_fetch_array($sqlBusca)) {
                    
                    $card = ["id" => $linha["id"], "nome_cartao" => $linha["nome_cartao"], "nome_titular" => $linha["nome_titular"], "num_cartao" => $linha["num_cartao"], "vencimento" => $linha["vencimento"]]; 
                    array_push($cards, $card);
                }
            }
            return $cards;
        }
    ?>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">MEIOS DE PAGAMENTO</h1>
                    <div class="col-xs-12"><hr></div>
                </div>
    
                <?php 
                    $cartoes = listar_pagamentos($_SESSION["id"], $conexao);
                    if (count($cartoes) > 0){
                        foreach($cartoes as $cartao){
                    
                ?>
                <div class="row">
                    <div class="col modcard" style="background-color: #DC3338;">
                        <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                            <h2 style="font-weight: bolder" > <?php echo $cartao["nome_cartao"]; ?></h2>
                            <div class="col-xs-12"><hr></div>
                        </div>

                        <div class="row" style="padding-left: 2rem;">
                            <div class="col">
                                <h3>Nome do Titular: <?php echo $cartao["nome_titular"]; ?></h3>
                            </div>
                        </div>
                        
                        <div class="row" style="padding-left: 2rem;">
                            <div class="col">
                                <h3>Número do Cartão: <?php echo $cartao["num_cartao"]; ?> </h3>
                            </div>
                        </div>

                        <div class="row" style="padding-left: 2rem;">
                            <div class="col d-flex flex-wrap align-items-center">
                                <h3>Expira em: <?php echo $cartao["vencimento"]; ?> </h3>
                            </div>
                        </div>
                        

                        <div class="row d-flex justify-content-end" style="margin-top: 1rem; margin-bottom: 1rem;">
                            <div class="col-2">
                                <a href="<?php echo 'deletacartao.php?cardid='.$cartao['id'];?>" class="botao3">REMOVER CARTÃO</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <?php 
                        }
                    }
                ?>

                <div class="row">
                    <a href="acaocartao.php" class="col anticard">
                        <div class="row" style="padding-left: 2rem; padding-top: .5rem;">
                            <h2 style="font-weight: bolder" ><i class="fas fa-plus"></i> CADASTRAR NOVO MEIO DE PAGAMENTO</h2>
                        </div>
                    </a>
                </div>
                        
                <br>

            </div>
        </div>
    </body>
</html>