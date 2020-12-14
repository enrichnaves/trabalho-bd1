<?php
     if (!isset($_SESSION))
     {
         session_start();
     }
     
     $servidor = "localhost";
     $porta = 5432;
     $bancoDeDados = "trabalho";
     $usuario = "postgres";
     $senha = "admin";

    $conexao = pg_connect("host=$servidor port=$porta dbname=$bancoDeDados user=$usuario password=$senha");
    if(!$conexao) {
        die("Não foi possível se conectar ao banco de dados.");
    }
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-conv-cad"])) //INSERIR CONVENIO
    {
        $nome = $_POST["nome-conv-cad"];
        $tel = $_POST["tel-conv-cad"];
        
        if ($conexao){
            $sql="INSERT INTO convenio(
            nome_convenio, telefone)
            VALUES ('$nome', '$tel');";
            $result= pg_exec($conexao, $sql);
            if ($result)
            {
                echo "<script>
                    if(confirm('Cadastrado com sucesso!')){
                        window.location='./index.html';
                    }
                </script>";
            }else
            {
                echo "<script>
                if(confirm('Ocorreu algum erro no cadastro!')){
                    window.location='./index.html';
                }
                </script>";
            }
        }else
        {
            echo "<script>
                    if(confirm('Erro no banco!')){
                        window.location='./index.html';
                    }
                </script>";
        }
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-conv-up"]))//ALTERAR TELEFONE CONV
    {
        $nome = $_POST["nome-conv-up"];
        $tel = $_POST["tel-conv-up"];
        if ($conexao){
            $sql="SELECT * FROM convenio
            WHERE nome_convenio = '$nome';";
            $result= pg_fetch_row(pg_exec($conexao, $sql));
            if ($result)
            {
                $sql="UPDATE convenio
                SET telefone = '$tel'
                WHERE nome_convenio = '$nome'
                ;";
                $result= pg_exec($conexao, $sql);
                
                echo "<script>
                if(confirm('Alterado com sucesso!')){
                    window.location='./index.html';
                }
                </script>";
                
            }
            else{
                echo "<script>
                    if(confirm('Convenio não encontrado!')){
                        window.location='./index.html';
                    }
                    </script>";
            }
        }
        else{
            echo "<script>
                if(confirm('Erro no BD!')){
                    window.location='./index.html';
                }
            </script>";
            }
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-conv-del"]))//ALTERAR TELEFONE CONV
    {
        $nome = $_POST["nome-conv-del"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM convenio WHERE nome_convenio = '$nome';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "DELETE FROM convenio WHERE nome_convenio = '$nome';";
                    $result = pg_exec($conexao, $sql);
                    if ($result){
                        echo "<script>
                                if(confirm('Convenio excluido!')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('Convenio não encontrado!')){
                                window.location='./index.html';
                            }
                        </script>";
                            }
            }else
            {
                echo "<script>
                        if(confirm('Erro no BD!')){
                            window.location='./index.html';
                        }
                    </script>";
            }
            
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-conv-sel"]))//ALTERAR TELEFONE CONV
    {
        $nome = $_POST["nome-conv-sel"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM convenio WHERE nome_convenio = '$nome';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "SELECT * FROM convenio WHERE nome_convenio = '$nome';";
                    $result = pg_fetch_row(pg_exec($conexao, $sql));
                    if ($result){
                        echo "<script>
                                if(confirm('Convenio: \\nNome: $result[0] \\nTelefone: $result[1]')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('Convenio não encontrado!')){
                                window.location='./index.html';
                            }
                        </script>";
                            }
            }else
            {
                echo "<script>
                        if(confirm('Erro no BD!')){
                            window.location='./index.html';
                        }
                    </script>";
            }
            
    }

?>