-- Geração de Modelo físico
-- Sql ANSI 2003 - brModelo.

CREATE TABLE Ambulancias (
Placa varchar(7) PRIMARY KEY,
Disponivel BIT DEFAULT '1',
Capacidade INTEGER CHECK (Capacidade>=1),
num_chamados integer CHECK (num_chamados>=0)
);
CREATE TABLE Pacientes (
Nome varchar(30),
Telefone varchar(14),
CPF varchar(11) PRIMARY KEY,
Nome_convenio varchar(30) DEFAULT 'SUS',
num_consultas integer CHECK (num_consultas>=0) DEFAULT 0,
dat timestamp DEFAULT current_timestamp
);

CREATE TABLE Medicos (
CRM varchar(11) PRIMARY KEY,
Nome varchar(30),
Especialidade varchar(30),
num_chamados integer CHECK (num_chamados>=0) DEFAULT 0,
num_consultas integer CHECK (num_consultas>=0) DEFAULT 0
);

CREATE TABLE Quartos (
ID_quarto varchar(2) PRIMARY KEY,
Disponivel BIT DEFAULT '1',
Capacidade INTEGER CHECK (Capacidade>=1),
num_uso integer CHECK (num_uso>=0) DEFAULT 0
);

CREATE TABLE Motoristas (
CNH varchar(11) PRIMARY KEY,
Nome varchar(30),
num_chamados integer CHECK (num_chamados>=0) DEFAULT 0,
disponivel BIT DEFAULT '0'
);

CREATE TABLE Convenio (
Nome_convenio varchar(30) PRIMARY KEY,
Telefone varchar(14)
);

CREATE TABLE Exame (
dat timestamp,
Tipo varchar(30),
id_exame serial PRIMARY KEY,
CPF varchar(11),
CRM varchar(11),
ID_quarto varchar(2),
FOREIGN KEY(CPF) REFERENCES Pacientes (CPF),
FOREIGN KEY(CRM) REFERENCES Medicos(CRM),
FOREIGN KEY(ID_quarto) REFERENCES Quartos (ID_quarto)
);

CREATE TABLE Consulta (
dat timestamp,
data_retorno timestamp,
id_consulta serial PRIMARY KEY,
CPF varchar(11),
CRM varchar(11),
ID_quarto varchar(2),
FOREIGN KEY(CPF) REFERENCES Pacientes (CPF),
FOREIGN KEY(CRM) REFERENCES Medicos(CRM),
FOREIGN KEY(ID_quarto) REFERENCES Quartos (ID_quarto)
);
CREATE TABLE Cirurgia (
dat timestamp,
Procedimento varchar(30),
id_cirurgia serial PRIMARY KEY,
CPF varchar(11),
CRM varchar(11),
ID_quarto varchar(2),
FOREIGN KEY(CPF) REFERENCES Pacientes (CPF),
FOREIGN KEY(CRM) REFERENCES Medicos(CRM),
FOREIGN KEY(ID_quarto) REFERENCES Quartos (ID_quarto)
);

CREATE TABLE Chamado (
dat timestamp,
endereco varchar(30),
id_chamado serial PRIMARY KEY,
CNH varchar(11),
Placa varchar(7),
CPF varchar(11),
CRM varchar(11),
FOREIGN KEY(CPF) REFERENCES Pacientes (CPF),
FOREIGN KEY(CRM) REFERENCES Medicos(CRM),
FOREIGN KEY(CNH) REFERENCES Motoristas(CNH),
FOREIGN KEY(Placa) REFERENCES Ambulancias(Placa)
);

ALTER TABLE Pacientes ADD FOREIGN KEY(Nome_convenio) REFERENCES Convenio (Nome_convenio);

INSERT INTO convenio (nome_convenio, telefone) VALUES ('SUS', '0800-0000');
INSERT INTO public.medicos(
	crm, nome, especialidade)
	VALUES ('1', 'doutor', 'clinico geral');
INSERT INTO quartos(id_quarto, capacidade, disponivel) VALUES ('1', 1,'1');
---------------------------------------------------
CREATE VIEW pac_cons_med AS
SELECT pacientes.cpf, medicos.crm, consulta.dat
FROM pacientes, medicos, consulta
WHERE pacientes.cpf = consulta.cpf
AND medicos.crm = consulta.crm;

CREATE VIEW pac_exa_med AS
SELECT pacientes.cpf, medicos.crm, exame.tipo
FROM pacientes, medicos, exame
WHERE pacientes.cpf = exame.cpf
AND medicos.crm = exame.crm;

