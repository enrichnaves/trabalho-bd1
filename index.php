<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <title>Document</title>
    <style>
        table, th, td {
        border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Implementação do CRUD via interface, de pelo menos 3 tabelas</h1>
    <div class="crud">
        <h3>Tabela Convenio</h3>
        <div class="crud-in">
            <div class="crud-in-form">
                <p>Inserir na tabela convenio</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-conv-cad" required></p>
                    <p>Telefone
                    <input type="number" max="99999999999" placeholder="Telefone" name="tel-conv-cad" required></p>
                    <button type="submit">Inserir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Mudar o telefone de um convenio</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-conv-up" required></p>
                    <p>Novo Telefone
                    <input type="number" max="99999999999" placeholder="Telefone" name="tel-conv-up" required></p>
                    <button type="submit">Atualizar</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Excluir um convenio</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-conv-del" required></p>
                    <button type="submit">Excluir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Consultar um convenio</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-conv-sel" required></p>
                    <button type="submit">Consultar</button>
                </form>
            </div>
        </div>
        <h3>Tabela Medico</h3>
        <div class="crud-in">
            <div class="crud-in-form">
                <p>Inserir na tabela medico</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-med-cad" required></p>
                    <p>CRM
                    <input type="text" maxlength="11" placeholder="CRM" name="crm-med-cad" required></p>
                    <p>Especialidade
                    <input type="text" maxlength="30" placeholder="Especialidade" name="esp-med-cad" required></p>
                    <button type="submit">Inserir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Mudar a especialidade de um medico</p>
                <form method="POST" action="script.php">
                    <p>CRM
                    <input type="text" maxlength="30" placeholder="CRM" name="crm-med-up" required></p>
                    <p>Nova Especialidade
                    <input type="text" maxlength="30" placeholder="Especialidade" name="esp-med-up" required></p>
                    <button type="submit">Atualizar</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Excluir um medico</p>
                <form method="POST" action="script.php">
                    <p>CRM
                    <input type="text" maxlength="30" placeholder="CRM" name="crm-med-del" required></p>
                    <button type="submit">Excluir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Consultar um medico</p>
                <form method="POST" action="script.php">
                    <p>CRM
                    <input type="text" maxlength="11" placeholder="CRM" name="crm-med-sel" required></p>
                    <button type="submit">Consultar</button>
                </form>
            </div>
        </div>
        <h3>Tabela Paciente</h3>
        <div class="crud-in">
            <div class="crud-in-form">
                <p>Inserir na tabela paciente</p>
                <form method="POST" action="script.php">
                    <p>Nome
                    <input type="text" maxlength="30" placeholder="Nome" name="nome-pac-cad" required></p>
                    <p>CPF
                    <input type="text" maxlength="11" placeholder="CPF" name="cpf-pac-cad" required></p>
                    <p>Telefone
                    <input type="text" maxlength="11" placeholder="Telefone" name="tel-pac-cad" required></p>
                    <p>Nome do convenio
                    <input type="text" maxlength="30" placeholder="Nome do convenio" name="conv-pac-cad" required></p>
                    <button type="submit">Inserir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Mudar o telefone de um paciente</p>
                <form method="POST" action="script.php">
                    <p>CPF
                    <input type="text" maxlength="11" placeholder="CPF" name="cpf-pac-up" required></p>
                    <p>Novo Telefone
                    <input type="text" maxlength="11" placeholder="Telefone" name="tel-pac-up" required></p>
                    <button type="submit">Atualizar</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Excluir um paciente</p>
                <form method="POST" action="script.php">
                    <p>CPF
                    <input type="text" maxlength="11" placeholder="CPF" name="cpf-pac-del" required></p>
                    <button type="submit">Excluir</button>
                </form>
            </div>
            <div class="crud-in-form">
                <p>Consultar um paciente</p>
                <form method="POST" action="script.php">
                    <p>CPF
                    <input type="text" maxlength="11" placeholder="CPF" name="cpf-pac-sel" required></p>
                    <button type="submit">Consultar</button>
                </form>
            </div>
        </div>
    </div>
    <h1>Criação de 3 Visões ( com pelo menos 3 tabelas na consulta) -> seu resultado deve ser visualizado pela interface.</h1>
    <div class="views">
        <div class="table">
        <h3>View das cirugias (Tabelas: Pacientes, Medicos, Cirurgias)</h3>
            <?php
                include "./bd.php";
               if(!$conexao) {
                   die("Não foi possível se conectar ao banco de dados.");
               }
                echo '<table id = "listTable">';
                $sql = "SELECT * FROM pac_cir_med;";
                $fetch = pg_exec($conexao, $sql);
                $table = "<thead><tr><td>CPF PACIENTE</td><td>CRM MEDICO</td><td>PROCEDIMENTO</td></tr></thead><tbody>";
                while ($row = pg_fetch_row($fetch))
                {
                    $table = $table . "<tr>";
                    foreach ($row as $value){
                        
                    $table = $table .'<td>'. $value . '</td>';
                    }
                    $table = $table . "</tr>";
                    
                }
                $table = $table . "</body></table>";
                echo $table;
            ?>
        </div>
        <div class="table">
        <h3>View dos Exames (Tabelas: Pacientes, Medicos, Exame)</h3>
        <?php
                echo '<table id = "listTable">';
                $sql = "SELECT * FROM pac_exa_med;";
                $fetch = pg_exec($conexao, $sql);
                $table = "<thead><tr><td>CPF PACIENTE</td><td>CRM MEDICO</td><td>EXAME</td></tr></thead><tbody>";
                while ($row = pg_fetch_row($fetch))
                {
                    $table = $table . "<tr>";
                    foreach ($row as $value){
                        
                    $table = $table .'<td>'. $value . '</td>';
                    }
                    $table = $table . "</tr>";
                    
                }
                $table = $table . "</body></table>";
                echo $table;
            ?>
        </div>
        <div class="table">
        <h3>View das Consultas (Tabelas: Pacientes, Medicos, Consulta)</h3>
        <?php
                echo "<table id =  'listTable'>";
                $sql = "SELECT * FROM pac_cons_med;";
                $fetch = pg_exec($conexao, $sql);
                $table = "<thead><tr><td>CPF PACIENTE</td><td>CRM MEDICO</td><td>DATA E HORA DA CUNSULTA</td></tr></thead><tbody>";
                while ($row = pg_fetch_row($fetch))
                {
                    foreach ($row as $value){
                    $table = $table .'<td>'. $value . '</td>';
                    }
                    $table = $table . "</tr>";
                }
                $table = $table . "</body></table>";
                echo $table;
            ?>
        </div>
    </div>
</body>
</html>