// Código do banco de dados

/* CREATE DATABASE Umidade;

USE Umidade;

CREATE TABLE Usuario ( id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(100) NOT NULL, emailCorp VARCHAR(150) NOT NULL UNIQUE, senha VARCHAR(255) NOT NULL, funcao ENUM('Funcionario', 'Gerente') NOT NULL );

CREATE TABLE Dispositivo ( id INT AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(100) NOT NULL, tipo VARCHAR(100) NOT NULL, localizacao VARCHAR(150) NOT NULL, status ENUM('Ativo', 'Inativo') NOT NULL );

CREATE TABLE Usuario_Dispositivo ( usuario_id INT NOT NULL, dispositivo_id INT NOT NULL,

PRIMARY KEY (usuario_id, dispositivo_id),

FOREIGN KEY (usuario_id) 
    REFERENCES Usuario(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

FOREIGN KEY (dispositivo_id) 
    REFERENCES Dispositivo(id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

*/
