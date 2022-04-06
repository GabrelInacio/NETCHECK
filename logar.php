<html>
    <head>
        <link rel="stylesheet" href="styles/login.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NetCheck</title>
    </head>
    <body>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <div class="sidenav">
            <div style="padding-top:30%; padding-bottom:20%;">
                <div class="logo">
                    <img src="styles/logos/logo_login.png" style="width:70%">
                </div>
                <div class="row">
                    <br>
                </div>
                <form action="logar.php" method="POST">
                    <div class="user-box">
                        <input type="text" name="login" required="true">
                        <label>Login</label>
                    </div>
                    <div class="user-box">
                        <input type="password" name="senha" required="true">
                        <label>Senha</label>
                    </div>
                    <div class="row"><br></div>
                    <div class="row">
                        <div class="col-sm">
                            <button type="submit" class="my-btn">LOGIN</a>
                        </div>

                        <div class="col-sm">
                            <a class="my-btn" href="cad/cadastro.php">CADASTRAR</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="back">
            <video autoplay muted loop class="fundo">
                <source src="styles/fundo/bg3.mp4" type="video/mp4">
              </video>              
        </div>
    </body>
</html>





<!-- IMPORTANTE COMEÇA AQUI! -->
<?php 
    $login = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['login']);
    $senha = str_replace(array("'", "\"", "&quot;", ';'), '',$_POST['senha']);
    $senha = hash("sha256", $senha);
    include 'cad/config.php';

    $sql = "SELECT * from usuario WHERE login = '$login' AND senha = '$senha' AND ativo = 1";
	$sqlBusca = mysqli_query($conexao, $sql);
	$verifica = mysqli_num_rows($sqlBusca);
    $retorno = mysqli_fetch_array($sqlBusca);
    if($verifica > 0){
        session_start();
        $_SESSION['id'] = $retorno[0];
        $_SESSION['nome'] = $retorno[1];
        $_SESSION['login'] = $retorno[2];
        $_SESSION['email'] = $retorno[5];
        $_SESSION['tipo_usuario'] = $retorno[4];
        $_SESSION['id_plano'] = $retorno[6];
        if($_SESSION['tipo_usuario']==1){
            header("Location: main/user/index.php");
        }else if($_SESSION['tipo_usuario']==2){
            header("Location: main/admin/index.php");
        } 
    }else{
        echo "
            <script>
            Swal.fire({
                title: 'Falha no Login!',
                text: 'Usuário ou senha incorretos!',
                icon: 'error',
                confirmButtonText: 'OK'
              }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace('login.php');
                }
              });
            </script>
            ";
    }
?>
