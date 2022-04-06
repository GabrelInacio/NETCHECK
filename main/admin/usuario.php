<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";
        $id_user= $_SESSION["id"];
        $nome = $_SESSION["nome"];
        $login = $_SESSION["login"];
?>
        <script>
            $(document).ready(function(){
                $("input[name=nome]").attr("value", "<?php echo $nome;?>");
                $("input[name=login]").attr("value", "<?php echo $login;?>");

                $("#deleta").click(function(){
                    Swal.fire({
                    title: 'Desativar conta?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não, cancelar',
                    confirmButtonText: 'Sim, desativar!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('deletauser.php');
                    }
                    });
                });
            });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">CONFIGURAÇÕES DE USUÁRIO </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="height:2rem;"><br></div>
                </div>
                <form action="salvaruser.php" method="POST">
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="hidden" name="iduser" value="<?php echo $id_user; ?>">
                                <input type="text" name="nome" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nome <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                             <div class="user-box">
                                <input type="text" name="login" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Login <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">SALVAR</a>
                        </div>
                        <div class="col" style="margin-top:2px;">
                            <a id="deleta" class="botao" style="padding-bottom: .5rem">DESATIVAR USUÁRIO</a>
                        </div>
                        <div class="col" style="margin-top:2px;">
                            <a href="reconfigurasenha.php" class="botao" style="padding-bottom: .5rem">TROCA DE SENHA</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>