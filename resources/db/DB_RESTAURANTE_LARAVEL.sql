-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 18/10/2025 às 22:42
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `restaurante_laravel`
--

DELIMITER $$
--
-- Procedimentos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientes_delete` (IN `p_cod_cliente` INT)   BEGIN
    DELETE FROM clientes WHERE cod_cliente = p_cod_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientes_insert` (IN `p_nome` VARCHAR(255), IN `p_telefone` VARCHAR(20), IN `p_cpf` VARCHAR(30), IN `p_rg` VARCHAR(30), IN `p_endereco` VARCHAR(255), IN `p_email` VARCHAR(255))   BEGIN
    INSERT INTO clientes(nome, telefone, cpf, rg, endereco, email)
    VALUES (p_nome, p_telefone, p_cpf, p_rg, p_endereco, p_email);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clientes_update` (IN `p_cod_cliente` INT, IN `p_nome` VARCHAR(255), IN `p_telefone` VARCHAR(20), IN `p_cpf` VARCHAR(30), IN `p_rg` VARCHAR(30), IN `p_endereco` VARCHAR(255), IN `p_email` VARCHAR(255))   BEGIN
    UPDATE clientes
    SET nome = p_nome,
        telefone = p_telefone,
        cpf = p_cpf,
        rg = p_rg,
        endereco = p_endereco,
        email = p_email
    WHERE cod_cliente = p_cod_cliente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_composicao_delete` (IN `p_cod_ingrediente` INT, IN `p_cod_prato` INT)   BEGIN
    DELETE FROM composicao
    WHERE cod_ingrediente = p_cod_ingrediente AND cod_prato = p_cod_prato;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_composicao_insert` (IN `p_cod_ingrediente` INT, IN `p_cod_prato` INT, IN `p_quantidade` INT)   BEGIN
    DECLARE v_exist INT;
    DECLARE v_valor_unitario DOUBLE;

    SELECT COUNT(*) INTO v_exist
    FROM composicao
    WHERE cod_ingrediente = p_cod_ingrediente AND cod_prato = p_cod_prato;

    SELECT valor_unitario INTO v_valor_unitario
    FROM ingredientes
    WHERE cod_ingrediente = p_cod_ingrediente
    LIMIT 1;

    IF v_exist > 0 THEN
        UPDATE composicao
        SET quantidade = quantidade + p_quantidade
        WHERE cod_ingrediente = p_cod_ingrediente AND cod_prato = p_cod_prato;
    ELSE
        INSERT INTO composicao(cod_ingrediente, cod_prato, quantidade, valor_unitario)
        VALUES (p_cod_ingrediente, p_cod_prato, p_quantidade, v_valor_unitario);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_composicao_update` (IN `p_cod_ingrediente` INT, IN `p_cod_prato` INT, IN `p_quantidade` INT)   BEGIN
    UPDATE composicao
    SET quantidade = p_quantidade
    WHERE cod_ingrediente = p_cod_ingrediente AND cod_prato = p_cod_prato;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_estoque_add` (IN `p_cod_ingrediente` INT, IN `p_quantidade` INT)   BEGIN
    UPDATE ingredientes
    SET quantidade_estoque = quantidade_estoque + p_quantidade
    WHERE cod_ingrediente = p_cod_ingrediente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_estoque_set` (IN `p_cod_ingrediente` INT, IN `p_quantidade` INT)   BEGIN
    UPDATE ingredientes
    SET quantidade_estoque = p_quantidade
    WHERE cod_ingrediente = p_cod_ingrediente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_estoque_subtract` (IN `p_cod_ingrediente` INT, IN `p_quantidade` INT)   BEGIN
    UPDATE ingredientes
    SET quantidade_estoque = quantidade_estoque - p_quantidade
    WHERE cod_ingrediente = p_cod_ingrediente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ingredientes_delete` (IN `p_cod_ingrediente` INT)   BEGIN
    DELETE FROM ingredientes WHERE cod_ingrediente = p_cod_ingrediente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ingredientes_insert` (IN `p_descricao` VARCHAR(30), IN `p_unidade` TINYINT, IN `p_valor_unitario` DOUBLE)   BEGIN
    INSERT INTO ingredientes(descricao, unidade, valor_unitario, quantidade_estoque)
    VALUES (p_descricao, p_unidade, p_valor_unitario, 0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ingredientes_update` (IN `p_cod_ingrediente` INT, IN `p_descricao` VARCHAR(30), IN `p_unidade` TINYINT, IN `p_valor_unitario` DOUBLE)   BEGIN
    UPDATE ingredientes
    SET descricao = p_descricao,
        unidade = p_unidade,
        valor_unitario = p_valor_unitario
    WHERE cod_ingrediente = p_cod_ingrediente;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_itens_pedido_delete` (IN `p_cod_pedido` INT, IN `p_cod_prato` INT)   BEGIN
    DECLARE v_status TINYINT;

    SELECT status INTO v_status
    FROM pedidos
    WHERE cod_pedido = p_cod_pedido;

    IF v_status = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pedido finalizado, não é possível remover itens';
    END IF;

    DELETE FROM itens_pedido
    WHERE cod_pedido = p_cod_pedido AND cod_prato = p_cod_prato;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_itens_pedido_insert` (IN `p_cod_pedido` INT, IN `p_cod_prato` INT, IN `p_quantidade` INT)   BEGIN
    DECLARE v_exist INT;
    DECLARE v_valor_unitario DOUBLE;
    DECLARE v_status TINYINT;

    SELECT status INTO v_status
    FROM pedidos
    WHERE cod_pedido = p_cod_pedido;

    IF v_status = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pedido finalizado, não é possível inserir itens';
    END IF;

    SELECT valor_unitario INTO v_valor_unitario
    FROM pratos
    WHERE cod_prato = p_cod_prato
    LIMIT 1;

    SELECT COUNT(*) INTO v_exist
    FROM itens_pedido
    WHERE cod_pedido = p_cod_pedido AND cod_prato = p_cod_prato;

    IF v_exist > 0 THEN
        UPDATE itens_pedido
        SET quantidade = quantidade + p_quantidade
        WHERE cod_pedido = p_cod_pedido AND cod_prato = p_cod_prato;
    ELSE
        INSERT INTO itens_pedido(cod_pedido, cod_prato, quantidade, valor_unitario)
        VALUES (p_cod_pedido, p_cod_prato, p_quantidade, v_valor_unitario);
    END IF;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_itens_pedido_update` (IN `p_cod_pedido` INT, IN `p_cod_prato` INT, IN `p_nova_quantidade` INT)   BEGIN
    DECLARE v_status TINYINT;

    SELECT status INTO v_status
    FROM pedidos
    WHERE cod_pedido = p_cod_pedido;

    IF v_status = 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pedido finalizado, não é possível alterar itens';
    END IF;

    UPDATE itens_pedido
    SET quantidade = p_nova_quantidade
    WHERE cod_pedido = p_cod_pedido AND cod_prato = p_cod_prato;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos_delete` (IN `p_cod_pedido` INT)   BEGIN
    DELETE FROM pedidos WHERE cod_pedido = p_cod_pedido;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos_finalize` (IN `p_cod_pedido` INT)   BEGIN
    UPDATE pedidos
    SET status = 1
    WHERE cod_pedido = p_cod_pedido;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos_insert` (IN `p_cod_cliente` INT)   BEGIN
    INSERT INTO pedidos(cod_cliente, valor_total, status)
    VALUES (p_cod_cliente, 0, 0);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pedidos_update` (IN `p_cod_pedido` INT, IN `p_cod_cliente` INT)   BEGIN
    UPDATE pedidos
    SET cod_cliente = p_cod_cliente
    WHERE cod_pedido = p_cod_pedido;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pratos_delete` (IN `p_cod_prato` INT)   BEGIN
    DELETE FROM pratos WHERE cod_prato = p_cod_prato;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pratos_insert` (IN `p_descricao` VARCHAR(30), IN `p_valor_unitario` DOUBLE)   BEGIN
    INSERT INTO pratos(descricao, valor_unitario)
    VALUES (p_descricao, p_valor_unitario);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_pratos_update` (IN `p_cod_prato` INT, IN `p_descricao` VARCHAR(30), IN `p_valor_unitario` DOUBLE)   BEGIN
    UPDATE pratos
    SET descricao = p_descricao,
        valor_unitario = p_valor_unitario
    WHERE cod_prato = p_cod_prato;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `cod_cliente` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `telefone` varchar(20) DEFAULT NULL,
  `cpf` varchar(30) NOT NULL,
  `rg` varchar(30) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`cod_cliente`, `nome`, `telefone`, `cpf`, `rg`, `endereco`, `email`) VALUES
