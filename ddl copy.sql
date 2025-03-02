-- Tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
  idUsuario SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT NULL,
  deleted_at TIMESTAMP DEFAULT NULL
);

-- Tabela empresa
CREATE TABLE IF NOT EXISTS empresa (
  idEmpresa INT PRIMARY KEY,
  cnpj CHAR(14) NOT NULL UNIQUE,
  CONSTRAINT fk_empresa_usuario FOREIGN KEY (idEmpresa)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela aluno
CREATE TABLE IF NOT EXISTS aluno (
  idAluno INT PRIMARY KEY,
  cpf CHAR(11) NOT NULL UNIQUE,
  CONSTRAINT fk_aluno_usuario FOREIGN KEY (idAluno)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela egresso
CREATE TABLE IF NOT EXISTS egresso (
  idEgresso INT PRIMARY KEY,
  idEmpresa INT NOT NULL,
  cpf CHAR(11) NOT NULL UNIQUE,
  CONSTRAINT fk_egresso_usuario FOREIGN KEY (idEgresso)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_egresso_empresa FOREIGN KEY (idEmpresa)
    REFERENCES empresa (idEmpresa) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela etapa
CREATE TABLE IF NOT EXISTS etapa (
  idEtapa SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT NULL
);

-- Tabela vaga
CREATE TABLE IF NOT EXISTS vaga (
  idVaga SERIAL PRIMARY KEY,
  etapa_idEtapa INT NOT NULL,
  empresa_idEmpresa INT NOT NULL,
  cargo VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT NULL,
  deleted_at TIMESTAMP DEFAULT NULL,
  CONSTRAINT fk_vaga_etapa FOREIGN KEY (etapa_idEtapa)
    REFERENCES etapa (idEtapa) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_vaga_empresa FOREIGN KEY (empresa_idEmpresa)
    REFERENCES empresa (idEmpresa) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela situacao
CREATE TABLE IF NOT EXISTS situacao (
  idSituacao SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela candidatura
CREATE TABLE IF NOT EXISTS candidatura (
  idVaga INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  curriculo BYTEA NOT NULL,
  situacao_idSituacao INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT NULL,
  deleted_at TIMESTAMP DEFAULT NULL,
  PRIMARY KEY (idVaga, aluno_idAluno),
  CONSTRAINT fk_candidatura_vaga FOREIGN KEY (idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_candidatura_situacao FOREIGN KEY (situacao_idSituacao)
    REFERENCES situacao (idSituacao) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_candidatura_aluno FOREIGN KEY (aluno_idAluno)
    REFERENCES aluno (idAluno) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela status
CREATE TABLE IF NOT EXISTS status (
  idStatus SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela indicacao
CREATE TABLE IF NOT EXISTS indicacao (
  egresso_idEgresso INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  vaga_idVaga INT NOT NULL,
  status_idStatus INT NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT NULL,
  deleted_at TIMESTAMP DEFAULT NULL,
  PRIMARY KEY (egresso_idEgresso, aluno_idAluno, vaga_idVaga),
  CONSTRAINT fk_indicacao_egresso FOREIGN KEY (egresso_idEgresso)
    REFERENCES egresso (idEgresso) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_aluno FOREIGN KEY (aluno_idAluno)
    REFERENCES aluno (idAluno) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_vaga FOREIGN KEY (vaga_idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_status FOREIGN KEY (status_idStatus)
    REFERENCES status (idStatus) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela requisito
CREATE TABLE IF NOT EXISTS requisito (
  idRequisito SERIAL PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  duracao VARCHAR(255)
);

-- Tabela vaga_requisito
CREATE TABLE IF NOT EXISTS vaga_requisito (
  vaga_idVaga INT NOT NULL,
  requisito_idRequisito INT NOT NULL,
  PRIMARY KEY (vaga_idVaga, requisito_idRequisito),
  CONSTRAINT fk_vaga_requisito_vaga FOREIGN KEY (vaga_idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_vaga_requisito_requisito FOREIGN KEY (requisito_idRequisito)
    REFERENCES requisito (idRequisito) ON DELETE CASCADE ON UPDATE CASCADE
);
