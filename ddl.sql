CREATE SCHEMA IF NOT EXISTS bdportalvagas;

SET SCHEMA 'bdportalvagas';

-- Tabela usuario
CREATE TABLE IF NOT EXISTS bdportalvagas.usuario (
  idUsuario SERIAL PRIMARY KEY,
  nome VARCHAR(1000) NOT NULL,
  email VARCHAR(1000) NOT NULL,
  senha VARCHAR(1000) NOT NULL,
  created_at TIMESTAMP NOT NULL,
  update_at TIMESTAMP,
  deleted_at TIMESTAMP
);

-- Tabela etapa
CREATE TABLE IF NOT EXISTS bdportalvagas.etapa (
  idEtapa SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP
);

-- Tabela empresa
CREATE TABLE IF NOT EXISTS bdportalvagas.empresa (
  idEmpresa SERIAL PRIMARY KEY,
  cnpj CHAR(14) NOT NULL,
  CONSTRAINT fk_empresa_usuario1 FOREIGN KEY (idEmpresa)
    REFERENCES bdportalvagas.usuario (idUsuario) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela vaga
CREATE TABLE IF NOT EXISTS bdportalvagas.vaga (
  idVaga SERIAL PRIMARY KEY,
  etapa_idEtapa INT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  cargo VARCHAR(1000) NOT NULL,
  empresa_idEmpresa INT NOT NULL,
  CONSTRAINT fk_vaga_status1 FOREIGN KEY (etapa_idEtapa)
    REFERENCES bdportalvagas.etapa (idEtapa) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_vaga_empresa1 FOREIGN KEY (empresa_idEmpresa)
    REFERENCES bdportalvagas.empresa (idEmpresa) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela situacao
CREATE TABLE IF NOT EXISTS bdportalvagas.situacao (
  idSituacao SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela aluno
CREATE TABLE IF NOT EXISTS bdportalvagas.aluno (
  idAluno SERIAL PRIMARY KEY,
  cpf CHAR(11) NOT NULL,
  CONSTRAINT fk_aluno_usuario1 FOREIGN KEY (idAluno)
    REFERENCES bdportalvagas.usuario (idUsuario) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela candidatura
CREATE TABLE IF NOT EXISTS bdportalvagas.candidatura (
  idVaga INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  curriculo BYTEA NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  situacao_idSituacao INT NOT NULL,
  PRIMARY KEY (idVaga, aluno_idAluno),
  CONSTRAINT fk_usuario_has_vaga_vaga1 FOREIGN KEY (idVaga)
    REFERENCES bdportalvagas.vaga (idVaga) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_candidatura_status1 FOREIGN KEY (situacao_idSituacao)
    REFERENCES bdportalvagas.situacao (idSituacao) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_candidatura_aluno1 FOREIGN KEY (aluno_idAluno)
    REFERENCES bdportalvagas.aluno (idAluno) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela egresso
CREATE TABLE IF NOT EXISTS bdportalvagas.egresso (
  idEgresso SERIAL PRIMARY KEY,
  idEmpresa INT NOT NULL,
  cpf CHAR(11) NOT NULL,
  CONSTRAINT fk_egresso_usuario1 FOREIGN KEY (idEgresso)
    REFERENCES bdportalvagas.usuario (idUsuario) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_egresso_empresa1 FOREIGN KEY (idEmpresa)
    REFERENCES bdportalvagas.empresa (idEmpresa) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela status
CREATE TABLE IF NOT EXISTS bdportalvagas.status (
  idstatus SERIAL PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  descricao TEXT NOT NULL
);

-- Tabela indicacao
CREATE TABLE IF NOT EXISTS bdportalvagas.indicacao (
  egresso_idEgresso INT NOT NULL,
  aluno_idAluno INT NOT NULL,
  vaga_idVaga INT NOT NULL,
  created_at TIMESTAMP NOT NULL,
  updated_at TIMESTAMP,
  deleted_at TIMESTAMP,
  status_idStatus INT NOT NULL,
  PRIMARY KEY (egresso_idEgresso, aluno_idAluno, vaga_idVaga),
  CONSTRAINT fk_indicacao_egresso1 FOREIGN KEY (egresso_idEgresso)
    REFERENCES bdportalvagas.egresso (idEgresso) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_indicacao_aluno1 FOREIGN KEY (aluno_idAluno)
    REFERENCES bdportalvagas.aluno (idAluno) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_indicacao_vaga1 FOREIGN KEY (vaga_idVaga)
    REFERENCES bdportalvagas.vaga (idVaga) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_indicacao_status1 FOREIGN KEY (status_idStatus)
    REFERENCES bdportalvagas.status (idstatus) ON DELETE NO ACTION ON UPDATE NO ACTION
);

-- Tabela requisito
CREATE TABLE IF NOT EXISTS bdportalvagas.requisito (
  idRequisito SERIAL PRIMARY KEY,
  nome VARCHAR(1000) NOT NULL,
  duracao VARCHAR(1000)
);

-- Tabela vaga_requisito
CREATE TABLE IF NOT EXISTS bdportalvagas.vaga_requisito (
  vaga_idVaga INT NOT NULL,
  requisito_idRequisito INT NOT NULL,
  PRIMARY KEY (vaga_idVaga, requisito_idRequisito),
  CONSTRAINT fk_vaga_has_requisito_vaga1 FOREIGN KEY (vaga_idVaga)
    REFERENCES bdportalvagas.vaga (idVaga) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT fk_vaga_has_requisito_requisito1 FOREIGN KEY (requisito_idRequisito)
    REFERENCES bdportalvagas.requisito (idRequisito) ON DELETE NO ACTION ON UPDATE NO ACTION
);
