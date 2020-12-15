<?php

    define('ERROBD', "<script>
    if(confirm('Erro no banco!')){
        window.location='./index.html';
    }
    </script>");
    define('CADSUC', "<script>
    if(confirm('Cadastrado com sucesso!')){
        window.location='./index.html';
    }
    </script>");

    define('CADERR', "<script>
    if(confirm('Cadastrado com sucesso!')){
        window.location='./index.html';
    }
    </script>");

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
                echo CADSUC;
            }else
            {
                echo CADERR;
            }
        }else
        {
            echo ERROBD;
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
            echo ERROBD;
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
                echo ERROBD;
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
                echo ERROBD;
            }
            
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-med-cad"])) //INSERIR MEDICO
    {
        $crm = $_POST["crm-med-cad"];
        $nome = $_POST["nome-med-cad"];
        $esp = $_POST["esp-med-cad"];
        
        if ($conexao){
            $sql="INSERT INTO medicos(
            crm, nome, especialidade)
            VALUES ('$crm', '$nome', '$esp');";
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
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["esp-med-up"]))//ALTERAR ESPECIALIDADE MEDICO
    {
        $crm = $_POST["crm-med-up"];
        $esp = $_POST["esp-med-up"];
        if ($conexao){
            $sql="SELECT * FROM medicos
            WHERE crm = '$crm';";
            $result= pg_fetch_row(pg_exec($conexao, $sql));
            if ($result)
            {
                $sql="UPDATE medicos
                SET especialidade = '$esp'
                WHERE crm = '$crm'
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
                    if(confirm('MEDICO não encontrado!')){
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
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["crm-med-del"]))//DELETAR MEDICO
    {
        $crm = $_POST["crm-med-del"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM medicos WHERE crm = '$crm';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "DELETE FROM medicos WHERE crm = '$crm';";
                    $result = pg_exec($conexao, $sql);
                    if ($result){
                        echo "<script>
                                if(confirm('MEDICO excluido!')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('MEDICO não encontrado!')){
                                window.location='./index.html';
                            }
                        </script>";
                            }
            }else
            {
                echo ERROBD;
            }
            
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["crm-med-sel"]))//CONSULTAR MEDICO
    {
        $crm = $_POST["crm-med-sel"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM medicos WHERE crm = '$crm';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "SELECT * FROM medicos WHERE crm = '$crm';";
                    $result = pg_fetch_row(pg_exec($conexao, $sql));
                    if ($result){
                        echo "<script>
                                if(confirm('MEDICO: \\nCrm: $result[0] \\nNome: $result[1] \\nEspecialidade: $result[2]')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('MEDICO não encontrado!')){
                                window.location='./index.html';
                            }
                        </script>";
                            }
            }else
            {
                echo ERROBD;
            }
            
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["nome-pac-cad"])) //INSERIR PACIENTE
    {
        $nome = $_POST["nome-pac-cad"];
        $cpf = $_POST["cpf-pac-cad"];
        $tel = $_POST["tel-pac-cad"];
        $nome_convenio = $_POST["conv-pac-cad"];

        if ($conexao){
            $sql="INSERT INTO pacientes(
            nome, telefone, cpf, nome_convenio)
            VALUES ('$nome', '$cpf', '$tel', '$nome_convenio');";
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
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cpf-pac-up"]))//ALTERAR TELEFONE CONV
    {
        $cpf = $_POST["cpf-pac-up"];
        $tel = $_POST["tel-pac-up"];
        if ($conexao){
            $sql="SELECT * FROM paciente
            WHERE cpf = '$cpf';";
            $result= pg_fetch_row(pg_exec($conexao, $sql));
            if ($result)
            {
                $sql="UPDATE paciente
                SET telefone = '$tel'
                WHERE cpf = '$cpf'
                ;";
                $result= pg_exec($conexao, $sql);
                
                echo "<script>
                if(confirm('PACIENTE alterado com sucesso!')){
                    window.location='./index.html';
                }
                </script>";
                
            }
            else{
                echo "<script>
                    if(confirm('PACIENTE não encontrado!')){
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
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cpf-pac-del"]))//DELETAR PACIENTE
    {
        $cpf = $_POST["cpf-pac-del"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM pacientes WHERE cpf = '$cpf';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "DELETE FROM pacientes WHERE cpf = '$cpf';";
                    $result = pg_exec($conexao, $sql);
                    if ($result){
                        echo "<script>
                                if(confirm('PACIENTE excluido!')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('PACIENTE não encontrado!')){
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
            
    }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["cpf-pac-sel"]))//CONSULTAR PACIENTES
    {
        $cpf = $_POST["cpf-pac-sel"];
        if($conexao)
            {
                $sql = "SELECT COUNT(*) FROM pacientes WHERE cpf = '$cpf';";
                $fetch = pg_fetch_row(pg_exec($conexao, $sql));
                if ($fetch[0]==1)
                {
                    $sql = "SELECT * FROM pacientes WHERE cpf = '$cpf';";
                    $result = pg_fetch_row(pg_exec($conexao, $sql));
                    if ($result){
                        echo "<script>
                                if(confirm('PACIENTE: \\nNome: $result[0] \\nCpf: $result[1] \\nTelefone: $result[2] \\nNome do PACIENTE: $result[3]')){
                                    window.location='./index.html';
                                }
                            </script>";
                    }
                }else
                {
                    echo "<script>
                            if(confirm('PACIENTE não encontrado!')){
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