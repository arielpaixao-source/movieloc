# MovieLoc - Locadora de Filmes

PHP 8.3 + MVC + MySQL + Composer + Bootstrap 5

## Instalação
```bash
composer install
```

## Banco de Dados
Crie o banco `movieloc_db` copiando o SQL ao final deste README.
phpMyAdmin → SQL → cole e execute. Credenciais em `config/Database.php` (`root`/``).

Usuário teste: `admin@movieloc.com` / `admin123`

## Rodar
```bash
php -S 127.0.0.1:8000 -t public
# http://127.0.0.1:8000/index.php?page=login
```
No XAMPP aponte o DocumentRoot para `public/`.

## Erro comum
`SQLSTATE [2002] ... recusou ativamente` = MySQL desligado. Inicie o MySQL no XAMPP.

## Banco De Dados
```sql
CREATE DATABASE IF NOT EXISTS movieloc_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE movieloc_db;
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS locacoes;
DROP TABLE IF EXISTS filmes;
DROP TABLE IF EXISTS clientes;
DROP TABLE IF EXISTS usuarios;
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE filmes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    genero VARCHAR(50) NOT NULL,
    ano_lancamento INT NOT NULL,
    preco_locacao DECIMAL(6,2) NOT NULL,
    status ENUM('disponivel','alugado') NOT NULL DEFAULT 'disponivel',
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(60) NOT NULL,
    cpf VARCHAR(11) NOT NULL UNIQUE,
    telefone VARCHAR(11) NOT NULL,
    email VARCHAR(80) NOT NULL,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE locacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    filme_id INT NOT NULL,
    cliente_id INT NOT NULL,
    data_locacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_devolucao_prevista DATETIME NOT NULL,
    data_devolucao_real DATETIME NULL DEFAULT NULL,
    status ENUM('aberta','concluida','atrasada') NOT NULL DEFAULT 'aberta',
    CONSTRAINT fk_locacoes_filme FOREIGN KEY (filme_id) REFERENCES filmes(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT fk_locacoes_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_locacoes_filme (filme_id),
    INDEX idx_locacoes_cliente (cliente_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
SET FOREIGN_KEY_CHECKS = 1;
INSERT INTO filmes (titulo, genero, ano_lancamento, preco_locacao, status) VALUES
('Matrix', 'Ação', 1999, 9.90, 'disponivel'),
('O Poderoso Chefão', 'Drama', 1972, 12.50, 'disponivel'),
('Interestelar', 'Ficção', 2014, 14.90, 'disponivel');
INSERT INTO clientes (nome, cpf, telefone, email) VALUES
('Ariel França', '12345678901', '71999998888', 'ariel@exemplo.com'),
('Maria Silva', '10987654321', '71988887777', 'maria@exemplo.com');
INSERT INTO usuarios (nome, email, senha) VALUES
('Admin', 'admin@movieloc.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
```
