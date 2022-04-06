<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";
        function randomPassword() {
            $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
            $pass = array();
            $alphaLength = strlen($alphabet) - 1;
            for ($i = 0; $i < 6; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass);
        }

        $id_user= str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['iduser']);
        $nome = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['nome']);
        $login = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['login']);
        $senha = randomPassword();
        $sql = "INSERT INTO usuario (nome, login, senha, ativo, tipo_usuario) VALUES ('$nome', '$login', SHA2('$senha', 256), 1, 2)";
        $sql2 = "SELECT * FROM usuario WHERE login = '$login'";
        $busca = mysqli_query($conexao, $sql2);
        if(mysqli_num_rows($busca)>0 AND $login != $_SESSION["login"]){
            echo "
            <script>
            Swal.fire({
                title: 'Erro!',
                text: 'Login já cadastrado',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('addadmin.php');
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
                    text: 'Usuário criado com sucesso! A sua senha de login inicial: ".$senha."',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('addadmin.php');
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
                    text: 'Falha no salvamento do Usuário',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('addadmin.php');
                    }
                });
                </script>
                ";
            }
        }
?>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">ADICIONAR NOVO ADMINISTRADOR </h1>
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
                            <a class="botao" style="padding-bottom: .5rem">DESATIVAR USUÁRIO</a>
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>