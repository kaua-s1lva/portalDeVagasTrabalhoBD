-- Tabela usuario
CREATE TABLE IF NOT EXISTS usuario (
  idUsuario INT PRIMARY KEY,
  nome VARCHAR(1000) NOT NULL,
  email VARCHAR(1000) NOT NULL,
  senha VARCHAR(1000) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  update_at TIMESTAMP,
  deleted_at TIMESTAMP
);

-- Tabela empresa
CREATE TABLE IF NOT EXISTS empresa (
  idEmpresa INT PRIMARY KEY,
  cnpj CHAR(14) NOT NULL,
  CONSTRAINT fk_empresa_usuario1 FOREIGN KEY (idEmpresa)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela aluno
CREATE TABLE IF NOT EXISTS aluno (
  idAluno INT PRIMARY KEY,
  cpf CHAR(11) NOT NULL,
  CONSTRAINT fk_aluno_usuario1 FOREIGN KEY (idAluno)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela egresso
CREATE TABLE IF NOT EXISTS egresso (
  idEgresso INT PRIMARY KEY,
  idEmpresa INT NOT NULL,
  cpf CHAR(11) NOT NULL,
  CONSTRAINT fk_egresso_usuario1 FOREIGN KEY (idEgresso)
    REFERENCES usuario (idUsuario) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_egresso_empresa1 FOREIGN KEY (idEmpresa)
    REFERENCES empresa (idEmpresa) ON DELETE CASCADE ON UPDATE CASCADE
);


-- Tabela etapa
CREATE TABLE IF NOT EXISTS etapa (
  idEtapa INT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP
);

-- Tabela vaga
CREATE TABLE IF NOT EXISTS vaga (
  idVaga INT PRIMARY KEY,
  etapa_idEtapa INT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  cargo VARCHAR(1000) NOT NULL,
  empresa_idEmpresa INT NOT NULL,
  CONSTRAINT fk_vaga_status1 FOREIGN KEY (etapa_idEtapa)
    REFERENCES etapa (idEtapa) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_vaga_empresa1 FOREIGN KEY (empresa_idEmpresa)
    REFERENCES empresa (idEmpresa) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela situacao
CREATE TABLE IF NOT EXISTS situacao (
  idSituacao INT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela candidatura
CREATE TABLE IF NOT EXISTS candidatura (
  idVaga INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  curriculo BYTEA NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  situacao_idSituacao INT NOT NULL,
  PRIMARY KEY (idVaga, aluno_idAluno),
  CONSTRAINT fk_usuario_has_vaga_vaga1 FOREIGN KEY (idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_candidatura_status1 FOREIGN KEY (situacao_idSituacao)
    REFERENCES situacao (idSituacao) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_candidatura_aluno1 FOREIGN KEY (aluno_idAluno)
    REFERENCES aluno (idAluno) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela status
CREATE TABLE IF NOT EXISTS status (
  idstatus INT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela indicacao
CREATE TABLE IF NOT EXISTS indicacao (
  egresso_idEgresso INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  vaga_idVaga INT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  status_idStatus INT NOT NULL,
  PRIMARY KEY (egresso_idEgresso, aluno_idAluno, vaga_idVaga),
  CONSTRAINT fk_indicacao_egresso1 FOREIGN KEY (egresso_idEgresso)
    REFERENCES egresso (idEgresso) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_aluno1 FOREIGN KEY (aluno_idAluno)
    REFERENCES aluno (idAluno) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_vaga1 FOREIGN KEY (vaga_idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_indicacao_status1 FOREIGN KEY (status_idStatus)
    REFERENCES status (idstatus) ON DELETE CASCADE ON UPDATE CASCADE
);

-- Tabela requisito
CREATE TABLE IF NOT EXISTS requisito (
  idRequisito INT PRIMARY KEY,
  nome VARCHAR(1000) NOT NULL,
  duracao VARCHAR(1000)
);

-- Tabela vaga_requisito
CREATE TABLE IF NOT EXISTS vaga_requisito (
  vaga_idVaga INT NOT NULL,
  requisito_idRequisito INT NOT NULL,
  PRIMARY KEY (vaga_idVaga, requisito_idRequisito),
  CONSTRAINT fk_vaga_has_requisito_vaga1 FOREIGN KEY (vaga_idVaga)
    REFERENCES vaga (idVaga) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_vaga_has_requisito_requisito1 FOREIGN KEY (requisito_idRequisito)
    REFERENCES requisito (idRequisito) ON DELETE CASCADE ON UPDATE CASCADE
);
