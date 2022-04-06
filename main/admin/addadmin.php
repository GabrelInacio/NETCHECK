<?php 
        include("menu-admin.php"); 
        include "../../cad/config.php";
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
                <form action="salvaradmin.php" method="POST">
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
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>