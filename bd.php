<?php
if (!isset($_SESSION))
{
    session_start();
}
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["user_login"]) && isset($_POST["password_login"])) //LOGIN USUARIO
{
    $_SESSION['usuario'] = $_POST["user_login"];
    $_SESSION['senha'] = $_POST["password_login"];
}
    $usuario = $_SESSION['usuario'];
    $senha = $_SESSION['senha'];
    $servidor = "localhost";
    $porta = 5432;
    $bancoDeDados = "trabalho";
    $conexao = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
    if($conexao)
    {
        echo '';
    }
    else
    {
       echo '0';
    }
?>