CREATE VIEW pac_cir_med AS
SELECT pacientes.cpf, medicos.crm, cirurgia.procedimento
FROM pacientes, medicos, cirurgia
WHERE pacientes.cpf = cirurgia.cpf
AND medicos.crm = cirurgia.crm;

---------------------------------------------------
--FUNÇÃO 1
CREATE or replace FUNCTION cal_dat_retorno() 
RETURNS date AS $$
BEGIN
    return date_part('day', CURRENT_DATE)+10||'-'||date_part('month',CURRENT_DATE)||'-'||date_part('year',CURRENT_DATE);
END;
$$ language plpgsql;
---------
--FUNÇÃO 2
CREATE or replace FUNCTION chamado(varchar, varchar, varchar) 
RETURNS void AS $$
BEGIN
		UPDATE motoristas
		SET num_chamados = num_chamados + 1
		WHERE cnh=$1;
		UPDATE motoristas
		SET disponivel = '0'
		WHERE cnh=$1;
		UPDATE medicos
		SET num_chamados = num_chamados + 1
		WHERE crm=$2;
		UPDATE ambulancias
		SET num_chamados = num_chamados + 1
		WHERE placa=$3;
		UPDATE ambulancias
		SET disponivel = '0'
		WHERE placa=$3;
END;
$$ language plpgsql;
--------
--FUNÇÃO 3 
CREATE OR REPLACE FUNCTION add_cons(ncrm varchar,ncpf varchar,nid_quarto varchar) 
RETURNS void AS $$
BEGIN
		UPDATE medicos
		SET num_consultas = num_consultas + 1
		WHERE crm=ncrm;
		UPDATE quartos
		SET num_uso = num_uso + 1
		WHERE id_quarto=nid_quarto;
		UPDATE pacientes
		SET num_consultas = num_consultas + 1
		WHERE cpf=ncpf;
END;
$$ language plpgsql;
---------------------------------------------------
--TRIGGER 1
CREATE OR REPLACE FUNCTION add_consulta()
RETURNS trigger AS $$
DECLARE
    data_retorno date;
	cpf_pac varchar;
BEGIN
    data_retorno := cal_dat_retorno();
	SELECT cpf
	INTO cpf_pac
	FROM pacientes
	WHERE dat <=current_timestamp
	ORDER BY dat DESC limit 1;
    INSERT INTO consulta(
    dat, data_retorno, cpf, crm, id_quarto)
    VALUES (CURRENT_DATE, data_retorno, cpf_pac, '1', '1');
	return new;
END;
$$ language plpgsql;

CREATE TRIGGER consulta_padrao after                 
INSERT
ON pacientes FOR STATEMENT
EXECUTE PROCEDURE add_consulta();

--TRIGGER 2
CREATE OR REPLACE FUNCTION chamado_trigger()
RETURNS trigger AS $$
BEGIN
	PERFORM chamado(new.cnh, new.crm, new.placa);
	RETURN NEW;
END;
$$ language plpgsql;

CREATE TRIGGER chamado after                 
INSERT
ON chamado FOR EACH ROW
EXECUTE PROCEDURE chamado_trigger();

--TRIGGER 3

CREATE OR REPLACE FUNCTION consulta()
RETURNS trigger AS $$
BEGIN
	PERFORM add_cons(new.crm, new.cpf, new.id_quarto);
	RETURN NEW;
END;
$$ language plpgsql;

CREATE TRIGGER consulta before                 
INSERT
ON consulta FOR EACH ROW
EXECUTE PROCEDURE consulta();
---------------------------------------------------
--CRIAÇÃO 3 USUSARIOS
CREATE USER adm SUPERUSER INHERIT CREATEDB CREATEROLE;
ALTER USER adm PASSWORD 'senha';

CREATE USER semperm WITH PASSWORD 'senha';

CREATE USER sel;
ALTER USER sel PASSWORD 'senha';
GRANT SELECT ON ALL TABLES IN SCHEMA public TO sel;

INSERT INTO pacientes (nome, telefone, cpf)
VALUES ('teste', '123', '123');

INSERT INTO motoristas (cnh, nome)
values('123', 'teste');

INSERT INTO public.ambulancias(
	placa, capacidade)
	VALUES ('123', 3);

INSERT INTO public.chamado(
	dat, endereco, cnh, placa, cpf, crm)
	VALUES (CURRENT_DATE, 'teste endereco', '123', '123', '123', '1');

select * from medicos
select * from pacientes
select * from consulta
select * from chamado
select * from quartos
select * from convenio
delete from pacientes
delete from chamado
delete from consulta