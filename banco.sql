CREATE DATABASE netbaseofdata;
USE netbaseofdata;
CREATE TABLE plano(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_plano VARCHAR(80),
    mensalidade FLOAT
);

CREATE TABLE usuario(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150),
    login VARCHAR(50),
    senha VARCHAR(100),
    tipo_usuario int,
    email VARCHAR(50),
    id_plano int,
    FOREIGN KEY (id_plano) REFERENCES plano(id),
    ativo int,
    created DATETIME;
    cpf varchar (11)
);

CREATE TABLE fatura(
    id INT PRIMARY KEY AUTO_INCREMENT,
    data_vencimento DATETIME,
    situacao int,
    id_usuario int,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

CREATE TABLE modulo(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_modulo VARCHAR(80),
    situacao int,
    vel_up FLOAT,
    vel_down FLOAT,
    operadora VARCHAR (100),
    intervalo int,
    id_usuario int,
    hash_modulo VARCHAR(100),
    FOREIGN KEY (id_usuario) REFERENCES usuario(id),
    ativo int
);

CREATE TABLE medicao(
    id INT PRIMARY KEY AUTO_INCREMENT,
    vel_up FLOAT,
    vel_down FLOAT,
    operadora VARCHAR (100),
    data_medicao DATETIME,
    id_modulo int,
    FOREIGN KEY (id_modulo) REFERENCES modulo(id),
    ativo int
);

CREATE TABLE pagamento(
    id INT PRIMARY KEY AUTO_INCREMENT,
    num_cartao varchar(20),
    cpf_titular varchar(20),
    nome_titular varchar(30),
    vencimento varchar(10),
    nome_cartao varchar(40),
    id_usuario int,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id)
);

INSERT INTO 'plano'('id', 'nome_plano', 'mensalidade') VALUES 
    (0,'GRATUITO', 0),
    (0,'ARIA', 35.00),
    (0,'REQUIEM', 50.00);

ALTER DATABASE netbaseofdata CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;