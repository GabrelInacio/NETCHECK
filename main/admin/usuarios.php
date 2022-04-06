<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";
        if (isset($_GET['numpag'])) {
            $numpag = $_GET['numpag'];
        } else {
            $numpag = 1;
        }
        $nome = "";
        if(isset($_GET["nome"])){
            $nome = $_GET["nome"];
        }
?>

        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">USUÁRIOS</h1>
                    <div class="col-xs-12"><hr></div>
                </div>

                <div style="width:95%; margin: auto">
                    <div class="row justify-content-md-center" style="padding-top:2rem;">
                        <form action="usuarios.php" method="get">
                        <div class="col-lg-2-auto">
                            <div class="user-box">
                                <input type="text" name="nome">
                                <label style="margin-left:6rem; left:6rem">Nome para consulta </label>
                            </div>
                        </div>                  
                    </div>
                    <div class="row justify-content-md-center">
                        <div class="col-md-auto" style="margin: auto">
                            <input type="submit" class="botao" value="CONSULTAR" style="margin: auto">
                        </div>
                        </form>
                    </div>
                    <div class="row" style="padding-top:2rem;">
                        <div class="row text-center">
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b>Login</b></h5>
                            </div>
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b>E-Mail</b></h5>
                            </div>
                            <div class="col">
                                <h5><b>Nome</b></h5>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                                <h5><b>Tipo</b></h5>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                                <h5><b>Ações</b></h5>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <?php
                        $registros_por_pagina= 20;
                        $offset = ($numpag-1) * $registros_por_pagina;
                        
                        $num = "SELECT * FROM usuario WHERE ativo = 1 AND tipo_usuario = 1";
                        $result = mysqli_query($conexao,$num);
                        $num_linhas = mysqli_num_rows($result);
                        $num_pag = 0;
                        $sub = $num_linhas;
                        while ($sub > 0){
                            $sub = $sub - $registros_por_pagina;
                            $num_pag = $num_pag + 1;
                        }
                        
                        $sql = "SELECT * FROM usuario WHERE ativo = 1 AND tipo_usuario = 1 AND nome LIKE '%$nome%' LIMIT $offset, $registros_por_pagina";
                        $resultado = mysqli_query($conexao,$sql);
                        while($row = mysqli_fetch_array($resultado)){
                    ?>
                
                    <div class="row">
                        <div class="row text-center align-items-center">
                            <div class="col" style="border-right: 1px solid #000;">
                                <h5><b><?php echo $row["login"]; ?></b></h5>
                            </div>
                            <div class="col align-items-center" style="border-right: 1px solid #000;">
                                <h5><b><?php echo $row["email"]; ?></b></h5>
                            </div>
                            <div class="col">
                                <h5><b><?php echo $row["nome"]; ?></b></h5>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                                <?php 
                                    $plano = $row["id_plano"];
                                    switch($plano){
                                        case 1:
                                            echo '<img src="../../styles/logos/gratuito.png" style="padding-left:0; height: 3rem">';
                                            break;
                                        case 2:
                                            echo '<img src="../../styles/logos/aria.png" style="padding-left:0; height: 3rem">';
                                            break;
                                        case 3:
                                            echo '<img src="../../styles/logos/requiem.png" style="padding-left:0; height: 3rem">';
                                            break;
                                    }
                                ?>
                            </div>
                            <div class="col" style="border-left: 1px solid #000;">
                            <script>
                                $(document).ready(function(){
                                    $("#deleta<?php echo $row['id']; ?>").click(function(){
                                        Swal.fire({
                                        title: 'Remover este usuário?',
                                        text: "Esta ação não poderá ser revertida!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        cancelButtonText: 'Não, cancelar',
                                        confirmButtonText: 'Sim, remover!'
                                        }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.replace("deletausuario.php?id=<?php echo $row["id"];?>");
                                        }
                                        });
                                    });
                                });
                            </script>
                                <a id="deleta<?php echo $row['id']; ?>" style="text-decoration: none; color:#2348A6; font-size: 3rem; cursor: pointer"> <i class="fas fa-trash" ></i></a>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <?php

                        }
                    ?>
                </div>
                <div class="row">
                    <div class="col">
                        <nav aria-label="Page navigation" style="margin:auto;">
                            <ul class="pagination justify-content-center">
                                <li class="page-item"><a class="page-link" href="usuarios.php?<?php echo 'nome='.$nome.'&numpag=1'; ?>" style="color:#2348A6;"><< </a></li>
                                <li class="page-item"><a class="page-link" href="usuarios.php?<?php if($numpag == 1){  echo 'nome='.$nome.'&numpag=1'; }else{ echo 'nome='.$nome.'&numpag='.($numpag - 1); }?>" style="color:#2348A6;"><</a></li>
                                <?php for ($i=0; $i<$num_pag; $i++){
                                    ?>
                                
                                <li class="page-item"><a class="page-link" href="usuarios.php?<?php echo 'nome='.$nome.'&numpag='.($i+1); ?>" style="color:#2348A6;"><?php echo $i+1;?></a></li>
                                <?php 
                                    }
                                ?>
                                <li class="page-item"><a class="page-link" href="usuarios.php?<?php if($numpag == $num_pag){  echo 'nome='.$nome.'&numpag='.$num_pag; }else{ echo 'nome='.$nome.'&numpag='.($numpag + 1); }?>" style="color:#2348A6;">></a></li>
                                <li class="page-item"><a class="page-link" href="usuarios.php?<?php echo 'nome='.$nome.'&numpag='.$num_pag; ?>" style="color:#2348A6;"> >></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <br>
                <br>
                <br>
            </div>
            
        </div>
        

    </body>
</html>