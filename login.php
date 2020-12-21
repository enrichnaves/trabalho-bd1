
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="./jquery-3.4.1.js"></script>
    <title>Login</title>
</head>

<body style="text-align: center; margin-top: 20%;">
        <h1>Login</h1>
        <form id = "login_form">
            <div class="login-box">
                <div class="textbox">
                    <input type="text" placeholder="user" name ="user_login"  value="" required/>
                </div>
                <div class="textbox">
                    <input type="password" placeholder="password" name ="password_login" value="" required/>
                </div>
                <button type="button" id="botao_enviar" class="btn mt-3">Entrar</button>
            </div>
        </form>
        <p id="mensagem"></p>
   
</body>
<script type="text/javascript">   
        $(function(){
            $("#botao_enviar").click(function(){
                $.ajax({
                    method:"POST",
                    url:"./bd.php",
                    data: $("#login_form").serialize(),
                    success: function(retorno){
                        if(retorno=='')
                        {
                            if(window.location.href=="http://localhost/bd/login.php")
                                {
                                    window.location='./index.php';
                                }
                        }else
                        {
                            document.getElementById("mensagem").innerHTML = "Login não realizado";
                        }
                    },
                    error: function(retornoErro){
                        document.getElementById("mensagem").innerHTML = "Erro no PHP";
                    }
                });
            });
        });
</script>
</html>

