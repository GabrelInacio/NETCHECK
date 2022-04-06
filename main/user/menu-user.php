<?php
session_start();
if(isset($_SESSION['id'])){
    include "../../cad/config.php";
    $id = $_SESSION['id'];
    $sql = "SELECT * from usuario WHERE id = '$id' AND ativo = 1";
	$sqlBusca = mysqli_query($conexao, $sql);
	$verificaLogin = mysqli_num_rows($sqlBusca);
    if($verificaLogin == 0){
        header("Location: ../logout.php");
        exit();
    }
}else{
    header("Location: ../logout.php");
    exit();
}
?>
<head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="../../styles/user.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <title>NetCheck</title>
    </head>
    <body>
        <div class="topo">
            <div class="d-flex bd-highlight align-items-center">
                <div class="me-auto p-2 bd-highlight">
                    <img src="../../styles/logos/logo-user.png">
                </div>
                <div class="p-2 bd-highlight">
                    <?php echo"<span class='username'>Seja bem-vindo, ".$_SESSION["nome"]." !</span>"; ?>
                </div>
                <div class="p-2 bd-highlight">
                    <a href="../logout.php" class="logout">SAIR</a>
                </div>
            </div>
        </div>
        <div class="menu">
            <a href="index.php" class="item"><i class="fas fa-home"></i><span style="font-size:2rem">HOME</span></a>
            <a href="usuario.php" class="item"><i class="fas fa-user-circle"></i><span style="font-size:2rem">CONFIGURAÇÕES</span></a>
            <a href="modulos.php" class="item"><i class="fas fa-network-wired"></i><span style="font-size:1.5rem">MÓDULOS DE MEDIÇÃO</span></a>
            <a href="planos.php" class="item"><i class="far fa-gem"></i><span style="font-size:2rem">PLANOS</span></a>
            <a href="pagamentos.php" class="item"><i class="far fa-credit-card"></i><span style="font-size:2rem">PAGAMENTO</span></a>
        </div>
