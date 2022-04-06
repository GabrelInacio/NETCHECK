<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";
        $id_user= str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['iduser']);
        $senhaold = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['senhaold']);
        $senhanova = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['senhanova']);
        
        $sql = "UPDATE usuario SET senha = SHA2('$senhanova', 256) WHERE id = $id_user";
        $sql2 = "SELECT * FROM usuario WHERE senha = SHA2('$senhaold', 256) AND id = $id_user";
        $busca = mysqli_query($conexao, $sql2);
        if(mysqli_num_rows($busca)>0){

            if(mysqli_query($conexao, $sql)){
                echo "
                <script>
                Swal.fire({
                    title: 'Feito!',
                    text: 'Senha alterada com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('usuario.php');
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
                    text: 'Falha na alteração da senha',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('usuario.php');
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
                text: 'Falha na alteração da senha',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('usuario.php');
                }
            });
            </script>
            ";
        }
?>
        <script>
            $(document).ready(function(){
                $("input[name=nome]").attr("value", "<?php echo $nome;?>");
                $("input[name=login]").attr("value", "<?php echo $login;?>");
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
                <form action="reconfigurarsenha.php" method="POST">
                <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="hidden" name="iduser" value="<?php echo $id_user; ?>">
                                <input type="password" name="nome" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Senha Antiga <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                             <div class="user-box">
                                <input type="password" name="login" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nova Senha <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">CONFIRMAR TROCA DE SENHA</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>