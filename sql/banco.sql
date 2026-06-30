-- ════════════════════════════════════════════════════════════
--  BASE DE DADOS: hospital_huambo
--  Sistema de Consultas — Hospital Geral do Huambo
-- ════════════════════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS hospital_huambo DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE hospital_huambo;

-- ── 1. Tabela de Pacientes ──
CREATE TABLE IF NOT EXISTS pacientes (
    id_paciente INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    bi VARCHAR(20) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(100),
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ── 2. Tabela de Médicos ──
CREATE TABLE IF NOT EXISTS medicos (
    id_medico INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    especialidade VARCHAR(100) NOT NULL,
    carteira_profissional VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ── 3. Tabela de Agendamentos (Consultas) ──
CREATE TABLE IF NOT EXISTS agendamentos (
    id_agendamento INT AUTO_INCREMENT PRIMARY KEY,
    id_paciente INT NOT NULL,
    id_medico INT NOT NULL,
    data_consulta DATE NOT NULL,
    hora_consulta TIME NOT NULL,
    motivo_consulta TEXT,
    status_agendamento VARCHAR(20) DEFAULT 'Pendente', -- Pendente, Confirmado, Realizado, Cancelado
    data_solicitacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente) ON DELETE CASCADE,
    FOREIGN KEY (id_medico) REFERENCES medicos(id_medico) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ── 4. Tabela de Resultados / Diagnósticos das Consultas ──
CREATE TABLE IF NOT EXISTS resultados_consultas (
    id_resultado INT AUTO_INCREMENT PRIMARY KEY,
    id_agendamento INT NOT NULL UNIQUE,
    diagnostico TEXT NOT NULL,
    receita TEXT,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_agendamento) REFERENCES agendamentos(id_agendamento) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ════════════════════════════════════════════════════════════
--  DADOS DE TESTE INICIAIS
-- ════════════════════════════════════════════════════════════

-- Paciente de Teste (Palavra-passe: 'paciente123')
INSERT INTO pacientes (nome, bi, telefone, email, senha) 
VALUES (
    'Manuel António', 
    '001234567HA040', 
    '923000000', 
    'paciente@exemplo.com', 
    '$2y$10$GLnZfz7HwNVspbdFNhbmBu39ttzUyU359si9eb26COtpGk91hy7gm'
) ON DUPLICATE KEY UPDATE id_paciente=id_paciente;

-- Médico de Teste (Palavra-passe: 'medico123')
INSERT INTO medicos (nome, especialidade, carteira_profissional, email, senha) 
VALUES (
    'João Baptista', 
    'Cardiologia', 
    'CRM-AO-12345', 
    'medico@hgh.ao', 
    '$2y$10$TvZHyo2C.wcZpXIg3Pv4XuxtP0iTrfJ.fBh0UvvdZJiH5RC3qXuWO'
) ON DUPLICATE KEY UPDATE id_medico=id_medico;
