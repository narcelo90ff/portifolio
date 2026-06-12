CREATE DATABASE IF NOT EXISTS gamestore;
USE gamestore;

-- =====================
-- TABELA USUARIOS
-- =====================

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    cpf VARCHAR(14) NOT NULL UNIQUE,
    data_nascimento DATE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('admin','usuario') DEFAULT 'usuario',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================
-- TABELA CATEGORIAS
-- =====================

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
);

-- =====================
-- TABELA JOGOS
-- =====================

CREATE TABLE jogos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10,2) NOT NULL,
    imagem VARCHAR(255),
    categoria_id INT NULL,

    CONSTRAINT fk_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
    ON DELETE SET NULL
);

CREATE TABLE carrinho (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    jogo_id INT NOT NULL,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (jogo_id) REFERENCES jogos(id)
    ON DELETE CASCADE
);

-- =====================
-- DADOS INICIAIS
-- =====================

INSERT INTO categorias (nome)
VALUES
('Ação'),
('RPG'),
('Corrida'),
('Terror'),
('Esportes');

INSERT INTO jogos
(titulo, descricao, preco, imagem, categoria_id)
VALUES
(
'Resident Evil 9: Requiem',
'Enfrente o terror absoluto na pele de Leon Kennedy em uma nova e sombria jornada de sobrevivência.',
120.90,
're.jpg',
4
),
(
'Marvel\'s Wolverine',
'Torne-se uma arma viva em uma nova experiência brutal da Marvel.',
99.90,
'wolverine.jpg',
1
),
(
'GTA V',
'Um dos jogos mais jogados do mundo com mundo aberto gigante.',
129.90,
'gta.jpg',
1
),
(
'Minecraft',
'Explore, construa e sobreviva em mundos infinitos.',
89.90,
'minecraft.jpg',
2
),
(
'EA FC 25',
'O simulador de futebol mais realista da nova geração.',
249.90,
'fc25.jpg',
5
);

