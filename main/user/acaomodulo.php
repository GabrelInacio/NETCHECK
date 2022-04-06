<?php 
        include("menu-user.php"); 
        include "../../cad/config.php";
        $tipo = $_SESSION["id_plano"];
        if(!isset($_GET["idmod"])){
            $id_mod = "";
        }else{
            $id_mod = $_GET["idmod"];
            $buscamod = "SELECT * FROM modulo WHERE id = $id_mod";
            $pesquisa = mysqli_query($conexao, $buscamod);
            $infomod = mysqli_fetch_array($pesquisa);
            $nome_modulo = $infomod["nome_modulo"];
            $vel_up_mod = $infomod["vel_up"];
            $vel_down_mod = $infomod["vel_down"];
            $intervalo = $infomod["intervalo"];
        }
        
?>
        <script>
            $(document).ready(function(){
                var idmod = "<?php echo $id_mod; ?>";
                var tipo = <?php echo $tipo; ?>;
                if (idmod == ""){
                    $("input[name=nome_modulo]").attr("value", "");
                    $("input[name=vel_down]").attr("value", "");
                    $("input[name=vel_up]").attr("value", "");
                    switch (tipo){
                        case "1":
                            $("input[name=intervalo]").attr("min", "30");
                            $("input[name=intervalo]").val("30");
                            break;
                        case 1:
                            $("input[name=intervalo]").attr("min", "30");
                            $("input[name=intervalo]").val( "30");
                            break;
                        case 2:
                            $("input[name=intervalo]").attr("min", "15");
                            $("input[name=intervalo]").val("15");
                            break;
                        case "2":
                            $("input[name=intervalo]").attr("min", "15");
                            $("input[name=intervalo]").val("15");
                            break;
                        case "3":
                            $("input[name=intervalo]").attr("min", "6");
                            $("input[name=intervalo]").val("6");
                            break;
                        case 3:
                            $("input[name=intervalo]").attr("min", "6");
                            $("input[name=intervalo]").val("6");
                            break;
                    }
                }else{
                    $("input[name=nome_modulo]").attr("value", "<?php if(isset($nome_modulo)){echo $nome_modulo; }else{ echo " "; }?>");
                    $("input[name=vel_down]").attr("value", "<?php if(isset($vel_down_mod)){echo $vel_down_mod; }else{ echo " "; }?>");
                    $("input[name=vel_up]").attr("value", "<?php if(isset($vel_up_mod)){echo $vel_up_mod; }else{ echo " "; }?>");
                    $("input[name=intervalo]").attr("value", "<?php if(isset($intervalo)){echo $intervalo; }else{ echo " "; }?>");
                    switch (tipo){
                        case "1":
                            $("input[name=intervalo]").attr("min", "30");
                            $("input[name=intervalo]").val("30");
                            break;
                        case 1:
                            $("input[name=intervalo]").attr("min", "30");
                            $("input[name=intervalo]").val( "30");
                            break;
                        case 2:
                            $("input[name=intervalo]").attr("min", "15");
                            $("input[name=intervalo]").val("15");
                            break;
                        case "2":
                            $("input[name=intervalo]").attr("min", "15");
                            $("input[name=intervalo]").val("15");
                            break;
                        case "3":
                            $("input[name=intervalo]").attr("min", "6");
                            $("input[name=intervalo]").val("6");
                            break;
                        case 3:
                            $("input[name=intervalo]").attr("min", "6");
                            $("input[name=intervalo]").val("6");
                            break;
                    }
                }

                $("#creation").click(function(){
                    var textToSave =  `<?php echo "
import socket
import speedtest
from datetime import datetime
import sched, time
from getmac import get_mac_address
import netifaces
from requests import get
import hashlib
import os

def screen_clear():
    if os.name == 'posix':
        _ = os.system('clear')
    else:
        _ = os.system('cls')
    print('Realizando Medições...')
intervalo = (1)

def encrypt_string(hash_string):
    sha_signature = \
        hashlib.sha256(hash_string.encode()).hexdigest()
    return sha_signature

def get_machine_default_gateway_ip():
    gws = netifaces.gateways()
    gateway = gws['default'][netifaces.AF_INET][0]

    return gateway


def medicao():
    id_mod = ".$id_mod."
    data_medicao = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    screen_clear()
    try:
        s = speedtest.Speedtest()
        vel_up = round(s.upload() * (10 ** -6), 2)
        vel_down = round(s.download() * (10 ** -6), 2)

    except:
        vel_up = 0
        vel_down = 0

    ip_host = get_machine_default_gateway_ip()
    mac = get_mac_address(ip=ip_host)
    ip_externo = get('https://api.ipify.org').text
    endereco = 'http://ip-api.com/json/'+str(ip_externo)
    resultado_request = get(endereco)
    json_longo = resultado_request.json()
    operadora = json_longo['isp']
    dados = str(vel_up) + ',' + str(vel_down) + ',' + str(data_medicao) + ',' + operadora + ',' + str(id_mod) + ',' + str(encrypt_string(
        mac))+','
    return dados


def comunicacao():
    valores = medicao()
    ClientSocket = socket.socket()
    host = '192.168.15.252'
    port = 1235

    print('Estabelecendo conexão')
    try:
        ClientSocket.connect((host, port))
    except socket.error as e:
        print(str(e))

    while True:
        envio = str(valores)
        ClientSocket.send(envio.encode('utf-8'))
        resposta = ClientSocket.recv(1024)
        resposta = resposta.decode('utf-8')
        global intervalo
        intervalo = float(resposta)*60
        print('Medição realizada com sucesso!')
        return False
    ClientSocket.shutdown(SHUT_RDWR)
    ClientSocket.close()


s = sched.scheduler(time.time, time.sleep)
def repita(sc):
    try:
        comunicacao()
        global intervalo
        s.enter(intervalo, 1, repita, (sc,))
    except:
        print('Falha na medição!')
        comunicacao()
        s.enter(intervalo, 1, repita, (sc,))


s.enter(intervalo, 1, repita, (s,))
s.run()
                    "; ?> `;
                    var hiddenElement = document.createElement('a');
                    hiddenElement.href = 'data:attachment/text,' + encodeURI(textToSave);
                    hiddenElement.target = '_blank';
                    hiddenElement.download = 'medmod.py';
                    hiddenElement.click();
                });

                $("#deleta").click(function(){
                    Swal.fire({
                    title: 'Remover módulo?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não, cancelar',
                    confirmButtonText: 'Sim, remover!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('deletamodulo.php?idmod=<?php echo $id_mod; ?>');
                    }
                    });
                });

                $("#reinicia").click(function(){
                    Swal.fire({
                    title: 'Reiniciar validação do módulo?',
                    text: "Esta ação não poderá ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Não, cancelar',
                    confirmButtonText: 'Sim, reverter!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.replace('reiniciamodulo.php?idmod=<?php echo $id_mod; ?>');
                    }
                    });
                });

                $("#intervalo").focusout(function(){
                    var intervalo = $("input[name=intervalo]").val();
                    switch (tipo){
                        case "1":
                            if(intervalo < 30){
                                $("input[name=intervalo]").val("30");
                            }
                            break;
                        case 1:
                            if(intervalo < 30){
                                $("input[name=intervalo]").val("30");
                            }
                            break;
                        case 2:
                            if(intervalo < 15){
                                $("input[name=intervalo]").val("15");
                            }
                            break;
                        case "2":
                            if(intervalo < 15){
                                $("input[name=intervalo]").val("15");
                            }
                            break;
                        case "3":
                            if(intervalo < 6){
                                $("input[name=intervalo]").val("6");
                            }
                            break;
                        case 3:
                            if(intervalo < 6){
                                $("input[name=intervalo]").val("6");
                            }
                            break;
                    }
                });
                $("#vel-up").focusout(function(){
                    var vel = $("#vel-up").val();
                    if (vel<1){
                        var vel = $("#vel-up").val("1");
                    }

                });
                $("#vel-down").focusout(function(){
                    var vel = $("#vel-down").val();
                    if (vel<1){
                        var vel = $("#vel-down").val("1");
                    }

                });
            });
        </script>
        <div class="conteudo">
            <div class="container">
                <div class="row">
                    <h1 style="font-weight: bolder">CONFIGURAÇÕES DO MÓDULO DE MEDIÇÃO - <?php if (isset($nome_modulo)){ echo $nome_modulo; }else{ echo "NOVO MÓDULO"; } ?> </h1>
                    <div class="col-xs-12"><hr></div>
                </div>
                <div class="row">
                    <div class="col-xs-12" style="height:2rem;"><br></div>
                </div>
                <form action="salvarmodulo.php" method="POST">
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="hidden" name="idmod" value="<?php echo $id_mod; ?>">
                                <input type="text" name="nome_modulo" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Nome do Módulo <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                             <div class="user-box">
                                <input type="number" name="intervalo" id="intervalo" required="true" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Intervalo de Medições em minutos:<span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="number" name="vel_down" id="vel-down" required="true"  min="1" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Velocidade de Download Contratada (Em Mbps): <span style="color: red; "> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-3">
                        <div class="col-6">
                            <div class="user-box">
                                <input type="number" name="vel_up" id="vel-up" required="true" min="1" style="margin-left:0;">
                                <label style="margin-left:0; left:0">Velocidade de Upload Contratada (Em Mbps): <span style="color: red;"> *</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row row-cols-auto">
                        <div class="col">
                            <button class="botao" type="submit" style="margin-top:0;">SALVAR</a>
                        </div>
                        <?php if($id_mod != ""){ ?>
                        <div class="col" style="margin-top:2px;">
                            <a id="creation" class="botao" style="padding-bottom: .5rem">GERAR ARQUIVOS DE INSTALAÇÃO</a>
                        </div>
                        
                        <div class="col" style="margin-top:2px;">
                            <a id="reinicia" class="botao" style="padding-bottom: .5rem">REINICIAR VALIDAÇÃO DO MÓDULO</a>
                        </div>
                        <div class="col" style="margin-top:2px;">
                            <a id="deleta" class="botao" style="padding-bottom: .5rem"><i class="fas fa-trash"></i> REMOVER MÓDULO</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </form>
            
        </div>
        

    </body>
</html>