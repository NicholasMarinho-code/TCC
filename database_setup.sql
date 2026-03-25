CREATE DATABASE IF NOT EXISTS Umidade;
USE Umidade;

CREATE TABLE IF NOT EXISTS Usuario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    emailCorp VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    funcao ENUM('Funcionario', 'Gerente') NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Dispositivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    localizacao VARCHAR(100) NOT NULL,
    status ENUM('Ativo', 'Inativo', 'Manutenção') DEFAULT 'Ativo',
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Usuario_Dispositivo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    dispositivo_id INT NOT NULL,
    data_vinculo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id) ON DELETE CASCADE,
    FOREIGN KEY (dispositivo_id) REFERENCES Dispositivo(id) ON DELETE CASCADE,
    UNIQUE KEY unique_vinculo (usuario_id, dispositivo_id)
);

CREATE TABLE IF NOT EXISTS Leitura (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dispositivo_id INT NOT NULL,
    temperatura DECIMAL(5,2) NOT NULL, 
    umidade DECIMAL(5,2) NOT NULL, 
    data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dispositivo_id) REFERENCES Dispositivo(id) ON DELETE CASCADE,
    INDEX idx_dispositivo_data (dispositivo_id, data_hora)
);

CREATE TABLE IF NOT EXISTS Alerta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    dispositivo_id INT NOT NULL,
    tipo ENUM('Temperatura', 'Umidade', 'Status') NOT NULL,
    mensagem TEXT NOT NULL,
    severidade ENUM('Baixa', 'Média', 'Alta') DEFAULT 'Média',
    status ENUM('Ativo', 'Resolvido') DEFAULT 'Ativo',
    data_alerta TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (dispositivo_id) REFERENCES Dispositivo(id) ON DELETE CASCADE
);

INSERT INTO Usuario (nome, emailCorp, senha, funcao) VALUES
('João Silva', 'joao.silva@empresa.com', '123456', 'Gerente'),
('Maria Santos', 'maria.santos@empresa.com', '123456', 'Funcionario'),
('Pedro Oliveira', 'pedro.oliveira@empresa.com', '123456', 'Funcionario');

INSERT INTO Dispositivo (nome, tipo, localizacao, status) VALUES
('Refrigerador Principal', 'Refrigerador', 'Cozinha Central', 'Ativo'),
('Freezer Industrial', 'Freezer', 'Área de Produção', 'Ativo'),
('Câmara Fria', 'Câmara', 'Depósito', 'Ativo');

INSERT INTO Usuario_Dispositivo (usuario_id, dispositivo_id) VALUES
(1, 1), (1, 2), (1, 3),
(2, 1), (2, 2),         
(3, 3);                

INSERT INTO Leitura (dispositivo_id, temperatura, umidade) VALUES
(1, 4.5, 65.2),
(1, 4.2, 66.8),
(2, -18.3, 45.1),
(3, 2.1, 70.5);

CREATE INDEX idx_usuario_email ON Usuario(emailCorp);
CREATE INDEX idx_dispositivo_status ON Dispositivo(status);
CREATE INDEX idx_leitura_data ON Leitura(data_hora);
CREATE INDEX idx_alerta_status ON Alerta(status);