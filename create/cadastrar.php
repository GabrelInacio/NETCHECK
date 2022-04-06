<html>
<head>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <script src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
    <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NetCheck</title>
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php
	include "config.php";
    $nome = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['nome']);
    $email = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['email']);
    $login = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['login']);
    $cpf = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['cpf']);
	$senha = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['senha']);
    $senha = hash("sha256", $senha);
    $email = strtolower($email);
    $criado = date("Y-m-d h:i:s");
    $sql = "SELECT * from usuario WHERE login = '$login' OR cpf = '$cpf'";
	$sqlBusca = mysqli_query($conexao, $sql);
	$verificaLogin = mysqli_num_rows($sqlBusca);
    if(strlen($cpf)==11){
        if($verificaLogin == 0){
            $sqlCadastro = "INSERT INTO usuario(nome,email,login, cpf, senha, tipo_usuario, id_plano, ativo, created) VALUES('$nome', '$email','$login', '$cpf', '$senha', 1, 1, 1, '$criado')";
            if(mysqli_query($conexao,$sqlCadastro)){
                echo "
                <script>
                Swal.fire({
                    title: 'Feito!',
                    text: 'Cadastro realizado com sucesso!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('../login.php');
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
                    text: 'Falha no cadastro. Por favor revise os dados inseridos!',
                    icon: 'error',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('cadastro.php');
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
                text: 'Falha no cadastro. Usuário já cadastrado!',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('cadastro.php');
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
                text: 'Falha no cadastro. CPF Inválido!',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('cadastro.php');
                }
            });
            </script>
            ";
    }
?>
<body>
        <div class="sidenav">
            <div style="padding-top: 20%; padding-bottom: 10%;">
                <div class="logo">
                    <img src="../styles/logos/logo_login.png" style="width:70%">
                </div>
                <div class="row">
                    <br>
                </div>
                    <div class="user-box">
                        <input type="email" name="email" required="true">
                        <label>E-Mail</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="nome" required="true">
                        <label>Nome</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="login" required="true">
                        <label>Login</label>
                    </div>
                    <div class="user-box">
                        <input type="text" name="cpf" required="true">
                        <label>CPF</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="senha" required="true">
                        <label>Senha</label>
                    </div>
                    <div class="row"><br></div>
                    <div class="row">
                        <div class="col-sm">
                            <button class="my-btn">CADASTRAR</a>
                        </div>
                    </div>
            </div>
        </div>
        <div class="back">
            <video autoplay muted loop class="fundo">
                <source src="../styles/fundo/bg3.mp4" type="video/mp4">
              </video>              
        </div>
    </body>
</html>
</body>
</html>