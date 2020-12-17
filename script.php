<?php

    define('ERROBD', "<script>
    if(confirm('Erro no banco!')){
        window.location='./index.php';
    }
    </script>");
    define('CADSUC', "<script>
    if(confirm('Cadastrado com sucesso!')){
        window.location='./index.php';
    }
    </script>");

    define('CADERR', "<script>
    if(confirm('Cadastrado com sucesso!')){
        window.location='./index.php';
    }
    </script>");

    define('ALTSUC', "<script>
    if(confirm('Alterado!')){
        window.location='./index.php';
    }
    </script>");

    define('EXCSUCSS', "<script>
    if(confirm('Excluido!')){
        window.location='./index.php';
    }
    </script>");

    define('NAOENC', "<script>
    if(confirm('Excluido!')){
        window.location='./index.php';
    }
    </script>");
    include "./bd.php";
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
                
                echo ALTSUC;
                
            }
            else{
                echo NAOENC;
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
                        echo EXCSUCSS;
                    }
                }else
                {
                    echo NAOENC;
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
                                    window.location='./index.php';
                                }
                            </script>";
                    }
                }else
                {
                    echo NAOENC;
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
                echo CADSUC;
            }else
            {
                echo CADERR;
            }
        }else
        {
            echo ERROBD;
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
                
                echo ALTSUC;
            }
            else{
                echo NAOENC;
            }
        }
        else{
            echo ERROBD;
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
                        echo EXCSUCSS;
                    }
                }else
                {
                    echo NAOENC;
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
                                    window.location='./index.php';
                                }
                            </script>";
                    }
                }else
                {
                    echo NAOENC;
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
                echo CADSUC;
            }else
            {
                echo CADERR;
            }
        }else
        {
            echo ERROBD;
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
                
                echo ALTSUC;
                
            }
            else{
                echo NAOENC;
            }
        }
        else{
            echo ERROBD;
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
                        echo EXCSUCSS;
                    }
                }else
                {
                    echo NAOENC;
                }
            }else
            {
                echo ERROBD;
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
                                    window.location='./index.php';
                                }
                            </script>";
                    }
                }else
                {
                    echo NAOENC;
                            }
            }else
            {
                echo ERROBD;
            }
            
    }
    

?>