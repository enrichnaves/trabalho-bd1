<?php
$servidor = "localhost";
$porta = 5432;
$bancoDeDados = "trabalho";
$usuario = "postgres";
$senha = "admin";
$conexao = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
?>