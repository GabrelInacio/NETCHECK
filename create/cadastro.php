<html>
    <head>
        <link rel="stylesheet" href="../styles/login.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@200&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <script src="https://code.jquery.com/jquery-1.10.0.min.js"></script>
        <script src="https://rawgit.com/RobinHerbots/Inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
        <meta name="HandheldFriendly" content="true">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>NetCheck</title>
    </head>
    <body>
        <script>
            
            $( document ).ready(function() {
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
                $("#exibeemail").focusout(function(){
                    var email = $("#exibeemail").val();
                    $("#email").val(email);
                    $("#email").attr("value", email);
                });
                $("#email").focusout(function(){
                    var email = $("#email").val();
                    $("#exibeemail").val(email);
                    $("#exibeemail").attr("value", email);
                });
                
            });
        </script>
        <div class="sidenav">
            <div style="padding-top: 20%; padding-bottom: 10%;">
                <div class="logo">
                    <img src="../styles/logos/logo_login.png" style="width:70%">
                </div>
                <div class="row">
                    <br>
                </div>
                <form action="cadastrar.php" method="POST">
                    <div class="user-box">
                        <input type="text" id="exibeemail" required="true">
                        <input type="email" name="email" id="email" required="true" style="color: white; border-bottom: 0px; height:1px; padding: 1px 1px 1px 1px ; margin-top: 0; margin-bottom: 0; user-select: none; -moz-user-select: none; -khtml-user-select: none; -webkit-user-select: none; -o-user-select: none;">
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
                        <input type="text" name="cpfexibe" id="cpfexibe" required="true">
                        <label>CPF</label>  
                    </div>
                    <input type="hidden" name="cpf" minlength="15" id="cpf" required="true">
                    <div class="user-box">
                        <input type="password" name="senha" required="true">
                        <label>Senha</label>
                    </div>
                    <div class="row"><br></div>
                    <div class="row">
                        <div class="col-sm">
                            <button type="submit" class="my-btn">CADASTRAR</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="back">
            <video autoplay muted loop class="fundo">
                <source src="../styles/fundo/bg3.mp4" type="video/mp4">
              </video>              
        </div>
    </body>
</html>