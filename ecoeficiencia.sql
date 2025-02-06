create database ecoeficiencia;

use ecoeficiencia;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE materiais (
    id INT PRIMARY KEY AUTO_INCREMENT,
    data DATE NOT NULL,
    categoria VARCHAR(50) NOT NULL,
    peso DECIMAL(10,2) NOT NULL
);

select * from materiais;
select * from usuarios;

insert into usuarios(nome,senha,email) values ('nick', '123','nick'); 