(1, 'Ana Souza', '11987654321', '123.456.789-00', '12.345.678-9', 'Rua das Flores, 123', 'ana.souza@email.com'),
(2, 'Carlos Pereira', '21988776655', '987.654.321-00', '98.765.432-1', 'Av. Brasil, 2000', 'carlos.pereira@email.com'),
(3, 'Mariana Oliveira', '31999887766', '456.789.123-00', '45.678.912-3', 'Rua Central, 500', 'mariana.oliveira@email.com'),
(4, 'João Silva', '11999998888', '321.654.987-00', '32.165.498-7', 'Rua Bela Vista, 45', 'joao.silva@email.com'),
(5, 'Beatriz Santos', '11977776666', '654.321.987-00', '65.432.198-7', 'Av. Paulista, 100', 'beatriz.santos@email.com');

-- --------------------------------------------------------

--
-- Estrutura para tabela `composicao`
--

CREATE TABLE `composicao` (
  `cod_ingrediente` int(11) NOT NULL,
  `cod_prato` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 0,
  `valor_unitario` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `composicao`
--

INSERT INTO `composicao` (`cod_ingrediente`, `cod_prato`, `quantidade`, `valor_unitario`) VALUES
(1, 1, 1, 8.5),
(2, 1, 1, 10),
(2, 2, 1, 10),
(3, 1, 1, 15),
(3, 3, 1, 15),
(4, 4, 2, 7),
(5, 5, 3, 1.5);

-- --------------------------------------------------------

--
-- Estrutura para tabela `ingredientes`
--

CREATE TABLE `ingredientes` (
  `cod_ingrediente` int(11) NOT NULL,
  `descricao` varchar(30) NOT NULL,
  `unidade` tinyint(1) NOT NULL COMMENT '0 = unidade; 1 = kg;',
  `valor_unitario` double DEFAULT 0,
  `quantidade_estoque` int(30) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `ingredientes`
--

INSERT INTO `ingredientes` (`cod_ingrediente`, `descricao`, `unidade`, `valor_unitario`, `quantidade_estoque`) VALUES
(1, 'Arroz', 1, 8.5, 50),
(2, 'Feijão', 1, 10, 40),
(3, 'Frango', 1, 15, 23),
(4, 'Batata', 1, 7, 30),
(5, 'Ovo', 0, 1.5, 100);

-- --------------------------------------------------------

--
-- Estrutura para tabela `itens_pedido`
--

CREATE TABLE `itens_pedido` (
  `cod_pedido` int(11) NOT NULL,
  `cod_prato` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT 1,
  `valor_unitario` double NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `itens_pedido`
--

INSERT INTO `itens_pedido` (`cod_pedido`, `cod_prato`, `quantidade`, `valor_unitario`) VALUES
(1, 1, 2, 25),
(2, 5, 1, 15),
(3, 2, 1, 35),
(4, 3, 1, 28),
(5, 4, 2, 12),
(6, 3, 2, 28);

--
-- Acionadores `itens_pedido`
--
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_after_delete` AFTER DELETE ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_cod_ingrediente INT;
    DECLARE v_qtd_necessaria INT;

    DECLARE cur CURSOR FOR
        SELECT c.cod_ingrediente, c.quantidade
        FROM composicao c
        WHERE c.cod_prato = OLD.cod_prato;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_cod_ingrediente, v_qtd_necessaria;
        IF done THEN
            LEAVE read_loop;
        END IF;

        UPDATE ingredientes
        SET quantidade_estoque = quantidade_estoque + (v_qtd_necessaria * OLD.quantidade)
        WHERE cod_ingrediente = v_cod_ingrediente;
    END LOOP;
    CLOSE cur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_after_insert` AFTER INSERT ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_cod_ingrediente INT;
    DECLARE v_qtd_necessaria INT;

    DECLARE cur CURSOR FOR
        SELECT c.cod_ingrediente, c.quantidade
        FROM composicao c
        WHERE c.cod_prato = NEW.cod_prato;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_cod_ingrediente, v_qtd_necessaria;
        IF done THEN
            LEAVE read_loop;
        END IF;

        UPDATE ingredientes
        SET quantidade_estoque = quantidade_estoque - (v_qtd_necessaria * NEW.quantidade)
        WHERE cod_ingrediente = v_cod_ingrediente;
    END LOOP;
    CLOSE cur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_after_update` AFTER UPDATE ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_cod_ingrediente INT;
    DECLARE v_qtd_necessaria INT;
    DECLARE v_diferenca INT;

    -- Cursor e handler (sempre antes de qualquer IF ou LOOP)
    DECLARE cur CURSOR FOR
        SELECT cod_ingrediente, quantidade
        FROM composicao
        WHERE cod_prato = NEW.cod_prato;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- Calcula diferença (nova qtd - antiga)
    SET v_diferenca = NEW.quantidade - OLD.quantidade;

    -- Só faz algo se houver diferença
    IF v_diferenca <> 0 THEN
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_cod_ingrediente, v_qtd_necessaria;
            IF done THEN
                LEAVE read_loop;
            END IF;

            -- Se aumentou a quantidade de pratos, subtrai do estoque
            -- Se diminuiu, soma de volta ao estoque
            IF v_diferenca > 0 THEN
                UPDATE ingredientes
                SET quantidade_estoque = quantidade_estoque - (v_qtd_necessaria * v_diferenca)
                WHERE cod_ingrediente = v_cod_ingrediente;
            ELSE
                UPDATE ingredientes
                SET quantidade_estoque = quantidade_estoque + (v_qtd_necessaria * ABS(v_diferenca))
                WHERE cod_ingrediente = v_cod_ingrediente;
            END IF;

        END LOOP;
        CLOSE cur;
    END IF;

END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_before_insert` BEFORE INSERT ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_cod_ingrediente INT;
    DECLARE v_qtd_necessaria INT;
    DECLARE v_estoque_atual INT;
    DECLARE v_msg VARCHAR(255);

    DECLARE cur CURSOR FOR
        SELECT c.cod_ingrediente, c.quantidade
        FROM composicao c
        WHERE c.cod_prato = NEW.cod_prato;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;
    read_loop: LOOP
        FETCH cur INTO v_cod_ingrediente, v_qtd_necessaria;
        IF done THEN
            LEAVE read_loop;
        END IF;

        SET v_estoque_atual = (
            SELECT quantidade_estoque
            FROM ingredientes
            WHERE cod_ingrediente = v_cod_ingrediente
        );

        -- Verifica se há estoque suficiente
        IF v_estoque_atual < (v_qtd_necessaria * NEW.quantidade) THEN
            SET v_msg = CONCAT('Estoque insuficiente para o ingrediente ', v_cod_ingrediente);
            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_msg;
        END IF;
    END LOOP;
    CLOSE cur;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_before_update` BEFORE UPDATE ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE v_cod_ingrediente INT;
    DECLARE v_qtd_necessaria INT;
    DECLARE v_estoque_atual INT;
    DECLARE v_diferenca INT;
    DECLARE v_msg VARCHAR(255);

    DECLARE cur CURSOR FOR
        SELECT c.cod_ingrediente, c.quantidade
        FROM composicao c
        WHERE c.cod_prato = NEW.cod_prato;

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    -- diferença: quanto precisamos A MAIS (se for negativa, não precisa checar)
    SET v_diferenca = NEW.quantidade - OLD.quantidade;

    IF v_diferenca > 0 THEN
        OPEN cur;
        read_loop: LOOP
            FETCH cur INTO v_cod_ingrediente, v_qtd_necessaria;
            IF done THEN
                LEAVE read_loop;
            END IF;

            SELECT quantidade_estoque INTO v_estoque_atual
            FROM ingredientes
            WHERE cod_ingrediente = v_cod_ingrediente
            LIMIT 1;

            IF v_estoque_atual < (v_qtd_necessaria * v_diferenca) THEN
                SET v_msg = CONCAT('Estoque insuficiente para ingrediente ', v_cod_ingrediente);
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = v_msg;
            END IF;
        END LOOP;
        CLOSE cur;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_valor_total_after_delete` AFTER DELETE ON `itens_pedido` FOR EACH ROW BEGIN
    UPDATE pedidos
    SET valor_total = valor_total - (OLD.valor_unitario * OLD.quantidade)
    WHERE cod_pedido = OLD.cod_pedido;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_valor_total_after_insert` AFTER INSERT ON `itens_pedido` FOR EACH ROW BEGIN
    UPDATE pedidos
    SET valor_total = valor_total + (NEW.valor_unitario * NEW.quantidade)
    WHERE cod_pedido = NEW.cod_pedido;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_itens_pedido_valor_total_after_update` AFTER UPDATE ON `itens_pedido` FOR EACH ROW BEGIN
    DECLARE v_diferenca INT;
    SET v_diferenca = NEW.quantidade - OLD.quantidade;

    UPDATE pedidos
    SET valor_total = valor_total + (v_diferenca * NEW.valor_unitario)
    WHERE cod_pedido = NEW.cod_pedido;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedidos`
--

CREATE TABLE `pedidos` (
  `cod_pedido` int(11) NOT NULL,
  `cod_cliente` int(11) NOT NULL,
  `valor_total` double NOT NULL DEFAULT 0,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - em andamento; 1 - finalizado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedidos`
--

INSERT INTO `pedidos` (`cod_pedido`, `cod_cliente`, `valor_total`, `status`) VALUES
(1, 1, 60, 1),
(2, 2, 25, 0),
(3, 3, 47, 1),
(4, 4, 35, 1),
(5, 5, 12, 0),
(6, 2, 56, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pratos`
--

CREATE TABLE `pratos` (
  `cod_prato` int(11) NOT NULL,
  `descricao` varchar(30) NOT NULL,
  `valor_unitario` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pratos`
--

INSERT INTO `pratos` (`cod_prato`, `descricao`, `valor_unitario`) VALUES
(1, 'Prato Executivo', 25),
(2, 'Feijoada Completa', 35),
(3, 'Frango Grelhado', 28),
(4, 'Batata Frita', 12),
(5, 'Omelete Simples', 15);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`cod_cliente`);

--
-- Índices de tabela `composicao`
--
ALTER TABLE `composicao`
  ADD PRIMARY KEY (`cod_ingrediente`,`cod_prato`),
  ADD KEY `fk_composicao_prato` (`cod_prato`);

--
-- Índices de tabela `ingredientes`
--
ALTER TABLE `ingredientes`
  ADD PRIMARY KEY (`cod_ingrediente`);

--
-- Índices de tabela `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD PRIMARY KEY (`cod_pedido`,`cod_prato`),
  ADD KEY `fk_itens_pedido_prato` (`cod_prato`);

--
-- Índices de tabela `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`cod_pedido`),
  ADD KEY `fk_pedidos_cliente` (`cod_cliente`);

--
-- Índices de tabela `pratos`
--
ALTER TABLE `pratos`
  ADD PRIMARY KEY (`cod_prato`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `cod_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `ingredientes`
--
ALTER TABLE `ingredientes`
  MODIFY `cod_ingrediente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `cod_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `pratos`
--
ALTER TABLE `pratos`
  MODIFY `cod_prato` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `composicao`
--
ALTER TABLE `composicao`
  ADD CONSTRAINT `fk_composicao_ingrediente` FOREIGN KEY (`cod_ingrediente`) REFERENCES `ingredientes` (`cod_ingrediente`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_composicao_prato` FOREIGN KEY (`cod_prato`) REFERENCES `pratos` (`cod_prato`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `itens_pedido`
--
ALTER TABLE `itens_pedido`
  ADD CONSTRAINT `fk_itens_pedido_pedido` FOREIGN KEY (`cod_pedido`) REFERENCES `pedidos` (`cod_pedido`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itens_pedido_prato` FOREIGN KEY (`cod_prato`) REFERENCES `pratos` (`cod_prato`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `fk_pedidos_cliente` FOREIGN KEY (`cod_cliente`) REFERENCES `clientes` (`cod_cliente`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
